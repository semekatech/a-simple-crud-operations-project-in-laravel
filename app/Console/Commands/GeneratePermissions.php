<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use App\Models\Permission;

class GeneratePermissions extends Command
{
    protected $signature = 'generate:permissions';
    protected $description = 'Generate permissions for all routes';

    public function handle()
    {
        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            $this->createPermission($route->uri());
        }

        $this->info('Permissions generated successfully.');
    }

    private function createPermission($uri)
    {
        // Modify this as needed to suit your permission naming convention
        $name = str_replace('/', '.', $uri);

        Permission::firstOrCreate(['name' => $name]);

        $this->info("Permission created: $name");
    }
}
