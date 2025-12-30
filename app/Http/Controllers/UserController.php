<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Mail\MessageGoogle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{


    public function index()
    {
        $adminCompany = adminCompany();
        $superAdmin = checkCompany();
        $roles = Role::all();
        // dd($adminCompany, $superAdmin);

         // 🔹 Récupération des utilisateurs selon le rôle
        if ($superAdmin) {
            $users = User::with(['company.license.plan'])->get();
        } else {
            $query = User::with(['company.license.plan']);

            $query->where('etablissement_id', auth()->user()->etablissement_id);
            $users = $query->get();
        }


        // Licence (logique existante conservée)
        $license = optional($users->first()?->company?->license);

        $canCreateUser = ($adminCompany && (
            $license && $users->count() < $license->max_users
        )) || $superAdmin;

        // 🔹 Groupement par entreprise
        $usersByCompany = $users->groupBy(function ($user) {
            return $user->company->name ?? 'Sans entreprise';
        });

        return view(
            'admin.users.index',
            compact('users', 'usersByCompany', 'canCreateUser', 'adminCompany', 'roles', 'superAdmin')
        );
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
            ]);

            $input = $request->all();
            $pwd = generateRandomPassword(8);
            $input['password'] = Hash::make($pwd);
            $input['etablissement_id'] = auth()->user()->etablissement_id;

            Mail::to($input['email'])
                // ->bcc("grantshell0@gmail.com")
                ->queue(new MessageGoogle($input + ['created_account' => true, 'pwd' => $pwd]));
            // dd($input, $pwd);
            $user = User::create($input);

            return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
        } catch (\Throwable $th) {
            // dd($th);
            Log::error('Error creating user: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la création de l\'utilisateur.');
        }

    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
            
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Error deleting user: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la suppression de l\'utilisateur.');
        }
    }
}
