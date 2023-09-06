<?php

namespace App\Repositories\Etablissement;

use App\Models\Etablissement;
use App\Repositories\ResourceRepository;

class EtablissementRepository extends ResourceRepository {

    public function __construct(Etablissement $etablissement) {
        $this->model = $etablissement;
    }

    public function getAll($status = 2) {
        return $this->model
            ->where('status', $status)
            //->orderBy('created_at', 'asc')
            ->orderBy('name', 'asc')
            ->get();
    }
    public function lastField() {
        toggleDatabase(false);
        return $this->model
            ->orderBy('name', 'asc')
            ->where('status',2)
            ->latest()
            ->first();
    }

    public function findByDomain($domain, $status = 2) {
        return $this->model
            ->where('domain', '=', $domain)
            ->where('status', $status)
            ->first();
    }


    public function getOne($status = 1) {
        return $this->model
            ->where('status', $status)
            ->orderBy('name', 'asc')
            ->first();
    }


    public function store($inputs) {
        
        // $etab = new Etablissement();
        $etab['name'] = $inputs['name'];
        $etab['email'] = $inputs['email'];
        $etab['status'] = 2;
        $etab['settings'] = json_encode($inputs['settings']);
        // $etab->save();

        return $this->model->create($etab) ;
    }

}
