<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Sereny\NovaPermissions\Fields\Checkboxes;

class Role extends \Sereny\NovaPermissions\Nova\Role
{
    /**
     * The policy the resource corresponds to.
     *
     * @var class-string<Policies\RolePolicy>
     */
    public static $policy = Policies\RolePolicy::class;

    public function fields(Request $request)
    {
        $guardOptions = $this->guardOptions($request);
        $userResource = $this->userResource();

        return [
            ID::make('ID', 'id')
                ->rules('required')
                ->canSee(function ($request) {
                    return $this->fieldAvailable('id');
                }),

            Text::make('Name', 'name')
                ->rules(['required', 'string', 'max:255'])
                ->creationRules('unique:'.config('permission.table_names.roles'))
                ->updateRules('unique:'.config('permission.table_names.roles').',name,{{resourceId}}'),

            Select::make('Guard Name', 'guard_name')
                ->options($guardOptions->toArray())
                ->rules(['required', Rule::in($guardOptions)])
                ->canSee(function ($request) {
                    return $this->fieldAvailable('guard_name');
                })
                ->default($this->defaultGuard($guardOptions)),

            Checkboxes::make('Permissions', 'permissions')
                ->options($this->loadPermissions()->map(function ($permission, $key) {
                    return [
                        'group' => $permission->group,
                        'option' => $permission->name,
                        'label' => __($permission->name),
                    ];
                })->groupBy('group')->toArray()),

            Text::make('Users', function () {
                /**
                 * We eager load count for the users relationship in the index query.
                 *
                 * @see self::indexQuery()
                 */
                return $this->users_count ?? $this->users()->count();
            })->exceptOnForms(),

            MorphToMany::make($userResource::label(), 'users', $userResource)
                ->searchable()
                ->canSee(function ($request) {
                    return $this->fieldAvailable('users');
                }),
        ];
    }
}
