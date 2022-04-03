<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Photo;
use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{

    public function index()
    {
        return view('admin.products')
            ->with([
                'products' => Product::withTrashed()->orderByDesc('created_at')->get(),
            ]);
    }


    public function create()
    {
        return view('admin.products.create')->with([
            'categories' => Category::all(),
        ]);
    }


    public function store(Request $request)
    {
        $product = new Product;

        $inputs = $request->validate([
            'name' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'price' => ['required', 'string'],
            'details' => ['string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => 'image|mimes:jpeg,png,jpg,gif,jfif,svg|max:2048',
            'images' => '',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,jfif,svg|max:2048',
            'featured' => ['required', 'string'],
            'quantity' => ['required', 'string'],
        ]);

        // Single image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image = $file->getClientOriginalName();
            Storage::putFileAs('files/1/Products', $request->file('image'), Str::slug($inputs['name']) . '/' . $image);
            $inputs['image'] = $image;
        }

        // Multiple images uploads
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $file) {

                $name = $file->getClientOriginalName();
                Storage::putFileAs('files/1/Products', $file, Str::slug($inputs['name']) . '/' . $name);
                $data[] = $name;
            }

            $inputs['images'] = json_encode($data);
        }

        $createdProduct = $product->create($inputs);
        $createdProduct->categories()->sync($request->categories);
    }


    public function show($id)
    {
        return view('posts.show', [
            'post' => Product::findOrFail($id),
        ]);
    }


    public function edit($id)
    {
        return view('admin.products.edit')->with([
            'product' => Product::findOrFail($id),
            'categories' => Category::all(),
        ]);
    }


    public function update(Product $product)
    {
        $inputs = request()->validate([
            'name' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'price' => ['required', 'string'],
            'details' => ['string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => 'image|mimes:jpeg,png,jpg,gif,jfif,svg|max:2048',
            'images' => '',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,jfif,svg|max:2048',
            'featured' => ['required', 'string'],
            'quantity' => ['required', 'string'],
        ]);

        // Single images uploads
        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $image = $file->getClientOriginalName();
            Storage::putFileAs('files/1/Products', request()->file('image'), Str::slug($inputs['name']) . '/' . $image);
            $product->update(['image' => $image]);
        }

        // Multiple images uploads
        if (request()->hasFile('images')) {

            foreach (request()->file('images') as $file) {

                $name = $file->getClientOriginalName();
                Storage::putFileAs('files/1/Products', $file, Str::slug($inputs['name']) . '/' . $name);
                $data[] = $name;
            }
            $product->update(['images' => json_encode($data)]);
        }

        $product->save([
            $product->name = $inputs['name'],
            $product->slug = $inputs['slug'],
            $product->price = $inputs['price'],
            $product->details = $inputs['details'],
            $product->description = $inputs['description'],
            $product->featured = $inputs['featured'],
            $product->quantity = $inputs['quantity'],
        ]);

        $product->categories()->sync(request()->categories);
    }


    public function destroy($id)
    {
        Product::whereId($id)->delete();
    }


    public function restore(Product $product, $id)
    {
        $product->whereId($id)->restore();
    }


    public function remove($id)
    {
        Product::where('id', $id)->forceDelete();
    }


    public function deleteProducts(Request $request)
    {
        $ids = $request->ids;
        Product::whereIn('id', explode(",", $ids))->delete();

    }


    public function removeProducts()
    {
        $ids = request()->ids;
        Product::whereIn("id", explode(",", $ids))->forceDelete();
    }


    public function restoreProducts(Request $request)
    {
        $ids = $request->ids;
        Product::whereIn('id', explode(",", $ids))->restore();
    }
}
