<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionsResource extends JsonResource
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
            'question_id' => $this->question_id,
            'question'=>$this->question,
            'question_order' => $this->question_order,
            'is_required' => $this->is_required,
            'answer_type' => $this->answer_type_id,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'up_question_id' => $this->up_question_id,
            'section_id' => $this->section_id,
            'question_options' => QuestionOptionsResource::collection($this->whenLoaded('questionoptions'))

        ];
    }
}
