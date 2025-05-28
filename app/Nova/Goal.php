<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Goal extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Goal>
     */
    public static $model = \App\Models\Goal::class;

    /**
     * The policy the resource corresponds to.
     *
     * @var class-string
     * */
    public static $policy = Policies\GoalPolicy::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'slug';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title', 'slug'
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

            BelongsTo::make('Lesson')->hideFromIndex(),

            Text::make('Title'),
            Slug::make('Slug')
                ->from('title')
                ->separator('-')
                ->rules('required', 'max:254')
                ->hideFromIndex(),

            Text::make('Duration')
                ->rules('required')
                ->default(function () {
                    return '٢ دقيقة';
                }),

            KeyValue::make('Points')
                ->rules('required', 'json')
                ->keyLabel('Order')
                ->valueLabel('Title')
                ->actionText('Add Point')
                ->hideFromIndex()
                ->stacked(),

            Image::make('Background', 'background_url', 's3_public')
                ->path('goals')
                ->prunable(),
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
