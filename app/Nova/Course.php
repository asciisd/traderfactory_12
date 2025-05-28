<?php

namespace App\Nova;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Course extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Course>
     */
    public static $model = \App\Models\Course::class;

    /**
     * The policy the resource corresponds to.
     *
     * @var class-string
     * */
    public static $policy = Policies\CoursePolicy::class;

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
        'id', 'title', 'slug', 'description'
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

            Image::make('Background', 'background_src', 's3_public')
                ->path('courses')
                ->prunable()
                ->hideFromIndex(),

            Text::make('Title')
                ->rules('required', 'max:254'),

            Slug::make('Slug')
                ->from('title')
                ->separator('-')
                ->rules('required', 'max:254')
                ->creationRules('unique:courses,slug')
                ->updateRules('unique:courses,slug,{{resourceId}}')
                ->hideFromIndex(),

            Currency::make('Price')
                ->nullable()
                ->hideFromIndex(),

            Number::make('Tax')
                ->step(0.01)
                ->nullable()
                ->hideFromIndex(),

            Number::make('Discount')
                ->step(0.01)
                ->nullable()
                ->hideFromIndex(),

            DateTime::make('Published At')
                ->rules(['required'])
                ->sortable(),

            Boolean::make('Active'),

            Textarea::make('description')
                ->rules('required', 'max:254'),

            Panel::make('Video', [
                Image::make('Poster', 'video_poster', 's3_public')
                    ->path('courses')
                    ->prunable()
                    ->hideFromIndex(),

                File::make('Video', 'video_src', 's3_public')
                    ->path('courses')
                    ->prunable()
                    ->hideFromIndex(),

                Select::make('Video Type')
                    ->options([
                        'video/mp4' => 'MP4',
                    ])
                    ->rules('nullable')
                    ->displayUsingLabels(),
            ]),
            Panel::make('SEO', [
                Text::make('SEO Title', 'seo_title')->hideFromIndex(),
                Text::make('Meta Title', 'meta_title')->hideFromIndex(),
                Text::make('Meta Description', 'meta_description')->hideFromIndex(),
                Text::make('Meta Keywords', 'meta_keywords')->hideFromIndex(),
                Image::make('Meta Image', 'meta_image', 's3_public')
                    ->path('meta/courses')
                    ->prunable()
                    ->hideFromIndex(),

            ]),

            HasMany::make('Sections'),
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
