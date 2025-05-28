<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Slide extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Slide>
     */
    public static $model = \App\Models\Slide::class;

    /**
     * The policy the resource corresponds to.
     *
     * @var class-string
     * */
    public static $policy = Policies\SlidePolicy::class;

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
        'id', 'title', 'description',
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
            BelongsTo::make('Magazine')->sortable(),

            Image::make('Background', 'background_url', 's3_public')
                ->path('slides')
                ->prunable(),

            Text::make('Title'),

            Select::make('Layout')->options([
                'half-screen-layout' => 'Default Half Screen',
                'right-half-screen-layout' => 'Right Half Screen',
                'left-half-screen-layout' => 'Left Half Screen',
                'boxes-slide-layout' => 'Boxes',
                'final-slide-layout' => 'Final Slide',
            ])->displayUsingLabels(),

            Trix::make('Description')
                ->hideFromIndex()
                ->stacked(),

            HasMany::make('Slide Items'),

            DateTime::make('created_at')->onlyOnDetail(),
            DateTime::make('updated_at')->onlyOnDetail(),
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
