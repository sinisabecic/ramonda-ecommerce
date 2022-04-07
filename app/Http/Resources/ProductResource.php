<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
//            'id' => $this->id,
            'name' => $this->name,
//            'slug' => $this->slug,
            'details' => $this->details,
            'price' => $this->price,
            'description' => preg_replace("/\r\n|\r|\n/", '<br/>', strip_tags($this->description)),
            'image' => $this->image,
            'images' => $this->images,
//            'created_at' => $this->created_at->format('d.m.Y. H:m:s'),
//            'updated_at' => $this->updated_at->format('d.m.Y. H:m:s'),
        ];
    }
}
