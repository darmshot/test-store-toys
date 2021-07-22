<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CatalogProductThumbResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'     => $this->id,
            'title'  => $this->title,
            'url'   => $this->url,
            'thumbs' => $this->thumbs,
            'sku'    => $this->sku,
            'manufacturer'=> CatalogManufacturerResource::make($this->manufacturer),
            'stock_status' => $this->getStockStatus(),
            'price' => $this->getPrice(),
            'special' => $this->getPriceSpecial(),
            'percent' => $this->getPriceSpecialPercent()

        ];
    }
}
