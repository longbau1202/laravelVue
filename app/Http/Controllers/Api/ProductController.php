<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products= Product::with('category')->paginate(4);
        return response()->json([
            'data' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ProductRequest $request)
    {
        $product = Product::create($request->all());

        return response()->json([
            'message' => 'Tạo thành công, nhấn cancel để tiếp tục add sản phẩm khác',
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, $id)
    {
        $product = Product::where('id', $id)->first();
        return response()->json([
            'data' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();
        $product = Product::findOrFail($id);
        $product->fill($data);
        $product->save();

        return response()->json([
            'status' => 'Success',
            'message' => 'Sửa thành công',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
