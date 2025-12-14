<?php

namespace App\Http\Controllers\buy;

use Illuminate\Http\Request;
use App\Models\Buy\GoodsReceipt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Buy\GoodsReceiptRepository;
use App\Repositories\Buy\PurchaseOrderRepository;
use App\Repositories\Buy\StockMovementRepository;
use App\Repositories\Buy\GoodsReceiptLineRepository;
use App\Repositories\Buy\PurchaseOrderLineRepository;

class GoodsReceiptController extends Controller
{
    private $goodsReceiptRepository;
    private $goodsReceiptLineRepository;
    private $purchaseOrderRepository;
    private $stockMovementRepository;
    private $productRepository;
    private $purchaseOrderLineRepository;

    public function __construct(
        GoodsReceiptRepository $goodsReceiptRepository,
        GoodsReceiptLineRepository $goodsReceiptLineRepository,
        PurchaseOrderRepository $purchaseOrderRepository,
        StockMovementRepository $stockMovementRepository,
        ProductRepository $productRepository,
        PurchaseOrderLineRepository $purchaseOrderLineRepository
    ) {
        $this->goodsReceiptRepository = $goodsReceiptRepository;
        $this->goodsReceiptLineRepository = $goodsReceiptLineRepository;
        $this->purchaseOrderRepository = $purchaseOrderRepository;
        $this->stockMovementRepository = $stockMovementRepository;
        $this->productRepository = $productRepository;
        $this->purchaseOrderLineRepository = $purchaseOrderLineRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        toggleDatabase();
        $receipts = $this->goodsReceiptRepository->getAll();
        return view('admin.achat.reception.index', compact('receipts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        toggleDatabase();
        $commands = $this->purchaseOrderRepository->getDataToReceipt();
        // dd($commands);
        return view('admin.achat.reception.create', compact('commands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        toggleDatabase();
        try {
            $inputReceipts = $request->except(['lines']);
            $inputReceipts['receipt_number'] = generateInvoiceNumber('goods_receipts', 'BR', true, 'receipt_number');
            $inputReceipts['created_by'] = $user->name;

            DB::beginTransaction();
            $receipt = $this->goodsReceiptRepository->store($inputReceipts);

            if ($request->status != 'draft') {
                $this->purchaseOrderRepository->update($receipt->purchase_order_id, ['status' => $request->status]);
            }
            $lines = $request->lines;
            foreach ($lines as $key => $line) {
                $line['goods_receipt_id'] = $receipt->id;
                $this->goodsReceiptLineRepository->store($line);
                #Mvt de stock
                if ($request->status != 'draft') {
                    $stockMovementData = [
                        'product_id' => $line['product_id'],
                        'goods_receipt_id' => $receipt->id,
                        'movement_type' => 'in',
                        'quantity' => $line['quantity_received'],
                        'reference' => $receipt->receipt_number,
                        'to_location' => '', 
                        'notes' => $line['observation'] ?? '',
                    ];
                    $this->stockMovementRepository->store($stockMovementData);
                    # Update product stock quantity
                    $prod = $this->productRepository->getById($line['product_id']);
                    $this->productRepository->update($line['product_id'], ['stock_quantity' => $prod->stock_quantity + $line['quantity_received']]);

                    #update line in purchase order line
                    $OrderLine = $this->purchaseOrderLineRepository->getById($line['line_id']);
                    $datas = [
                        'received_quantity' => $line['quantity_received'] + $OrderLine->received_quantity,
                        'remaining_quantity' => $line['remaining_quantity'],
                    ];
                    $this->purchaseOrderLineRepository->update($line['line_id'], $datas);
                }
            }


            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Bon enregistré avec succès"
            ], 201);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info("ERROR GOOD RECEIPT : " . $th);
            return response()->json([
                'success' => false,
                'message' => "Echec d'enregistrement du bon",
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GoodsReceipt $goodsReceipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GoodsReceipt $goodsReceipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GoodsReceipt $goodsReceipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GoodsReceipt $goodsReceipt)
    {
        //
    }


}
