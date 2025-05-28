<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class QuizQuestion extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\QuizQuestion>
     */
    public static $model = \App\Models\QuizQuestion::class;

    /**
     * The policy the resource corresponds to.
     *
     * @var class-string
     * */
    public static $policy = Policies\QuizQuestionPolicy::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'question';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'question'
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
            Image::make('Background', 'background_url', 's3_public')
                ->path('quizzes')
                ->prunable(),

            Text::make('Question')
                ->rules('required', 'max:600'),

            Select::make('Correct Answer')
                ->options([
                    true => 'True',
                    false => 'False',
                ])
                ->displayUsingLabels()
                ->rules('required', 'max:255'),

            BelongsTo::make('Quiz'),
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
