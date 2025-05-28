<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Email;
use Laravel\Nova\Http\Requests\NovaRequest;

class SendTestEmail extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * Perform the action on the given models.
     */
    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        foreach ($models as $model) {
            Mail::to($fields->email)->send(new \App\Mail\TestEmailOnEvent($model));
        }

        return ActionResponse::message('Test Email sent');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            'email' => Email::make('Email')->rules('required', 'email'),
        ];
    }
}
