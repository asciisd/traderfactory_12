<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Section extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Section>
     */
    public static $model = \App\Models\Section::class;

    /**
     * The policy the resource corresponds to.
     *
     * @var class-string
     * */
    public static $policy = Policies\SectionPolicy::class;

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
        'id', 'title', 'description'
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

            BelongsTo::make('Course'),

            Image::make('Background', 'background_src', 's3_public')
                ->path('sections')
                ->prunable()
                ->hideFromIndex(),

            Text::make('Title')->rules('required', 'max:254'),

            Slug::make('Slug')
                ->from('Title')
                ->separator('-')
                ->hideFromIndex(),

            Text::make('Name')->rules('required', 'max:254'),

            Select::make('Color')
                ->options([
                    'bg-product-pink' => 'Pink',
                    'bg-product-blue' => 'Blue',
                    'bg-product-green' => 'Green',
                    'bg-product-orange' => 'Orange',
                    'bg-product-beige' => 'Beige',
                    'bg-product-lightBlue' => 'Light Blue',
                ])->displayUsingLabels(),

            Trix::make('Overview')
                ->rules('required', 'max:1000')
                ->stacked(),

            Text::make('Description')
                ->rules('required', 'max:254'),

            Text::make('Duration')
                ->rules('required', 'max:254'),

            Panel::make('Video', [
                Image::make('Poster', 'video_poster', 's3_public')
                    ->path('sections')
                    ->prunable()
                    ->hideFromIndex(),

                File::make('Video', 'video_src', 's3_public')
                    ->path('sections')
                    ->prunable()
                    ->hideFromIndex(),

                Select::make('Video Type', 'video_type')
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
                    ->path('meta/sections')
                    ->prunable()
                    ->hideFromIndex(),

            ]),

            HasMany::make('Lessons', 'lessons'),
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
