<?php

namespace App\Http\Resources\Invoices\Items;

use Illuminate\Http\Resources\Json\JsonResource;

class Item extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            'invoice_id' => $this->invoice_id,

            'description' => $this->description,
            'quantity' => $this->quantity,
            'price' => (float) $this->price,
        ];
    }
}
