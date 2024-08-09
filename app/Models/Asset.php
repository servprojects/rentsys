<?php

namespace App\Models;

use App\Scopes\ExcludeDeletedScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ExcludeDeletedScope);
        // $resultsWithDeleted = YourModel::withoutGlobalScope(ExcludeDeletedScope::class)->get();

    }

    use HasFactory;

    protected $fillable = [
        'serial_number',
        'code',
        'description',
        'date_of_purchase',
        'item_id',
        'deleted',
    ];
    
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

}
