<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;

class ProductMovement extends Model
{
    use Uuid;
    protected $fillable = [
        'id_product',
        'quantity'
    ];
    protected $keyType = 'string';
    public $incrementing = false;

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
