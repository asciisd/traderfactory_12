<?php

namespace App\Http\Resources;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property Slide $resource
 */
class SlideResource extends JsonResource
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
            'description' => $this->resource->description,
            'background_url' => Storage::disk('s3')->url($this->resource->background_url),
            'layout' => $this->resource->layout,
            'slide_items' => $this->resource->slide_items,
            's3_image' => Storage::disk('s3')->url($this->resource->background_url),
        ];
    }
}
