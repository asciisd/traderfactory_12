<?php

namespace App\Nova;

use Laravel\Nova\Auth\PasswordValidationRules;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Email;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class User extends Resource
{
    use PasswordValidationRules;

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\User>
     */
    public static $model = \App\Models\User::class;

    /**
     * The policy the resource corresponds to.
     *
     * @var class-string
     * */
    public static $policy = Policies\UserPolicy::class;

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
        'id', 'name', 'email',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field|\Laravel\Nova\Panel|\Laravel\Nova\ResourceTool|\Illuminate\Http\Resources\MergeValue>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Avatar::make('Profile Photo', 'profile_photo_path')
                ->disk('s3_public')
                ->path('profile-photos')
                ->prunable()
                ->maxWidth(50),

            Text::make('First Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Last Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Email::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Text::make('Phone')
                ->sortable()
                ->rules('required', 'phone', 'max:254')
                ->creationRules('unique:users,phone')
                ->updateRules('unique:users,phone,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules($this->passwordRules())
                ->updateRules($this->optionalPasswordRules()),

            Datetime::make('Email Verified At')
                ->sortable()
                ->readonly(),

            Country::make('Country')
                ->sortable()
                ->rules('required', 'max:254'),

            Datetime::make('Created At')
                ->sortable()
                ->readonly()
                ->hideFromIndex(),

            Panel::make('Source', [
                Text::make('UTM Source', 'utm_source')
                    ->sortable()
                    ->readonly()
                    ->rules('max:254')
                    ->hideFromIndex(),

                Text::make('UTM Content', 'utm_content')
                    ->sortable()
                    ->hideFromIndex()
                    ->readonly()
                    ->rules('max:254')
                    ->hideFromIndex(),

                Text::make('UTM Medium', 'utm_medium')
                    ->sortable()
                    ->readonly()
                    ->rules('max:254')
                    ->hideFromIndex(),

                Text::make('UTM Campaign', 'utm_campaign')
                    ->sortable()
                    ->readonly()
                    ->rules('max:254')
                    ->hideFromIndex(),

                Text::make('UTM Term', 'utm_term')
                    ->sortable()
                    ->hideFromIndex()
                    ->readonly()
                    ->rules('max:254')
                    ->hideFromIndex(),
            ]),

            HasMany::make('Orders', 'orders'),
        ];
    }

    /**
     * Get the cards available for the request.
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
