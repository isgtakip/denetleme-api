<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionOptionsResource extends JsonResource
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
            'question_option_id' => $this->question_option_id,
            'option_id' => $this->option_id,
            'question_id' => $this->question_id,
            'option' =>  new OptionsResource($this->options)
        ];
    }
}
