<?php

namespace App\Repositories\ProductSupplier;

use App\Models\ProductSupplier;
use Illuminate\Support\Facades\DB;
use App\Repositories\ResourceRepository;

class AchatRepository extends ResourceRepository {

    public function __construct(ProductSupplier $achat) {
        $this->model = $achat;
    }

    public function getAll() 
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

    public function getById($id) {
        return $this->model->with('product', 'supplier')->where('id', $id)->first();
    }

    public function getInventory(){
        toggleDatabase();
        return $this->model->groupBy('product_id')
            ->with('product')
            ->select('id', 'supplier_id', 'product_id', DB::raw('SUM(quantity) as total'))
            ->get();
        
    }

    public function deleteProductLine($productId){
        return $this->model->where('product_id', $productId)->delete();
    }

}
