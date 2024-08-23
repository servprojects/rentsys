<?php

namespace App\Models;

use App\Scopes\ExcludeDeletedScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class Company extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'address',
        'contact_number',
        'email',
        'deleted',
        'country_code',
        'region_code',
        'municipality_code',
        'location_coordinates',
    ];

    protected static function boot()
    {
        parent::boot();

      
        static::addGlobalScope(new ExcludeDeletedScope);

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    
}
