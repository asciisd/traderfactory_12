<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class QuickScan extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\QuickScan>
     */
    public static $model = \App\Models\QuickScan::class;

    /**
     * The policy the resource corresponds to.
     *
     * @var class-string
     * */
    public static $policy = Policies\QuickScanPolicy::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title', 'slug',
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

            Text::make('Title')
                ->rules('required', 'max:255'),

            Slug::make('Slug')
                ->from('title')
                ->separator('-')
                ->rules('required')
                ->hideFromIndex(),

            Text::make('Quantity')
                ->rules('required', 'max:255')
                ->hideFromIndex(),

            Text::make('Duration')
                ->rules('required', 'max:255'),

            Text::make('Rating')
                ->rules('required', 'max:255')
                ->hideFromIndex(),

            Image::make('Background', 'background_url', 's3_public')
                ->path('quick_scans')
                ->prunable(),

            HasMany::make(__('Quick Questions'), 'quickQuestions'),
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
