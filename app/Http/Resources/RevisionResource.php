<?php

namespace App\Http\Resources;

use App\Models\Revision;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property Revision $resource
 */
class RevisionResource extends JsonResource
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
            'background_url' => Storage::disk('s3')->url($this->resource->background_url),
            'user_progress' => $this->resource->user_progress,
            's3_image' => Storage::disk('s3')->url($this->resource->background_url),
            'icon' => 'ForwardIcon',
            'href' => route('revisions.show', $this),
            'items' => $this->resource->revisionItems()->get(),
        ];
    }
}