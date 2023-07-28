<?php

namespace App\Models;

use App\Observers\ProjectObserver;
use App\Scopes\CompanyScope;
use App\Traits\FilterByTenant;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;
    use FilterByUser;
    //use FilterByTenant;

    protected static function boot() : void
    {
        parent::boot();
        static::observe(ProjectObserver::class);
    }

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

}
