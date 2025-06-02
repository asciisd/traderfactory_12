<?php

namespace App\Nova;

use App\Enums\EventableEvent;
use App\Nova\Actions\SendTestEmail;
use Illuminate\Http\Request;
use InteractionDesignFoundation\NovaUnlayerField\Unlayer;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class EmailOnEvent extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\EmailOnEvent>
     */
    public static $model = \App\Models\EmailOnEvent::class;

    /**
     * The policy the resource corresponds to.
     *
     * @var class-string
     * */
    public static $policy = Policies\EmailOnEventPolicy::class;

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
        'id', 'title', 'event', 'eventable_id'
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

            Text::make('Title', 'title')->rules('required'),

            MorphTo::make('Eventable')->types([
                Goal::class,
                Magazine::class,
                QuickScan::class,
                Quiz::class,
                Revision::class,
                Todo::class,
                Visual::class,
                Lesson::class,
                Section::class,
            ])->withSubtitles(),

            Select::make('Event', 'event')
                ->rules('required')
                ->displayUsingLabels()
                ->options(EventableEvent::toArray()),

            Unlayer::make('Message', 'message')
                ->rules('required')
                ->config([
                    'projectId' => config('unlayer.project_id'),
                ])->savingCallback(function (
                    NovaRequest $request,
                                $attribute,
                    \App\Models\EmailOnEvent $eoe,
                    $outputHtmlFieldName
                ) {
                    $eoe->html = $request->input($outputHtmlFieldName);
                })->html(fn () => $this->html)->fullWidth()->stacked(),
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
        return [
            SendTestEmail::make()
        ];
    }
}
