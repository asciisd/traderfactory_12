<?php

namespace App\Http\Resources;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

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
        return collect([
            $this->whenLoaded('goal', $this->goal()),
            $this->whenLoaded('magazine', $this->magazine()),
            $this->whenLoaded('revision', $this->revision()),
            $this->whenLoaded('todo', $this->todo()),
            $this->whenLoaded('quickScan', $this->quickScan()),
            $this->whenLoaded('quiz', $this->quiz()),
            $this->whenLoaded('visual', $this->visual()),
        ])->reject(null)->all();
    }

    private function goal(): Collection
    {
        return collect([
            'model' => 'Goal',
            'item' => $this->resource->goal,
            'title' => 'ماذا ستتعلم في هذه الوحدة',
            'href' => $this->resource->goal ? route('goals.show', $this->resource->goal) : '#',
        ]);
    }

    private function magazine(): Collection
    {
        return collect([
            'model' => 'Magazine',
            'item' => $this->resource->magazine,
            'title' => 'لنبدأ التعلم',
            'href' => $this->resource->magazine ? route('magazines.show',
                $this->resource->magazine) : '#',
        ]);
    }

    private function revision(): Collection
    {
        return collect([
            'model' => 'Revision',
            'item' => $this->resource->revision,
            'title' => 'مراجعة سريعة',
            'href' => $this->resource->revision ? route('revisions.show',
                $this->resource->revision) : '#',
        ]);
    }

    private function todo(): Collection
    {
        return collect([
            'model' => 'Todo',
            'item' => $this->resource->todo,
            'title' => 'مارس بنفسك',
            'href' => $this->resource->todo ? route('todos.show', $this->resource->todo) : '#',
        ]);
    }

    private function quickScan(): Collection
    {
        return collect([
            'model' => 'QuickScan',
            'item' => $this->resource->quickScan,
            'title' => 'اختبر نفسك',
            'href' => $this->resource->quickScan ? route('quickScans.show',
                $this->resource->quickScan) : '#',
        ]);
    }

    private function quiz(): Collection
    {
        return collect([
            'model' => 'Quiz',
            'item' => $this->resource->quiz,
            'title' => 'أسئلة',
            'href' => $this->resource->quiz ? route('quizzes.show',
                $this->resource->quiz) : '#',
        ]);
    }

    private function visual(): Collection
    {
        return collect([
            'model' => 'Visual',
            'item' => $this->resource->visual,
            'title' => 'فيديو',
            'href' => $this->resource->visual ? route('visuals.show',
                $this->resource->visual) : '#',
        ]);
    }
}
