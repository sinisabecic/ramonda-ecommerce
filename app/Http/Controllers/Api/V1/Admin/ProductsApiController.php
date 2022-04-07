<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;

class ProductsApiController extends Controller
{
    public function index()
    {
        if (!auth()->user()->tokenCan('products-list')) {
            abort(403, 'Unauthorized');
        }
        //token: 4|g70Z91G5MV4LpgFHYlqJo5igAThC5xAuLpfEQ9mn

        return ProductResource::collection(Product::withTrashed()->get())
            ->response()
            ->setStatusCode('200', 'OK');
    }


    public function store(Request $request)
    {
        if (!auth()->user()->tokenCan('products-create')) {
            abort(403, 'Unauthorized');
        }
        //token: 5|v72mn4iVhcCdyr0srKGbDi91LwEMkXvvjyPrYb6l

//        $product = Product::create($request->all());
        $product = new Product();
        $product->save([
            $product->name = $request->input('name'),
            $product->details = $request->input('details'),
            $product->price = $request->input('price'),
            $product->description = $request->input('description'),
            $product->featured = $request->input('featured'),
            $product->quantity = $request->input('quantity'),
        ]);
        $product->categories()->sync($request->input('categories', []));

        return response()
            ->json($product)
            ->setStatusCode(201, 'Created');
    }

    public function show($id)
    {
        if (!auth()->user()->tokenCan('products-show')) {
            abort(403, 'Unauthorized');
        }
        //token: 11|iQRFAM2ZBIwIv2QLRCaqaJR1ENHu9UjqeBRJ7CVR

        return ProductResource::collection(Product::where('id', $id)->get())
            ->response()
            ->setStatusCode('200', 'OK');
    }


    // Soft delete. Deactivating products
    public function destroy(Product $product)
    {
        if (!auth()->user()->tokenCan('products-delete')) {
            abort(403, 'Unauthorized');
        }

        //token: 9|XRz8vzLsvVmlBEOvkrJjHEXDwWtEz0MD5sysVg9O

        $product->delete();

        return response()
            ->json()
            ->setStatusCode(204, 'Deleted (soft)');
    }

    public function remove($id)
    {
        if (!auth()->user()->tokenCan('products-remove')) {
            abort(403, 'Unauthorized');
        }

        //token: 10|Zx3907VVswDBd2I21SoazT3SiSDudZQWIPeIA9F4

        Product::where('id', $id)->forceDelete();

        return response()
            ->json()
            ->setStatusCode(204, 'Removed');
    }
}
