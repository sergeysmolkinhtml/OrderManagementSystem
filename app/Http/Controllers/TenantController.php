<?php

namespace App\Http\Controllers;


use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;

class TenantController extends Controller
{
    public function changeTenant($tenantID) : RedirectResponse
    {
        // Check tenant
        $tenant = auth()->user()->tenants()->findOrFail($tenantID);

        // Change tenant
        auth()->user()->update(['current_tenant_id' => $tenantID]);

        // Redirect to dashboard
        $tenantDomain = str_replace('://', '://' . $tenant->subdomain . '.', config('app.url'));
        return redirect($tenantDomain . RouteServiceProvider::HOME);
    }
}
