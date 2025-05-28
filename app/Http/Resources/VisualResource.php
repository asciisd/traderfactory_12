<?php

namespace App\Http\Resources;

use App\Models\Visual;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property Visual $resource
 */
class VisualResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'slug' => $this->resource->slug,
            'duration' => $this->resource->duration_seconds
                ? CarbonInterval::seconds($this->resource->duration_seconds)->cascade()->forHumans()
                : $this->resource->duration,
            'duration_seconds' => $this->resource->duration_seconds,
            'video_url' => Storage::disk('s3')->url($this->resource->video_url),
            'icon' => 'VideoCameraIcon',
            'href' => route('visuals.show', $this),
            'user_progress' => $this->resource->user_progress,
            'videoOptions' => $this->videoOptions(),
        ];
    }

    private function videoOptions(): array
    {
        return [
            'aspectRatio' => '16:9',
            'autoplay' => false,
            'controls' => true,
            'sources' => $this->videoSources(),
            'poster' => $this->resource->video_poster ? Storage::disk('s3')->url($this->resource->video_poster) : '',
        ];
    }

    private function videoSources(): array
    {
        return [
            [
                'src' => $this->resource->video_url ? Storage::disk('s3')->url($this->resource->video_url) ?? '' : '',
                'type' => $this->resource->video_type,
            ],
        ];
    }
}
