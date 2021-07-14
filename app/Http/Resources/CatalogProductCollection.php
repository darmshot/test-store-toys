<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class CatalogProductCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => CatalogProductThumbResource::collection($this->resource['products']),
            'meta' => [
                'current_page' => (int)$this->resource['products']->currentPage(),
                'total'        => (int)$this->resource['products']->total(),
                'per_page' => (int)$this->resource['products']->perPage()
            ],
        ];
    }
}
