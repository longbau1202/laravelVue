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
    public function index(Request $request)
    {
        $sort = $request->sort;
        if ($sort === '') {
            $products= Product::with('category')->paginate(4);
            return response()->json([
                'data' => $products,
            ]);
        } 
        
        $products= Product::with('category')->orderBy('product_name', $sort)->paginate(4);

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

    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('/images');
            return response()->json(['path' => $path]);
        }
        return response()->json(['error' => 'No file was uploaded.']);
    }

    public function search(Request $request) 
    {
        $products= Product::with('category')->where('product_name', $request->value)->paginate(4);
        return response()->json([
            'data' => $products,
        ]);
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
