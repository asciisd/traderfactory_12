<?php

namespace App\Http\Resources;

use App\Models\Glossary;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property  Glossary $resource
 */
class GlossaryResource extends JsonResource
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
            'title' => app()->getLocale() == 'en' ? $this->resource->title : $this->resource->title_ar,
            'initial' => app()->getLocale() == 'en' ? $this->resource->initials : $this->resource->initials_ar,
            'slug' => $this->resource->slug,
            'category' => app()->getLocale() == 'en' ? $this->resource->category : $this->resource->category_ar,
            'topic' => app()->getLocale() == 'en' ? $this->resource->topic : $this->resource->topic_ar,
            'body' => app()->getLocale() == 'en' ? $this->resource->body : $this->resource->body_ar,
        ];
    }
}
