<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Visual extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Visual>
     */
    public static $model = \App\Models\Visual::class;

    /**
     * The policy the resource corresponds to.
     *
     * @var class-string
     * */
    public static $policy = Policies\VisualPolicy::class;

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
        'id', 'title', 'slug', 'description',
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

            Text::make('Title')->rules('required'),
            Slug::make('Slug')
                ->from('title')
                ->separator('-')
                ->rules('required')
                ->hideFromIndex(),

            Text::make('Duration')
                ->help('duration in string format - ex: 2 min 15 sec')
                ->rules('required'),

            Number::make('Duration Seconds')
                ->help('duration in seconds format - ex: 300')
                ->rules('required'),

            Image::make('Poster', 'video_poster')
                ->disk('s3_public')
                ->path('visuals')
                ->prunable()
                ->rules('nullable'),

            File::make('Video', 'video_url')
                ->disk('s3_public')
                ->path('visuals')
                ->prunable()
                ->creationRules(['required']),

            Select::make('Video Type')
                ->options(['video/mp4' => 'MP4'])
                ->rules('nullable')
                ->hideFromIndex()
                ->displayUsingLabels(),

            BelongsTo::make('Lesson')->hideFromIndex(),
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
