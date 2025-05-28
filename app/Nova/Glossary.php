<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Glossary extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Glossary>
     */
    public static $model = \App\Models\Glossary::class;

    /**
     * The policy the resource corresponds to.
     *
     * @var class-string
     * */
    public static $policy = Policies\GlossaryPolicy::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title_ar';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title', 'title_ar', 'initials', 'initials_ar', 'category', 'category_ar', 'topic', 'topic_ar',
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

            Text::make('Title')->sortable(),
            Text::make('Initials')->sortable(),
            Text::make('Category')->sortable(),
            Text::make('Topic')->sortable(),
            Trix::make('Body')->hideFromIndex(),

            Panel::make('Arabic Translation', [
                Text::make('Title Ar')->rules('required')->sortable(),
                Slug::make('Slug')->placeholder('forex-description')->from('title_ar')->rules('required')->hideFromIndex(),
                Text::make('Initials Ar')->rules('required')->sortable(),
                Text::make('Category Ar')->placeholder('فوركس')->rules('required')->sortable(),
                Text::make('Topic Ar')->sortable(),
                Trix::make('Body Ar')->hideFromIndex(),
            ]),
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
