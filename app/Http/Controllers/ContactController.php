<?php

namespace App\Http\Controllers;

use App\Mail\MessageGoogle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Contact\ContactRepository;

class ContactController extends Controller
{
    private $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function index()
    {
        return view('contact');
    }


    public function store(Request $request)
    {
        // dd($request->all());
        
        try {
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'message' => 'required',
                // 'g-recaptcha-response' => 'required',
            ]);
            // dd('');
            $inputs = $request->post();
            unset($inputs['_token']);

            DB::transaction(function () use ($inputs) {
                $this->contactRepository->store($inputs);

                Mail::to('grantshell0@gmail.com')->bcc("tiwagrant@yahoo.fr")
                    ->queue(new MessageGoogle($inputs));
            });

            return redirect()->back()->with('success', 'Message envoyé !');
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th->getMessage());
            Log::error('Contact form submission error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Oups! Une erreur s\'est produite !');
        }
    }
}
