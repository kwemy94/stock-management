<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckLicense
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        $isAdminCompany = checkCompany();

        if (!$isAdminCompany) {
            if (!$user) {
                return redirect()->route('login');
            }
            $company = $user->company;
            $license = $company?->license;
            // dd($user, $company);

            //Pas de licence
            if (!$license) {
                return $this->deny('Aucune licence associée à votre entreprise.');
            }

            // Licence inactive
            if ($license->status !== 'active') {
                return $this->deny('Licence suspendue.');
            }

            // Licence expirée
            if (Carbon::parse($license->expires_at)->isPast()) {
                return $this->deny('Licence expirée.');
            }
        }

        return $next($request);
    }

    protected function deny(string $message)
    {
        // dd($message);
        if (request()->expectsJson()) {
            return response()->json(['message' => $message], 403);
        }

        return redirect()
            ->route('license.expired')
            ->withErrors($message);
    }
}

