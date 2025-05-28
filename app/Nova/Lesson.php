<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Lesson extends Resource
{
    use HasSortableRows;

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Lesson>
     */
    public static $model = \App\Models\Lesson::class;

    /**
     * The policy the resource corresponds to.
     *
     * @var class-string
     * */
    public static $policy = Policies\LessonPolicy::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Level', 'level')->filterable(),
            BelongsTo::make('Section', 'section')->filterable(),

            Text::make('Name', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Slug::make('Slug', 'slug')
                ->from('name')
                ->separator('-')
                ->creationRules('required', 'max:254', 'unique:lessons,slug')
                ->updateRules('required', 'max:254', 'unique:lessons,slug,{{resourceId}}')
                ->hideFromIndex(),

            Text::make('Duration', 'duration')
                ->rules('max:255'),

            Panel::make('SEO', [
                Text::make('SEO Title', 'seo_title')->hideFromIndex(),
                Text::make('Meta Title', 'meta_title')->hideFromIndex(),
                Text::make('Meta Description', 'meta_description')->hideFromIndex(),
                Text::make('Meta Keywords', 'meta_keywords')->hideFromIndex(),
                Image::make('Meta Image', 'meta_image', 's3_public')
                    ->path('meta/lessons')
                    ->prunable()
                    ->hideFromIndex(),

            ]),

            HasOne::make('Goal', 'goal')->nullable(),
            HasOne::make('Magazine', 'magazine')->nullable(),
            HasOne::make('Revision', 'revision')->nullable(),
            HasOne::make('Todo', 'todo')->nullable(),
            HasOne::make('Quick Scan', 'quickScan')->nullable(),
            HasOne::make('Quiz', 'quiz')->nullable(),
            HasOne::make('Visual', 'visual')->nullable(),
        ];
    }

    /**
     * Get the cards available for the resource.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array<int, \Laravel\Nova\Lenses\Lens>
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array<int, \Laravel\Nova\Actions\Action>
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
