<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Validation\EtablissementValidation;
use App\Repositories\Etablissement\EtablissementRepository;

class EtablissementController extends Controller
{

    protected $etablissementRepository ;
    protected $userRepository ;

    public function __construct(EtablissementRepository $etablissementRepository, UserRepository $userRepository){
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
    public function store(Request  $request, EtablissementValidation $etablissementValidation) {
        
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
        $pwd = generateRandomPassword(8);
        $adminUser['password'] = Hash::make($pwd);

        try {
           $database = null;
           $transaction = DB::transaction(function () use($adminUser, $request, &$database, $uploadProfil){
                if ($uploadProfil) {
                    $filename = Str::uuid() . '.' . $uploadProfil->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs('etablissement/logo/', $uploadProfil, $filename);
        
                    $request['logo'] = $filename;
                }


                $database = '2s_'.preg_replace("/\s+/", "", $request->name).'_db';

                $data =  array("db" => array('database'=>$database,'username'=>'root','password'=>''),'momo'=> '{}');

                $request['settings'] = $data;
                
                $ets = $this->etablissementRepository->store($request->post());

                $adminUser['etablissement_id'] = $ets->id;
                $this->userRepository->store($adminUser);

            //    Artisan::call('db:seed', ['--class' => 'UserFrontEndSeeder']);
            });

            if (is_null($transaction)) {
                #création de la bd client
                Artisan::call('db:create', ['name'=> $database]);
                
                # Exécution des migrations dans les bases de données nouvellement crées
                Artisan::call('update:backend_db', ['path'=> 'backend_db']);

                Artisan::call('db:seed', ['--class' => 'SettingSeeder']);
            }
            
            
        } catch (\Exception $e) {
            //throw $th;
            return response()->json(['error'=> 'erreur survenue '.$e]);
        }

        #changement de statut (passer de 2 =>bd non créé à 1 =>  bd cré et migré)
        $etab = $this->etablissementRepository->lastField();
        $etab->status = 1;
        $this->etablissementRepository->update($etab->id, ['status'=>1]);

        return response()->json([
            'success' =>true,
            'login' => $adminUser['email'],
            'password' => $pwd,
            'url' => 'url vers le nom de domaine crée',

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
}
