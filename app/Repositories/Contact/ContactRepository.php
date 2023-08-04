<?php

namespace App\Repositories\Contact;

use App\Models\Contact;
use App\Repositories\ResourceRepository;

class ContactRepository extends ResourceRepository {

    public function __construct(Contact $contact) {
        $this->model = $contact;
    }

    public function getAll() 
    {
        return $this->model->get();
    }

}
