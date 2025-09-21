<?php

namespace App\Http\Controllers\Sale;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Sale\SaleInvoiceRepository;
use App\Repositories\Customer\CustomerRepository;
use Illuminate\Database\Events\TransactionBeginning;
use App\Repositories\PaymentMode\PaymentModeRepository;
use App\Repositories\Sale\SaleInvoiceLineRepository;
use App\Repositories\Sale\SalePaymentRepository;

class SaleInvoiceController extends Controller
{
    private $saleInvoiceRepository;
    private $customerRepository;
    private $productRepository;
    private $paymentModeRepository;
    private $saleInvoiceLineRepository;
    private $salePaymentRepository;

    public function __construct(
        SaleInvoiceRepository $saleInvoiceRepository,
        CustomerRepository $customerRepository,
        ProductRepository $productRepository,
        PaymentModeRepository $paymentModeRepository,
        SaleInvoiceLineRepository $saleInvoiceLineRepository,
        SalePaymentRepository $salePaymentRepository
    ) {
        $this->saleInvoiceRepository = $saleInvoiceRepository;
        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
        $this->paymentModeRepository = $paymentModeRepository;
        $this->saleInvoiceLineRepository = $saleInvoiceLineRepository;
        $this->salePaymentRepository = $salePaymentRepository;
    }

    public function index()
    {
        toggleDatabase();
        $saleInvoices = $this->saleInvoiceRepository->getAll();

        $draftInvoices = $this->saleInvoiceRepository->getDraftInvoice();
        $confirmInvoices = $this->saleInvoiceRepository->getConfirmInvoice();
        $devisInvoices = $this->saleInvoiceRepository->getDevisInvoice();

        return view('admin.sale.invoice.index', compact('saleInvoices', 'draftInvoices', 'confirmInvoices', 'devisInvoices'));
    }
    public function create($type = 'facture')
    {
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
            $invoiceInputs['invoice_number'] = generateInvoiceNumber('sale_invoices', 'FV', true);

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
                $this->saleInvoiceLineRepository->store($line);

                if ($invoiceInputs['status'] == 'Confirmé') {
                    #décrémenter le stock du produit
                    $prod = $this->productRepository->getById($line['product_id']);
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
}
