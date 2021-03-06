<?php

namespace App;

use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use SoftDeletes, SearchableTrait, Searchable, Sluggable, HasApiTokens;

    //    protected $fillable = ['quantity'];
    protected $guarded = [];
    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.name' => 10,
            'products.categories' => 7,
            'products.details' => 5,
            'products.description' => 2,
        ],
    ];

    protected $dates = ['deleted_at', 'created_at', 'deleted_at'];


    // We needed for Algolia instant search to show categories section, because we don't have categories attribute in Algolia products dashboard
    //! So we need to run: <<php artisan scout:flush "App\Product">>, and then:  <<php artisan scout:import "App\Product">>
    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        $extraFields = [
            'categories' => $this->categories->pluck('name')->toArray(),
        ];

        return array_merge($array, $extraFields);
    }

    public function shouldBeSearchable()
    {
        return $this->quantity > 0;
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'category_product',
            'product_id',
            'category_id',
            'id',
            'id'
        )
            ->withPivot('created_at');
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    public function presentPrice()
    {
        return number_format($this->price, 2);
    }


    public function productImage()
    {
        return env('APP_URL') . '/storage/files/1/Products/' . $this->slug . '/' . $this->image ?
            env('APP_URL') . '/storage/files/1/Products/' . $this->slug . '/' . $this->image
            : env('APP_URL') . '/storage/files/1/Products/default/' . $this->image;
    }


    public function productImages($image)
    {
        return env('APP_URL') . '/storage/files/1/Products/' . $this->slug . '/' . $image ?
            env('APP_URL') . '/storage/files/1/Products/' . $this->slug . '/' . $image :
            env('APP_URL') . '/storage/files/1/Products/default/' . $image;
    }


    // function for query of random products
    public function scopeMightAlsoLike($query)
    {
        return $query->inRandomOrder()->take(4);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}