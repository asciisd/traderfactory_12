<?php

namespace App\Http\Resources;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property Course $resource
 */
class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'title_line2' => $this->resource->title_line2,
            'description' => $this->resource->description,
            'slug' => $this->resource->slug,
            'video_src' => Storage::disk('s3')->url($this->resource->video_src),
            'video_type' => $this->resource->video_type,
            'video_poster' => Storage::disk('s3')->url($this->resource->video_poster),
            'background_src' => Storage::disk('s3')->url($this->resource->background_src),
            'meta_seo' => $this->resource->meta_seo,
            'meta_title' => $this->resource->meta_title,
            'meta_description' => $this->resource->meta_description,
            'meta_keywords' => $this->resource->meta_keywords,
            'meta_image' => $this->resource->meta_image,
            'sections' => $this->whenLoaded('sections', SectionResource::collection($this->resource->sections)),
            'price' => $this->resource->price,
            'discount' => $this->resource->discount,
        ];
    }
}
