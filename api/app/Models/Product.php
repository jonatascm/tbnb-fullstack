<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use Uuid;
    protected $fillable = [
        'name',
        'quantity',
        'description',
    ];
    protected $attributes = ['quantity' => 0];
    protected $keyType = 'string';
    public $incrementing = false;

    public function product_movements()
    {
        return $this->hasMany('App\Models\ProductMovement');
    }

    public function delete()
    {
        DB::transaction(function()
        {
            $this->product_movements()->delete();
            parent::delete();
        });
    }
}
