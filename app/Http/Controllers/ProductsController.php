<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function getProducts()
    {
        try {
            $products = Product::all();
            // JSON response
            return response()->json(['products' => $products], 200);
        } catch (\Exception $e) {
            // Log::error('Error fetching products: ' . $e->getMessage());
            //  error response
            return response()->json(['error' => 'Failed to fetch products'], 500);
        }
       
    }
    public function addProduct(Request $request)
    {
       
        try {
            // Data validation
            $request->validate([
                'product_name' => 'required|string|max:255',
                'batch_no' => 'required|string|max:50',
                'mass' => 'required|numeric|min:0',
                'p_date' => 'required|date',
                'p_price' => 'required|numeric|min:0',
                'sale_price' => 'required|numeric|min:0',
                'category' => 'required|string',
                'unit' => 'required|string',
            ]);
    
            // Log::info('Data:', $request->all());

            // Insert product
            $product = new Product();
            $product->product_name = $request->input('product_name');
            $product->batch_no = $request->input('batch_no');
            $product->mass = $request->input('mass');
            $product->p_date = $request->input('p_date');
            $product->p_price = $request->input('p_price');
            $product->sale_price = $request->input('sale_price');
            $product->category = $request->input('category');
            $product->unit = $request->input('unit');
            $product->save();
    
            // Success response
            return response()->json(['message' => 'Product added successfully'], 200);
        } catch (\Exception $e) {
            // Log::error('Error adding product: ' . $e->getMessage());
            // error response
            return response()->json(['error' => 'Failed to add product'], 500);
        }
    }
  
    
    public function deleteProduct(Request $request)
    {
        $productId = $request->input('id');
        // Log::info('ID:', ['productId' => $productId]);
        // Find the product by ID
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
    public function getProductDetails(Request $request)
    {
        $productId = $request->input('id');
        // product details by ID
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
         // JSON Response
        return response()->json(['product' => $product]);
    }
    public function updateProduct(Request $request)
    {
      
        // Implement validation as needed
        $validatedData = $request->validate([
            'product_name' => 'required|string',
            'batch_no' => 'required|string',
            'category' => 'required|string',
            'unit' => 'required|string',
            'p_date' => 'required|date',
            'p_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
        ]);
        // Log::info('edit-data:',$validatedData);
        $productId = $request->input('id');
        $product = Product::find($productId);
        $product->update($validatedData);
         // JSON Response
        return response()->json(['message' => 'Product updated successfully']);
    }
    //views
    public function Create(Request $request)
    {
        return view('products.create');
    } 
    public function Products(Request $request)
    {
        return view('products.index');
    }
}
