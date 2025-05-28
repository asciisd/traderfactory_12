<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Order>
     */
    public static $model = \App\Models\Order::class;

    /**
     * The policy the resource corresponds to.
     *
     * @var class-string
     * */
    public static $policy = Policies\OrderPolicy::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'transaction_id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'transaction_id'
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

            BelongsTo::make('User')->searchable(),

            MorphTo::make('Orderable', 'orderable')
                ->types([
                    Course::class,
                    Book::class,
                ]),

            Text::make('Transaction ID', 'transaction_id')
                ->readonly(true),

            Text::make('Status', 'status'),

            Text::make('Conversion Rate', 'conversion_rate')
                ->readonly(true)
                ->hideFromIndex(),

            Text::make('Vendor Fees', 'vendor_fees')
                ->readonly(true)
                ->hideFromIndex(),

            Text::make('Currency', 'currency')
                ->readonly(true)
                ->hideFromIndex(),

            Text::make('Method', 'method')
                ->readonly(true),

            Text::make('Provider', 'provider')
                ->readonly(true),

            Text::make('Total', 'total')
                ->readonly(true)
                ->hideFromIndex(),

            Text::make('Subtotal', 'sub_total')
                ->readonly(true)
                ->hideFromIndex(),
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
