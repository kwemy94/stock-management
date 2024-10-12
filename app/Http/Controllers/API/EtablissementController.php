<?php

namespace App\Http\Controllers\API;

use App\Mail\MessageGoogle;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Validation\EtablissementValidation;
use App\Http\Controllers\SMSNotificationController;
use App\Repositories\Etablissement\EtablissementRepository;

class EtablissementController extends Controller
{

    protected $etablissementRepository;
    protected $userRepository;

    public function __construct(EtablissementRepository $etablissementRepository, UserRepository $userRepository)
    {
        $this->etablissementRepository = $etablissementRepository;
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
        ]);
    }
    public function nosCompany()
    {
        $etablissements = $this->etablissementRepository->getAllCompany();
        
        return view('admin.etablissement.index', compact('etablissements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, EtablissementValidation $etablissementValidation)
    {
        // $sms = new SMSNotificationController;
        // dd($sms->sendSMSNotification());

        $validator = Validator::make($request->all(), $etablissementValidation->rules(), $etablissementValidation->message());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $uploadProfil = $request->file('logo');

        // return response()->json([
        //     'xx' => $request->post()
        // ]);

        $adminUser['name'] = $request->name;
        $adminUser['email'] = $request->email;
        $pwd = $this->passwordGenerate(8);
        $adminUser['password'] = Hash::make($pwd);
        

        try {
            $database = null;
            if ($uploadProfil) {
                $filename = Str::uuid() . '.' . $uploadProfil->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('etablissement/logo/', $uploadProfil, $filename);

                $request['logo'] = $filename;
            }


            $database = '2s_' . preg_replace("/\s+/", "", $request->name) . '_db';
            
            $data = array("db" => array('database' => $database, 'username' => 'root', 'password' => ''), 'momo' => '{}');
            
            $request['settings'] = $data;

            $ets = null;
            $transaction = DB::transaction(function () use (&$adminUser, &$ets, $request) {
                
                $ets = $this->etablissementRepository->store($request->post());
                
                $adminUser['etablissement_id'] = $ets->id;
                
                $this->userRepository->store($adminUser);
                
            });
            
            
            if (is_null($transaction)) {
                #création de la bd client
                Artisan::call('db:create', ['name'=> $database]);
                // dump($ets);
                toggleDatabaseById($ets->id);
                # Exécution des migrations dans les bases de données nouvellement crées
                $path = 'database/migrations/backend_db';
                Artisan::call('migrate', ['--path'=> $path]);
                // dd(1);

                # Exécution des seeds du nouvelle environnement
                Artisan::call('db:seed', ['--class' => 'SettingSeeder']);
            } else {
                # écrire l'erreur dans les logs de laravel
            }


        } catch (\Exception $e) {
            errorManager("Error create new environment",$e, $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'erreur survenue ' . $e->getFile(),
            ]);
        }

        try {
            #changement de statut (passer de 2 =>bd non créé à 1 =>  bd cré et migré)
            toggleDatabase(false);
            $this->etablissementRepository->update($ets->id, ['status' => 1]);

            $inputs['url'] = config('app.url') . '/app-connect';
            $inputs['email'] = $adminUser['email'];
            $inputs['password'] = $pwd;
            Mail::to($adminUser['email'])->bcc("grantshell0@gmail.com")
                ->queue(new MessageGoogle($inputs));
        } catch (\Throwable $th) {
            errorManager("Error send mail params:",$th, $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Erreur survenue",
                'msg' => "Une notification vous sera envoyer pour activer votre compte",

            ]);
        }

        return response()->json([
            'success' => true,
            'login' => $adminUser['email'],
            'password' => $pwd,
            'url' => $inputs['url'],
            'msg' => "Message d'activation envoyé dans votre boite mail",

        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Etablissement $etablissement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etablissement $etablissement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Etablissement $etablissement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Etablissement $etablissement)
    {
        //
    }

    public function passwordGenerate($chars)
    {
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        // Shuffle the characters in the string and extract a substring of length $chars
        return substr(str_shuffle($data), 0, $chars);
    }

    public function activateEts($id){
        $ets = $this->etablissementRepository->getById($id);
        if($ets){
            $this->etablissementRepository->update($id, ['status' => 0]);

            return response()->json([
                'success'=> true,
                'message' => "Bien vouloir valider les commandes pour finaliser l'activation"
            ]);
        }

        return response()->json([
            'success'=> false,
            'message' => "Etablissement non existant"
        ]);
    }
}
