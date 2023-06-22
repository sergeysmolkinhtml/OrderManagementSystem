<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterByTenant
{
    public static function boot()
    {
        parent::boot();

        $currentTenantId = auth()->user()->current_tenant_id;

        self::creating(function ($model) use ($currentTenantId) {
            $model->tenant_id = $currentTenantId;
        });

        self::addGlobalScope(function (Builder $builder) use ($currentTenantId) {
           $builder->where('tenant_id', $currentTenantId);
        });
    }
}
