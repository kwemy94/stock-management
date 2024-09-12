<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Customer\CustomerRepository;

class CustomerController extends Controller
{
    private $customerRepository;
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
        toggleDBsqlite();
        $customers = $this->customerRepository->getAll();

        return view('admin.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        toggleDBsqlite();
        $validation = Validator::make(
            $request->all(),
            [
                'email' => 'required|unique:customers',
            ],
            [
                'email.unique' => 'Email dejà utilisée.',
            ]
        );

        if ($validation->fails()) {;
            dd($validation->errors());

            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        $inputs = $request->post();
        $inputs['user_id'] = Auth::user()->id;
        try {
            $this->customerRepository->store($inputs);

            return redirect()->route('customer.index')->with('success',"Utilisateur crée");
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error',"Oups!! Echec d'enregistrement");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        toggleDBsqlite();
        $customer = $this->customerRepository->getById($id);
        return view('admin.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        toggleDBsqlite();
        $customer = $this->customerRepository->getById($id);
        
        try {
            
            $inputs = $request->post();
            $this->customerRepository->update($customer->id, $inputs);

            return redirect()->route('customer.index')->with('success',"Utilisateur mis à jour!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error',"Oups!! Echec de mis à jour");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        toggleDBsqlite();
        $customer = $this->customerRepository->getById($id);

        try {
            $customer->delete();
            return redirect()->route('customer.index')->with('success',"Utilisateur supprimé!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error',"Oups!! Echec de suppression");
        }
    }
}
