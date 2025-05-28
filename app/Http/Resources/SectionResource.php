<?php

namespace App\Http\Resources;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property Section resource
 */
class SectionResource extends JsonResource
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
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'slug' => $this->resource->slug,
            'course_id' => $this->resource->course_id,
            'course_price' => $this->whenLoaded('course', $this->resource->course->price),
            'video_src' => Storage::disk('s3')->url($this->resource->video_src),
            'video_type' => $this->resource->video_type,
            'video_poster' => Storage::disk('s3')->url($this->resource->video_poster),
            'background_src' => Storage::disk('s3')->url($this->resource->background_src),
            'image_alt' => $this->resource->image_alt,
            'color' => $this->resource->color,
            'meta_seo' => $this->resource->meta_seo,
            'meta_title' => $this->resource->meta_title,
            'meta_description' => $this->resource->meta_description,
            'meta_keywords' => $this->resource->meta_keywords,
            'meta_image' => $this->resource->meta_image,
            'lessons' => $request->routeIs('courses.sections.section') ? $this->getLessons() : $this->resource->lessons,
            'lessons_count' => $this->whenLoaded('lessons', count($this->resource->lessons)),
            'duration' => $this->resource->duration,
            'overview' => $this->resource->overview,
            's3_image' => Storage::disk('s3')->url($this->resource->background_src),
            'video_options' => $this->videoOptions(),
            'is_free' => $this->whenLoaded('course',$this->resource->course->isFree()),
            'can' => [
                'view' => $request->user()?->can('view', $this->resource),
            ],
        ];
    }

    protected function getLessons(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return LessonResource::collection($this->resource->lessons->load([
            'goal', 'magazine', 'revision', 'todo', 'quickScan', 'quiz', 'visual',
        ]));
    }

    private function videoOptions(): array
    {
        return [
            'aspectRatio' => '16:9',
            'autoplay' => false,
            'controls' => true,
            'sources' => [
                'src' => Storage::disk('s3')->url($this->resource->video_src),
                'type' => $this->resource->video_type,
            ],
            'poster' => Storage::disk('s3')->url($this->resource->video_poster),
        ];
    }
}
