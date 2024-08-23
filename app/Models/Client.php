<?php

namespace App\Models;

use App\Scopes\ExcludeDeletedScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class Client extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['person_id', 'company_id', 'deleted', 'registration_date'];

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

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
}
