<?php

namespace App\Http\Controllers;

use App\Mail\MessageGoogle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Contact\ContactRepository;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    private $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $validation = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'subject' => 'required',
                'message' => 'required',
                'captcha' => 'required|captcha'
            ],
            [
                'captcha.captcha' => 'Invalid captcha code.'
            ]
        );

        if ($validation->fails()) {

            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        // dd('');
        $inputs = $request->post();
        unset($inputs['_token']);
        try {
            DB::transaction(function() use($inputs) {
                $this->contactRepository->store($inputs);

                Mail::to('grantshell0@gmail.com')->bcc("tiwagrant@yahoo.fr")
                    ->queue(new MessageGoogle($inputs));
            });
            
            return redirect()->back()->with('success', 'Message envoyé !');
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th->getMessage());
            return redirect()->back()->with('error', 'Oups! Une erreur s\'est produite !');
        }
    }
}
