<?php

namespace App\Http\Resources;

use App\Models\QuickQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property QuickQuestion resource
 */
class QuickQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'question' => $this->resource->question,
            'correct_answer' => $this->resource->correct_answer,
            'quick_answers' => $this->resource->quickAnswers,
        ];
    }
}
