<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class GeneratePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate permissions for all models and save it on database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $path = app_path('Nova').'/*.php';
        $collection = collect(glob($path))->map(fn ($file) => basename($file, '.php'));

        $collection->pull('Resource');
        $collection->push('Role', 'Permission');

        $collection->each(function ($item) {
            try {
                Permission::findByName('viewAny'.$item, 'admin');
            } catch (PermissionDoesNotExist $exception) {
                Permission::create(['guard_name' => 'admin', 'group' => $item, 'name' => 'viewAny'.$item]);
                Permission::create(['guard_name' => 'admin', 'group' => $item, 'name' => 'view'.$item]);
                Permission::create(['guard_name' => 'admin', 'group' => $item, 'name' => 'create'.$item]);
                Permission::create(['guard_name' => 'admin', 'group' => $item, 'name' => 'update'.$item]);
                Permission::create(['guard_name' => 'admin', 'group' => $item, 'name' => 'delete'.$item]);
                Permission::create(['guard_name' => 'admin', 'group' => $item, 'name' => 'restore'.$item]);
                Permission::create(['guard_name' => 'admin', 'group' => $item, 'name' => 'forceDelete'.$item]);
            }
        });
    }
}
