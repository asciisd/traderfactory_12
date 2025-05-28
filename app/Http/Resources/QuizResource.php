<?php

namespace App\Http\Resources;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property Quiz $resource
 */
class QuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->resource->title,
            'info' => $this->resource->info,
            'background_url' => Storage::disk('s3')->url($this->resource->background_url),
            'slug' => $this->resource->slug,
            'duration' => $this->resource->duration,
            'quantity' => $this->resource->quantity,
            'user_progress' => $this->resource->user_progress,
            'quiz_questions' => $this->resource->quizQuestions()->get(),
            'icon' => 'QuestionMarkCircleIcon',
            'href' => route('quizzes.show', $this),
        ];
    }
}
