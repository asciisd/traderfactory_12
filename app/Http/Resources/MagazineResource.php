<?php

namespace App\Http\Resources;

use App\Models\Magazine;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Magazine $resource
 */
class MagazineResource extends JsonResource
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
            'slug' => $this->resource->slug,
            'duration' => $this->resource->duration,
            'user_progress' => $this->resource->user_progress,
            'icon' => 'BookOpenIcon',
            'href' => route('magazines.show', $this),
            'slides' => SlideResource::collection($this->resource->slides),
        ];
    }
}
