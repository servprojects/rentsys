<?php

namespace App\Models;

use App\Scopes\ExcludeDeletedScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class Person extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'first_name', 
        'last_name', 
        'contact_number', 
        'address',
        'valid_id_type',
        'valid_id_no',
        'email',
        'company_id',
        'deleted',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ExcludeDeletedScope());

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

}
