<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_generic_name_id',
        'item_category_id',
        'item_brand_id',
        'description',
        'details',
        'model',
    ];
}
