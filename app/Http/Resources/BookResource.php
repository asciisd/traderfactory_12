<?php

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property Book resource
 */
class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isOwned = $this->resource->purchased();

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'imageSrc' => Storage::disk('s3')->url($this->resource->image_src),
            'fileSrc' => $this->when($isOwned, Storage::disk('s3')->url($this->resource->file_src)),
            'fileCta' => $isOwned ? 'تحميل الكتاب' : $this->resource->file_cta,
            'imageAlt' => $this->resource->image_alt,
            'price' => $this->resource->price,
            'isOwned' => $isOwned,
            'can' => [
                'view' => $request->user()?->can('view', $this->resource) || $isOwned,
            ],
            'downloadUrl' => $this->when($isOwned, route('books.download.page', ['book' => $this->resource->id])),
        ];
    }
}
