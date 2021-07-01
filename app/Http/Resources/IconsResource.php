<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IconsResource extends JsonResource
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
                'icon_id' => $this->icon_id,
                'icon_name' => $this->icon_name,
                'icon_url' => 'http://localhost:8000/storage/files/'.$this->icon_url,
                'created_at' => (string) $this->created_at,
                'updated_at' => (string) $this->updated_at,
                'default_icon_set' =>$this->default_icon_set
              ];
    }
}
