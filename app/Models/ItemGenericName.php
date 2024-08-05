<?php

namespace App\Models;

use App\Scopes\ExcludeDeletedScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemGenericName extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ExcludeDeletedScope);
        // $resultsWithDeleted = YourModel::withoutGlobalScope(ExcludeDeletedScope::class)->get();

    }

    use HasFactory;

    protected $fillable = [
        'name',
        'details',
        'deleted',
    ];
}
