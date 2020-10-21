<?php

namespace App\Managers\Product;

use App\Models\Product;

class ProductManager {

  public static function list(){
    $products = Product::all();
    return $products;
  }

  public static function getById($id){
    $product = Product::findOrFail($id);
    return $product;
  }

  public static function create($data){
    if (isset($data['id'])) {
      throw new \Exception('PRODUCT_HAS_ID');
    }
    if (empty($data['name'])) {
      throw new \Exception('EMPTY_NAME');
    }
    $product = Product::create($data);
    return $product;
  }

  public static function delete($id){
    $product = Product::findOrFail($id);
    $product->delete();
  }

  public static function edit($id, $data)
  {
    unset($data['quantity']);
    if (empty($data['name'])) {
      throw new \Exception('EMPTY_NAME');
    }
    $product = Product::findOrFail($id);
    $product->fill($data);
    $product->save();
    return $product;
  }
}
