<?php

namespace App\Nova;

use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Book extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Book>
     */
    public static $model = \App\Models\Book::class;

    /**
     * The policy the resource corresponds to.
     *
     * @var class-string
     * */
    public static $policy = Policies\BookPolicy::class;

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
        'id', 'name', 'description',
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

            Image::make('Image', 'image_src', 's3_public')
                ->path('books')
                ->prunable()
                ->hideFromIndex(),

            Text::make('image alternative', 'image_alt')
                ->rules('required', 'max:100')
                ->help('this text will show up if the image is not shows for any reason'),

            Text::make('Name', 'name')->rules('required', 'max:255'),

            Text::make('Price'),

            File::make('PDF File', 'file_src', 's3_public')
                ->path('books')
                ->prunable()
                ->hideFromIndex(),

            Text::make('File CTA', 'file_cta')->rules('required', 'max:100'),

            Trix::make('Description')->rules('required'),
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
