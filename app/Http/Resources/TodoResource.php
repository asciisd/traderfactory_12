<?php

namespace App\Http\Resources;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property Todo $resource
 */
class TodoResource extends JsonResource
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
            'slug' => $this->resource->slug,
            'duration' => $this->resource->duration,
            'description' => $this->resource->description,
            'background_url' => Storage::disk('s3')->url($this->resource->background_url),
            'user_progress' => $this->resource->user_progress,
            'icon' => 'ClipboardDocumentListIcon',
            'href' => route('todos.show', $this),
            's3_image' => Storage::disk('s3')->url($this->resource->background_url),
        ];
    }
}
