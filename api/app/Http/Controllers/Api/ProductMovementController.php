<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Manager\ProductMovementManager;

class ProductMovementController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $product = ProductMovementManager::create($data);
            return response()->json($product, 200);
        } catch (\Exception $error) {
            return response()->json(['error' => $error], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        try {
            $product = ProductMovementManager::edit($id, $data);
            return response()
                ->json($product, 200);
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            ProductMovementManager::delete($id);
            return response(200);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 404);
        }
    }

    /**
     * Batch create a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function batchCreate(Request $request)
    {
        try {
            $data = $request->all();
            $products = ProductMovementManager::batchCreate($data);
            return response()->json($products, 200);
        } catch (\Exception $err) {
            return response()->json(['error' => $err->getMessage()], 400);
        }
    }
}
