<?php

namespace App\Http\Resources;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property Goal $resource
 */
class GoalResource extends JsonResource
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
            'points' => $this->resource->points,
            'slug' => $this->resource->slug,
            'duration' => $this->resource->duration,
            'background_url' => Storage::disk('s3')->url($this->resource->background_url),
            'user_progress' => $this->resource->user_progress,
            'icon' => 'AcademicCapIcon',
            'href' => route('goals.show', $this),
            's3_image' => Storage::disk('s3')->url($this->resource->background_url),
        ];
    }
}
