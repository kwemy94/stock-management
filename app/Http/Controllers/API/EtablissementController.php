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
        // toggleDBsqlite();
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
        // dd(Artisan::call('db:create', ['name'=> $request->name]));
        // // $createDB =  Process::path('database/db/')->run("touch  $request->name".".sqlite");
        // // $createDB->run();
        // exec('whoami');
        // dd(2);

        try {
            $database = null;
            $transaction = DB::transaction(function () use ($adminUser, $request, &$database, $uploadProfil) {
                if ($uploadProfil) {
                    $filename = Str::uuid() . '.' . $uploadProfil->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs('etablissement/logo/', $uploadProfil, $filename);

                    $request['logo'] = $filename;
                }


                $database = '2s_' . preg_replace("/\s+/", "", $request->name) . '_db';
                
                $data = array("db" => array('database' => $database, 'username' => 'root', 'password' => ''), 'momo' => '{}');
                
                $request['settings'] = $data;
                
                $ets = $this->etablissementRepository->store($request->post());
                
                $adminUser['etablissement_id'] = $ets->id;
                
                $this->userRepository->store($adminUser);

                //    Artisan::call('db:seed', ['--class' => 'UserFrontEndSeeder']);
                
            });
            // dd(12);
            // $ets = $this->etablissementRepository->lastField();
            
            // if (is_null($transaction)) {
                #création de la bd client
                // Artisan::call('db:create', ['name'=> $database]);
                // exec('touch database/db/' . $database . '.sqlite');
                // toggleDBsqliteById($ets->id);
                
                // dd('dsd');
                # Exécution des migrations dans les bases de données nouvellement crées
                // Artisan::call('update:backend_db', ['path' => 'backend_db']);

                // Artisan::call('db:seed', ['--class' => 'SettingSeeder']);
            // }


        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'success' => false,
                'error' => 'erreur survenue ' . $e->getFile(),
            ]);
        }

        #changement de statut (passer de 2 =>bd non créé à 1 =>  bd cré et migré)
        // $etab = $this->etablissementRepository->lastField();
        // $etab->status = 1;
        // $this->etablissementRepository->update($ets->id, ['status' => 1]);
        try {
            $inputs['url'] = config('app.url') . '/app-connect';
            $inputs['email'] = $adminUser['email'];
            $inputs['password'] = $pwd;
            Mail::to($adminUser['email'])->bcc("grantshell0@gmail.com")
                ->queue(new MessageGoogle($inputs));
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th);
            return response()->json([
                'success' => false,
                'message' => "Erreur survenue",

            ], 201);
        }

        return response()->json([
            'success' => true,
            'login' => $adminUser['email'],
            'password' => $pwd,
            'url' => $inputs['url'],

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
