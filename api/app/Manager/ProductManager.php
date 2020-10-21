<?php

namespace App\Manager;

use App\Models\Product;

class ProductManager {

  public static function list(){
    $products = Product::all();
    foreach($products as $product){
        $product->movements = $product->product_movements;
    }
    return $products;
  }

  public static function getById($id){
    $product = Product::findOrFail($id);
    $product->movements = $product->product_movements;
    return $product;
  }

  public static function create($data){

    if (empty($data['name'])) {
      throw new \Exception('ERROR_PRODUCT_EMPTY_NAME');
    }


    if (empty($data['description'])) {
      throw new \Exception('ERROR_PRODUCT_EMPTY_DESCRIPTION');
    }

    unset($data['quantity']);

    $product = Product::create($data);
    $product->movements = [];
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
      throw new \Exception('ERROR_PRODUCT_EMPTY_NAME');
    }
    $product = Product::findOrFail($id);
    $product->fill($data);
    $product->save();
    $product->movements = $product->product_movements;
    return $product;
  }
}
