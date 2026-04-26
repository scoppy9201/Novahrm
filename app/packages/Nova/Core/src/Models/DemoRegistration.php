<?php

namespace App\packages\Nova\Core\src\Models;

use Illuminate\Database\Eloquent\Model;

class DemoRegistration extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'company_name',
        'product',
        'position',
        'city',
        'company_size',
    ];
}