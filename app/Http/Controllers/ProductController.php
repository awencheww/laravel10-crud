<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 5;

        if(!empty($keyword)) {
            $products = Product::where('name', 'LIKE', "%$keyword%")
                                ->orWhere('category', 'LIKE', "%$keyword%")
                                ->latest()->paginate($perPage);
        } else {
            $products = Product::latest()->paginate($perPage);
        }
        return view('products.index', ['products' => $products])->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2028'
        ]);

        $product = new Product();
        $file_name = $request->file('image')->getClientOriginalName();
        request()->image->move(public_path('images'), $file_name);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->image = $file_name;
        $product->category = $request->category;
        $product->quantity = $request->quantity;
        $product->price = $request->price;

        $product->save();
        return redirect()->route('products.index')->with('success', 'Products added successfully! ');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', ['product' => $product]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2028'
        ]);

        $product = Product::findOrFail($id);
        $file_name = $request->file('image')->getClientOriginalName();
        request()->image->move(public_path('images'), $file_name);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->image = $file_name;
        $product->category = $request->category;
        $product->quantity = $request->quantity;
        $product->price = $request->price;

        $product->save();
        return redirect()->route('products.index')->with('success', 'Products has been updated successfully ');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $image = public_path()."/images/".$product->image;
        if(file_exists($image)) {
            @unlink($image);
        }
        $product->delete();
        return redirect('products')->with('success', 'Product successfully deleted.');
    }
}
