<?php

namespace App\Http\Resources\Invoices;

use Illuminate\Http\Resources\Json\JsonResource;

class Invoice extends JsonResource
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

            'client_id' => $this->client_id,

            'client' => new Clients\Client($this->whenLoaded('client')),
            'items'  => new Items\ItemCollection($this->whenLoaded('items')),

            'status' => $this->status,

            'total' => $this->total,
            
            'invoiced_at' => $this->invoiced_at,
            'due_until'   => $this->due_until,
            'paid_at'     => $this->paid_at
        ];
    }
}
