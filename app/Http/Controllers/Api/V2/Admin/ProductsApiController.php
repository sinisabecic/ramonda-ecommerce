<?php

namespace App\Http\Controllers\Api\V2\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;

class ProductsApiController extends Controller
{
    public function index()
    {


        // if (!auth()->user()->token()) {
        //     abort(403, 'Unauthorized');
        // }

        //? Admin
        //token: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NjE2M2M1NS0wMzE2LTQzMGMtYjRkOC1lYTQzZmQxOTE2MzQiLCJqdGkiOiJmMTkxZjM2NTBlYjY0ZmRkNTVkN2Y2MjU3MDQ5MGVlMDY4MmVlYjc5YWYxY2M2ZTM0YWQ5ODEwNjUwZDc0MmQxZjMzYjEwMDc2NDQ5Yjc4NyIsImlhdCI6MTY1NTE5ODY1My41Mzk2NywibmJmIjoxNjU1MTk4NjUzLjUzOTY3NSwiZXhwIjoxNjg2NzM0NjUzLjI4NDE1NSwic3ViIjoiMSIsInNjb3BlcyI6W119.zhtZT_A0iOKPhLhtl1LD1taia-1HC0L5i_0OMrA4JRpVvBuNHLqG_OIFCv3ElRel7F-SiX4pMn0H1oYaTW7cjyozlzsFEX7V44l4FiBueX78r-cR6pRyFXJ5oEj7NivjfvNO0soI73FX5MSDjDGNI33TRWRIJZg6OP76bxrClWe2kpkyULCh99X_PKpqimMaQbAwdwyCeTx88PpI9IIi_H0wRIMFuUCUJTt3jR4S9RTCpnBP6GfaPUZg5gQWuxHojqGIOiqj9hUsL50WJWaMYzu-6JufAVr-cFtR6LdxL5tk_4KEGy58SquooP8fkLJFlG0cy4uyLd1JJROpLNG9DdegAmDms59gy_mKm1_kQli4nVbejaqDuIVh8KTfcO342w_smj82UU-RbAISe4u2-AVTZlBK1WAdeXv8DvslbJ5JNGDVfANy9mzN3T_3IcAWnY3EixljjiD-lHZyPCVPKkzSQzcPnkpeGzXp4OlzNruYwEb3Ip8tRFGRvzphvpgK8N3aCFEpi3koJj0seuZg1mI8lxIEBb4-1bmsYirEnDqW5puMrSgrBE0N9Z0tpy45dStxsUk2t4lqt_6Erh7k2mxd7VSB0dJdKucrBvhFKEblyLS1jaMuegdNIOnMYztBQeqOFBwlI2dfbDSPQR9vTqEIbPsLqZKRbKgkutuQyGo

        //? User
        //token: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NjE2M2M1NS0wMzE2LTQzMGMtYjRkOC1lYTQzZmQxOTE2MzQiLCJqdGkiOiI2YjQwODVmMzdlMWIxY2U4ZDExNGJiN2U3N2QzODQ2YjQzNGM2ODNiOWNmNTgwOGM3M2VjZjI3ODY1NDQ3NjE4YjM1NmFmMmJlOTBhZGYwZCIsImlhdCI6MTY1NTIwNjE5Ni43MTI0NDQsIm5iZiI6MTY1NTIwNjE5Ni43MTI0NTQsImV4cCI6MTY4Njc0MjE5Ni42NjQ4MjIsInN1YiI6IjE2Iiwic2NvcGVzIjpbXX0.w3Eiitk2doHEGJhH4Xzap4AuJF51zhlbzDUOq8EvxpiEU2sIjVdzq_KRi4vdjarUPN77aG7oS6SsPdZjaJ4gZxqKrZv3NCCrB8a914x88ZAPC6-tYO-xxQPwJAi0nHy5MgI5_anxYVTIg18aqkDVFFwuU8bafDHV0qAOkZ2AqpEuqjZiQ-j4hBDWVJ9SH7ZM3KcQRDXDdeSVihTPjM35irrx5Eq7w2ucxRcsHls6OV3NaDdRvqhKJzofj7HQFXw6vRRgOAKEs68_8nZ1rkl8YQDt7mZXnnQH6oLzp3bcn1OoqCSO2pQYRxQ6zGBjWQMOQ4t5JgCaWyyDPV7KN80Wc-IjnP1XQbnv57gnPMZcHAbL5vHCRQk9-v0dQvNW9Rnkzbc0cNwMr3C83wkGO9dHbCrDkjk4_ehr7izfFqZuymBCNHSivAWm_JR2pxGqzB_fVik_Jor_3TNFQbX1DLRiRquOcPE9eYjqdG096L_HTfRjRBlK1--pxM3k6ZUb2KX0fBf8pv7Ykk6cYShGE__VzWKgqRuH3UghK4fPH1pW3oS32_fFTGLJu-UbI-bfWkiT6j072YXZieGEqkyUkbANAEQgM4KuiGNpgBOe-J_OMY32xw_D_VdSiMlpWmGkMaj-Ky_ZRmCULdTowrWTbfihb65b0SxIfQwvyJYS2xYgTPk

        return ProductResource::collection(Product::withTrashed()->get())
            ->response()
            ->setStatusCode('200', 'OK');
    }



    public function store(Request $request)
    {
        // if (!auth()->user()->tokenCan('products-create')) {
        //     abort(403, 'Unauthorized');
        // }
        // //token: 5|v72mn4iVhcCdyr0srKGbDi91LwEMkXvvjyPrYb6l

        // //        $product = Product::create($request->all());
        // $product = new Product();
        // $product->save([
        //     $product->name = $request->input('name'),
        //     $product->details = $request->input('details'),
        //     $product->price = $request->input('price'),
        //     $product->description = $request->input('description'),
        //     $product->featured = $request->input('featured'),
        //     $product->quantity = $request->input('quantity'),
        // ]);
        // $product->categories()->sync($request->input('categories', []));

        // return response()
        //     ->json($product)
        //     ->setStatusCode(201, 'Created');
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
        // if (!auth()->user()->tokenCan('products-delete')) {
        //     abort(403, 'Unauthorized');
        // }

        // //token: 

        // $product->delete();

        // return response()
        //     ->json()
        //     ->setStatusCode(204, 'Deleted (soft)');
    }

    public function remove($id)
    {
        // if (!auth()->user()->tokenCan('products-remove')) {
        //     abort(403, 'Unauthorized');
        // }

        // //token: 

        // Product::where('id', $id)->forceDelete();

        // return response()
        //     ->json()
        //     ->setStatusCode(204, 'Removed');
    }
}