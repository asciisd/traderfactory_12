<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Asciisd\ZohoV8\Models\ZohoContact;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'phone' => 'required||phone|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'country' => 'required|string|max:2',
            'terms' => 'required|accepted',
        ]);

        $utm_data = null;
        if (request()->hasCookie('utm')) {
            $utm_data = json_decode(request()->cookie('utm'));
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'password' => Hash::make($request->password),
            'utm_source' => $utm_data->utm_source ?? null,
            'utm_content' => $utm_data->utm_content ?? null,
            'utm_medium' => $utm_data->utm_medium ?? null,
            'utm_campaign' => $utm_data->utm_campaign ?? null,
            'utm_term' => $utm_data->utm_term ?? null,
        ]);

        // Create Zoho Contact
        try {
            $this->createZohoContact([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'lead_source' => 'trader_factory',
            ]);
        } catch (\Throwable $e) {
            Log::channel('zoho_sync')->error('ZohoContact creation failed', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage(),
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return to_route('dashboard');
    }

    public function createZohoContact(array $data)
    {
        return ZohoContact::create([
            'First_Name' => $data['first_name'],
            'Last_Name' => $data['last_name'],
            'Email' => $data['email'],
            'Phone' => $data['phone'],
            'Lead_Source' => $data['lead_source'],
        ]);
    }


}
