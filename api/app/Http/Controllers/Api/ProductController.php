<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;

use App\Manager\ProductManager;

class ProductController extends Controller
{

    public function index()
    {
        $products = ProductManager::list();
        return response()->json($products,200);
    }


    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $product = ProductManager::create($data);
            return response()->json($product, 201);
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 400);
        }
    }


    public function show($id)
    {
        try {
            $product = ProductManager::getById($id);
            return response()->json($product, 201);
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 400);
        }
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        try {
            $product = ProductManager::edit($id, $data);
            return response()
                ->json($product, 200);
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        try {
            ProductManager::delete($id);
            return response(200);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 404);
        }
    }
}
