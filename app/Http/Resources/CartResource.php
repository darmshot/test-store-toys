<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->name,
            'quantity' => $this->quantity,
            'total' => \Currency::format($this->getPriceSum(),'byn'),
            'price' => $this->associatedModel->getPrice(),
            'thumb' => $this->associatedModel->thumb,
            'url' => $this->associatedModel->url,
            'sku' => $this->associatedModel->sku,
        ];
    }
}
