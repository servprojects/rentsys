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
    
    public function itemGenericName()
    {
        return $this->belongsTo(ItemGenericName::class, 'item_generic_name_id');
    }

    public function itemBrand()
    {
        return $this->belongsTo(ItemBrand::class, 'item_brand_id');
    }

    public function itemCategory()
    {
        return $this->belongsTo(ItemCategory::class, 'item_category_id');
    }
}
