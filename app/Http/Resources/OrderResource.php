<?php

namespace App\Http\Resources;

use App\Models\Book;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Order $resource
 */
class OrderResource extends JsonResource
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
            'order_type' => class_basename($this->resource->orderable_type),
            'order_title' => $this->resource->orderable?->orderTitle(),
            'total' => $this->resource->total,
            'sub_total' => $this->resource->sub_total,
            'currency' => $this->resource->currency,
            'type' => $this->type(),
            'status' => $this->resource->status->toFullArray(),
            'created_at' => $this->resource->created_at,
            'href' => $this->href(),
            'is_book' => $this->resource->orderable_type === Book::class,
            'is_downloadable' => $this->isDownloadable(),
            'download_url' => $this->downloadUrl(),
        ];
    }

    public function isPaid(): bool
    {
        return $this->resource->status->isSuccess() && $this->resource->total > 0;
    }

    public function isFree(): bool
    {
        return $this->resource->status->isSuccess() && $this->resource->provider === 'OFFLINE';
    }

    public function type(): string
    {
        $type = 'Unknown';

        if ($this->isFree()) {
            $type = 'Free';
        }

        if ($this->isPaid()) {
            $type = 'Paid';
        }

        return $type;
    }

    public function href()
    {
        // If resource orderable is Course
        if ($this->resource->orderable_type === Course::class) {
            return route('courses.sections.section', $this->resource->orderable?->slug);
        }

        // If resource orderable is Book
        if ($this->resource->orderable_type === Book::class) {
            return route('books.index');
        }
    }

    /**
     * Check if the order is for a downloadable book
     */
    public function isDownloadable(): bool
    {
        // Only successful orders for books are downloadable
        if ($this->resource->status->isSuccess() && $this->resource->orderable_type === Book::class) {
            // Check if the book has a file to download
            return $this->resource->orderable && $this->resource->orderable->file_src;
        }

        return false;
    }

    /**
     * Get the download URL for a book
     */
    public function downloadUrl(): ?string
    {
        if ($this->isDownloadable()) {
            return route('books.download.page', ['book' => $this->resource->orderable->id]);
        }

        return null;
    }
}
