<?php

namespace App\Models;

use App\Scopes\ExcludeDeletedScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ExcludeDeletedScope);
     
    }

    use HasFactory;

    protected $fillable = [
        'expected_pickup_datetime',
        'expected_return_datetime',
        'actual_pickup_datetime',
        'actual_return_datetime',
        'date_of_inquiry',
        'is_from_ads',
        'pickup_remarks',
        'return_remarks',
        'surrendered_id',
        'deleted',
        'client',
        'asset_id',

    ];
    
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

}
