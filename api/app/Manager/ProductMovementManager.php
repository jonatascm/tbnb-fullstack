<?php

namespace App\Manager;

use App\Models\ProductMovement;
use App\Models\Product;

class ProductMovementManager {

  public static function getById($id){
    $product_movement = ProductMovement::findOrFail($id);
    return $product_movement;
  }

  public static function create($data){
    if (empty($data['quantity'])) {
      throw new \Exception('EMPTY_QUANTITY');
    }
    if (empty($data['type'])) {
      throw new \Exception('EMPTY_TYPE');
    }

    if (empty($data['productId'])) {
      throw new \Exception('EMPTY_PRODUCT');
    }

    $data['product_id'] = $data['productId'];
    unset($data['productId']);

    $product_movement = ProductMovement::create($data);

    $product = $product_movement->product;

    if($product_movement->type === 'buy'){
        $product->quantity += $product_movement->quantity;
    }else if($product_movement->type === 'sell'){
        $product->quantity -= $product_movement->quantity;
    }
    $product->save();
    $product_movement->product = $product;
    return $product_movement;
  }

  public static function delete($id){
    $product_movement = ProductMovement::findOrFail($id);
    $product = $product_movement->product;

    if($product_movement->type === 'buy'){
        $product->quantity -= $product_movement->quantity;
    }else if($product_movement->type === 'sell'){
        $product->quantity += $product_movement->quantity;
    }

    $product->save();
    $product_movement->delete();
  }

  public static function edit($id, $data)
  {
    $product_movement = ProductMovement::findOrFail($id);

    $product = $product_movement->product;

    if($product_movement->type === 'buy'){
        $product->quantity -= $product_movement->quantity;
    }else if($product_movement->type === 'sell'){
        $product->quantity += $product_movement->quantity;
    }

    if($data['type'] === 'buy'){
        $product->quantity += $data['quantity'];
    }else if($data['type'] === 'sell'){
        $product->quantity -= $data['quantity'];
    }

    $product_movement->fill($data);
    $product_movement->save();
    $product->save();
    $product_movement->product = $product;
    return $product_movement;
  }

  public static function batchCreate($data){
    $result = [];
    foreach($data as $movement){
        $movement['productId'] = $movement['product']['id'];
        $product_movement = self::create($movement);
        $result[] = $product_movement;
    }
    return $result;
  }
}
