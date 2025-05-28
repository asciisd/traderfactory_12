<?php

namespace App\Http\Resources;

use App\Models\MetaData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property MetaData $resource
 */
class MetaDataResource extends JsonResource
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
            'image' => Storage::disk('s3')->url($this->resource->image),
            'page_slug' => $this->resource->page_slug,
            'keywords' => $this->resource->keywords,
        ];
    }
}
