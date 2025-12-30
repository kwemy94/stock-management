<?php

namespace App\Http\Controllers\Sale;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Setting\SettingRepository;
use App\Repositories\Sale\SaleInvoiceRepository;
use App\Repositories\Sale\SalePaymentRepository;
use App\Repositories\Customer\CustomerRepository;
use App\Repositories\Sale\SaleInvoiceLineRepository;
use Illuminate\Database\Events\TransactionBeginning;
use App\Repositories\PaymentMode\PaymentModeRepository;

class SaleInvoiceController extends Controller
{
    private $saleInvoiceRepository;
    private $customerRepository;
    private $productRepository;
    private $paymentModeRepository;
    private $saleInvoiceLineRepository;
    private $salePaymentRepository;
    private $settingRepository;

    public function __construct(
        SaleInvoiceRepository $saleInvoiceRepository,
        CustomerRepository $customerRepository,
        ProductRepository $productRepository,
        PaymentModeRepository $paymentModeRepository,
        SaleInvoiceLineRepository $saleInvoiceLineRepository,
        SalePaymentRepository $salePaymentRepository,
        SettingRepository $settingRepository
    ) {
        $this->middleware('can:view command details')->only(['show']);
        $this->middleware('can:print command')->only(['printInvoice']);
        $this->middleware('can:update sale invoice')->only(['edit', 'update']);
        // $this->middleware('can:confirm sale invoice')->only(['confirmInvoice']);
        $this->saleInvoiceRepository = $saleInvoiceRepository;
        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
        $this->paymentModeRepository = $paymentModeRepository;
        $this->saleInvoiceLineRepository = $saleInvoiceLineRepository;
        $this->salePaymentRepository = $salePaymentRepository;
        $this->settingRepository = $settingRepository;
    }

    public function index(Request $request)
    {
        $type = $request->type;
        // dd($request->all(), $type);
        if (!$type) {
            abort_if(
                !auth()->user()->hasPermissionTo('manage sales'),
                403
            );
        } else {
            abort_if(
                !auth()->user()->hasPermissionTo('view command list'),
                403
            );

        }

        toggleDatabase();
        $saleInvoices = $this->saleInvoiceRepository->getAll();

        $draftInvoices = $this->saleInvoiceRepository->getDraftInvoice();
        $confirmInvoices = $this->saleInvoiceRepository->getConfirmInvoice();
        $devisInvoices = $this->saleInvoiceRepository->getDevisInvoice();
        $paymentModes = $this->paymentModeRepository->getAll();

        switch ($type) {
            case 'draft':
                $result = view('admin.sale.invoice.index_draft', compact('draftInvoices', 'paymentModes'));
                break;
            case 'confirm':
                $result = view('admin.sale.invoice.index_confirm', compact('confirmInvoices', 'paymentModes'));
                break;
            case 'proforma':
                $result = view('admin.sale.invoice.index_proforma', compact('devisInvoices', 'paymentModes'));
                break;

            default:
                $result = view('admin.sale.invoice.dashboard', compact('saleInvoices', 'draftInvoices', 'confirmInvoices', 'devisInvoices'));
                break;
        }

        return $result;
    }
    public function create(Request $request)
    {
        $type = $request->type;
        switch ($type) {
            case 'proforma':
                abort_if(
                    !auth()->user()->hasPermissionTo('create proforma'),
                    403
                );
                break;
            case 'facture':
                abort_if(
                    !auth()->user()->hasPermissionTo('create command'),
                    403
                );
                break;

            default:
                # code...
                break;
        }

        toggleDatabase();
        $saleInvoices = $this->saleInvoiceRepository->getAll();

        return view('admin.sale.invoice.create', compact('type'));
    }

    public function dataCreateInvoice()
    {
        toggleDatabase();
        $customers = $this->customerRepository->getAll();
        $products = $this->productRepository->getAll();
        $paymentModes = $this->paymentModeRepository->getAll();

        return response()->json([
            'customers' => $customers,
            'products' => $products,
            'paymentModes' => $paymentModes,
        ]);
    }

    public function store(Request $request)
    {
        $statut = $request->statut == 'proformat'? 'proforma': $request->statut;
        switch ($statut) {
            case 'proforma':
                abort_if(
                    !auth()->user()->hasPermissionTo('create proforma'),
                    403
                );
                break;
            case 'facture':
                abort_if(
                    !auth()->user()->hasPermissionTo('create command'),
                    403
                );
                break;

            default:
                # code...
                break;
        }
        try {
            toggleDatabase();
            $inputs = $request->except(['lines']);
            $lines = $request->lines;
            // dd($request->all());

            $invoiceInputs['customer_id'] = $inputs['client'];
            $invoiceInputs['date'] = $inputs['dateFacture'];
            $invoiceInputs['type_vente'] = 'detail';
            $invoiceInputs['montant_facture'] = $inputs['montantFacture'];
            $invoiceInputs['montant_encaisse'] = $inputs['montantEncaisse'];
            $invoiceInputs['montant_du'] = $inputs['montantDu'];
            // $invoiceInputs['status'] = $inputs['status'] == 1 ? 'confirmed' : 'draft';
            $invoiceInputs['status'] = $inputs['status'];
            // dd((int)$invoiceInputs['montant_du'], (int)$invoiceInputs['montant_du'] == 0 && $invoiceInputs['status'] == 'confirmed', $invoiceInputs);
            if ((int) $invoiceInputs['montant_du'] == 0 && $invoiceInputs['status'] == 'confirmed') {
                $invoiceInputs['status'] = 'Payé';
            }
            if ($invoiceInputs['status'] == 'proformat') {
                $invoiceInputs['invoice_number'] = generateInvoiceNumber('sale_invoices', 'PF', true);
            } else {
                $invoiceInputs['invoice_number'] = generateInvoiceNumber('sale_invoices', 'FV', true);
            }

            DB::beginTransaction();
            $invoice = $this->saleInvoiceRepository->store($invoiceInputs);

            #stock paiement
            if ($inputs['montantEncaisse'] > 0) {
                $payInputs['invoice_id'] = $invoice->id;
                $payInputs['mode_id'] = $request->modePaiement;
                $payInputs['montant'] = $inputs['montantEncaisse'];
                $payInputs['date'] = $inputs['dateFacture'];
                $this->salePaymentRepository->store($payInputs);
            }

            foreach ($lines as $line) {
                $line['invoice_id'] = $invoice->id;

                $prod = $this->productRepository->getById($line['product_id']);
                $line['buy_price'] = $prod->unit_price;
                // dd($prod, $line);
                $this->saleInvoiceLineRepository->store($line);

                if ($invoiceInputs['status'] == 'confirmed') {
                    #décrémenter le stock du produit
                    $qty = $prod->stock_quantity - $line['quantity'];
                    $this->productRepository->update($prod->id, ['stock_quantity' => $qty]);
                }
            }

            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Facture crée avec succès !"
            ], 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                "success" => false,
                "error" => $th->getMessage(),
                "message" => "Oups! Echec de création de la facture"
            ], 500);
        }
    }


    public function edit($id)
    {
        toggleDatabase();
        $invoice = $this->saleInvoiceRepository->getById($id);

        return view('admin.sale.invoice.edit', compact('invoice'));
    }


    public function update(Request $request, $id)
    {
        try {
            toggleDatabase();
            $inputs = $request->except(['lines']);
            $lines = $request->lines;
            // dd($request->all());

            $invoiceInputs['customer_id'] = $inputs['client'];
            $invoiceInputs['date'] = $inputs['dateFacture'];
            $invoiceInputs['type_vente'] = 'detail';
            $invoiceInputs['montant_facture'] = $inputs['montantFacture'];
            $invoiceInputs['montant_encaisse'] = $inputs['montantEncaisse'];
            $invoiceInputs['montant_du'] = $inputs['montantDu'];
            // $invoiceInputs['status'] = $inputs['status'] == 1 ? 'confirmed' : 'draft';
            $invoiceInputs['status'] = $inputs['status'];
            if ($invoiceInputs['montant_du'] == 0 && $invoiceInputs['status'] == 'confirmed') {
                $invoiceInputs['status'] = 'Payé';
            }
            // $invoiceInputs['invoice_number'] = generateInvoiceNumber('sale_invoices', 'FV', true);

            DB::beginTransaction();
            $invoice = $this->saleInvoiceRepository->update($id, $invoiceInputs);

            #stock paiement
            if ($inputs['montantEncaisse'] > 0) {
                $payInputs['invoice_id'] = $id;
                $payInputs['mode_id'] = $request->modePaiement;
                $payInputs['montant'] = $inputs['montantEncaisse'];
                $payInputs['date'] = $inputs['dateFacture'];
                $oldPayment = $this->salePaymentRepository->getByInvoiceId($id);
                if ($oldPayment) {
                    $this->salePaymentRepository->update($oldPayment->id, $payInputs);
                } else {
                    $this->salePaymentRepository->store($payInputs);
                }
            }

            $this->saleInvoiceLineRepository->destroyInvoiceLine($id);
            foreach ($lines as $line) {
                $line['invoice_id'] = $id;
                $prod = $this->productRepository->getById($line['product_id']);
                $line['buy_price'] = $prod->unit_price;

                $this->saleInvoiceLineRepository->store($line);

                if ($invoiceInputs['status'] == 'confirmed') {
                    #décrémenter le stock du produit
                    $qty = $prod->stock_quantity - $line['quantity'];
                    $this->productRepository->update($prod->id, ['stock_quantity' => $qty]);
                }
            }

            DB::commit();
            return response()->json([
                "success" => true,
                "message" => $invoiceInputs['status'] == 'proformat' ? "Dévis mis à jour avec succès" : "Facture crée avec succès !"
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                "success" => false,
                "error" => $th->getMessage(),
                "message" => "Oups! Echec de création de la facture"
            ], 500);
        }
    }


    public function rapport()
    {
        toggleDatabase();
        // $total = $this->salePaymentRepository->getTotal();
        $encaissements = $this->salePaymentRepository->getEncaissement();
        $chiffreAffaire = $this->saleInvoiceRepository->chiffreAffaire();
        // dd($chiffreAffaire, $encaissements);

        return $result = view('admin.sale.invoice.rapport', compact('encaissements', 'chiffreAffaire'));

    }

    public function payment(Request $request)
    {
        toggleDatabase();
        $inputs = $request->all();

        try {
            DB::beginTransaction();
            if ($inputs['amount_encaisse'] > 0) {
                $payInputs['invoice_id'] = $inputs['invoice_id'];
                $payInputs['mode_id'] = $inputs['mode_id'];
                $payInputs['montant'] = $inputs['amount_encaisse'];
                $payInputs['date'] = $inputs['date_pay'];
                $this->salePaymentRepository->store($payInputs);
            }
            // dd($inputs['amount_encaisse'] == $inputs['amount']);
            if ($inputs['amount_encaisse'] == $inputs['amount']) {
                $updateInputs['status'] = "Payé";
            }
            $invoice = $this->saleInvoiceRepository->getById($request->invoice_id);


            $updateInputs['montant_du'] = $invoice->montant_du - $inputs['amount_encaisse'];
            $updateInputs['montant_encaisse'] = $invoice->montant_encaisse + $inputs['amount_encaisse'];
            $this->saleInvoiceRepository->update($invoice->id, $updateInputs);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Echec de paiement " . $th->getMessage());
            return redirect()->back()->with("error", "Echec de paiement");
        }


        return redirect()->back()->with("success", "Paiement effectué avec succès");
    }

    public function show($id)
    {
        toggleDatabase();
        $invoice = $this->saleInvoiceRepository->getById($id);
        $paymentModes = $this->paymentModeRepository->getAll();
        // dd($invoice);
        return view('admin.sale.invoice.details', compact('invoice', 'paymentModes'));
    }

    public function confirmInvoice($id)
    {# la confirmation de la facture entraine le mvt de stock

        toggleDatabase();
         $invoice = $this->saleInvoiceRepository->getById($id);

        if($invoice->status == 'proformat'){
            abort_if(
                    !auth()->user()->hasPermissionTo('convert proforma to command'),
                    403
                );
        }else{
            abort_if(
                    !auth()->user()->hasPermissionTo('confirm sale invoice'),
                    403
                );
        }
        try {
            // $invoice = $this->saleInvoiceRepository->getById($id);
            if ($invoice->status == 'proformat') {
                $this->saleInvoiceRepository->update($id, ['status' => 'draft']);
                $message = 'Proformat validé avec succès';
            } else {
                DB::beginTransaction();
                $this->saleInvoiceRepository->update($id, ['status' => 'confirmed']);

                foreach ($invoice->invoiceLines as $key => $line) {
                    #décrémenter le stock du produit
                    $prod = $this->productRepository->getById($line->product_id);
                    $qty = $prod->stock_quantity - $line->quantity;
                    $this->productRepository->update($prod->id, ['stock_quantity' => $qty]);
                }
                DB::commit();
                $message = "Commande confirmée avec succès";
            }
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error("Echec confirmation facture : " . $th->getMessage());
            return redirect()->back()->with("error", "Echec de confirmation de la facture");
        }
        return redirect()->back()->with("success", $message);
    }


    public function printInvoice($id)
    {
        $user = Auth::user();
        toggleDatabase();
        try {
            $invoice = $this->saleInvoiceRepository->getById($id);
            $setting = $this->settingRepository->getFirstSetting();

            $qrContent = "Facture #{$invoice->invoice_number} | Montant: {$invoice?->montant_encaisse} FCFA";

            // dd($qrContent, $invoice);
            $qrCode = QrCode::size(150)->generate($qrContent);

            $data = [
                'invoice' => $invoice,
                'setting' => $setting,
                'user' => $user,
                'qrCode' => $qrCode
            ];

            $customPaper = array(0, 0, 792.00, 1224.00);
            // dd($data);
            // return view('admin.sale.invoice.print_invoice', $data);
            $pdf = PDF::loadView('admin.sale.invoice.print_invoice', $data)->setPaper($customPaper, 'portrait')->setWarnings(false);
            // return $pdf->download('command.pdf');
            return $pdf->stream();
        } catch (\Throwable $th) {
            Log::error("Echec impression facture : " . $th->getMessage());
            return redirect()->back()->with("error", "Erreur survenue");
        }
    }

}
