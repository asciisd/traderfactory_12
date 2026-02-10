<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

abstract class Policy
{
    use HandlesAuthorization;

    const string ViewAny = 'viewAny';

    const string Create = 'create';

    const string View = 'view';

    const string Show = 'show';

    const string Update = 'update';

    const string Delete = 'delete';

    const string Restore = 'restore';

    const string ForceDelete = 'forceDelete';

    const string Withdrawal = 'withdrawal';

    const string Deposit = 'deposit';

    protected string $key;

    public function __construct()
    {
        $this->key = class_basename(Str::remove('Policy', $this::class));
    }

    public function before(Authenticatable|User|Admin $auth): ?bool
    {
        return Nova::whenServing(function (NovaRequest $request) use ($auth) {
            try {
                if ($auth?->isSuper()) {
                    return true;
                }
            } catch (\Throwable $e) {
                return null;
            }

            return null;
        });
    }

    public function viewAny(Authenticatable|Admin|User $auth): bool
    {
        return Nova::whenServing(function (NovaRequest $request) use ($auth) {
            if ($auth instanceof Admin) {
                return $auth->hasPermissionTo(Policy::ViewAny.$this->key, 'admin');
            }

            return false;
        }, function (Request $request) use ($auth) {
            return $auth->hasVerifiedEmail();
        });
    }

    public function create(Authenticatable|Admin|User $auth): bool
    {
        return Nova::whenServing(function (NovaRequest $request) use ($auth) {
            if ($auth instanceof Admin) {
                return $auth->hasPermissionTo(Policy::Create.$this->key, 'admin');
            }

            return false;
        }, function (Request $request) {
            return false;
        });
    }
}
