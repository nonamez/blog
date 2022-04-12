<?php

namespace App\Http\Resources\Files;

use Illuminate\Http\Resources\Json\JsonResource;

class File extends JsonResource
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

            'name' => $this->name,
            'original_name' => $this->original_name,

            'routes' => $this->routes,

            'assigned' => $this->when($this->fileable, function() {
                return [
                    'title'   => $this->fileable->title,
                    'preview' => $this->fileable->routes->preview,
                ];
            }),

            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
