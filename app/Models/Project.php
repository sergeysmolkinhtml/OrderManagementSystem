<?php

namespace App\Models;

use App\Traits\FilterByTenant;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    //use FilterByUser;
    use FilterByTenant;

    protected $fillable = [
        'name',
        'user_id'
    ];

}
