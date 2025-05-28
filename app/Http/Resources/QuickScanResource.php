<?php

namespace App\Http\Resources;

use App\Models\QuickScan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property QuickScan $resource
 */
class QuickScanResource extends JsonResource
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
            'duration' => $this->resource->duration,
            'quantity' => $this->resource->quantity,
            'rating' => $this->resource->rating,
            'slug' => $this->resource->slug,
            'background_url' => Storage::disk('s3')->url($this->resource->background_url),
            'user_progress' => $this->resource->user_progress,
            's3_image' => Storage::disk('s3')->url($this->resource->background_url),
            'icon' => 'MagnifyingGlassIcon',
            'href' => route('quickScans.show', $this),
            'quick_questions' => QuickQuestionResource::collection($this->resource->quickQuestions),
        ];
    }
}
