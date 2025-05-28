<?php

namespace App\Http\Resources;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Lesson $resource
 */
class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'duration' => $this->resource->duration,
            'slug' => $this->resource->slug,
            'activities' => $this->activities(),
            'section_slug' => $this->resource->section->slug,
            'meta_seo' => $this->resource->meta_seo,
            'meta_title' => $this->resource->meta_title,
            'meta_description' => $this->resource->meta_description,
            'meta_keywords' => $this->resource->meta_keywords,
            'meta_image' => $this->resource->meta_image,
        ];
    }

    private function activities(): array
    {
        return [
            'goal' => [
                'item' => $this->resource->goal,
                'title' => 'ماذا ستتعلم في هذه الوحدة',
                'icon' => 'AcademicCapIcon',
                'href' => $this->resource->goal ? route('goals.show', $this->resource->goal) : '#',
            ],
            'magazine' => [
                'item' => $this->resource->magazine,
                'title' => 'لنبدأ التعلم',
                'icon' => 'BookOpenIcon',
                'href' => $this->resource->magazine ? route('magazines.show',
                    $this->resource->magazine) : '#',
            ],
            'revision' => [
                'item' => $this->resource->revision,
                'title' => 'مراجعة سريعة',
                'icon' => 'ForwardIcon',
                'href' => $this->resource->revision ? route('revisions.show',
                    $this->resource->revision) : '#',
            ],
            'todo' => [
                'item' => $this->resource->todo,
                'title' => 'مارس بنفسك',
                'icon' => 'ClipboardDocumentListIcon',
                'href' => $this->resource->todo ? route('todos.show', $this->resource->todo) : '#',
            ],
            'quickScan' => [
                'item' => $this->resource->quickScan,
                'title' => 'اختبر نفسك',
                'icon' => 'MagnifyingGlassIcon',
                'href' => $this->resource->quickScan ? route('quickScans.show',
                    $this->resource->quickScan) : '#',
            ],
            'quiz' => [
                'item' => $this->resource->quiz,
                'title' => 'أسئلة',
                'icon' => 'QuestionMarkCircleIcon',
                'href' => $this->resource->quiz ? route('quizzes.show',
                    $this->resource->quiz) : '#',
            ],
            'visual' => [
                'item' => VisualResource::make($this->resource->visual),
                'title' => 'فيديو',
                'icon' => 'VideoCameraIcon',
                'href' => $this->resource->visual ? route('visuals.show',
                    $this->resource->visual) : '#',
            ],
        ];
    }
}
