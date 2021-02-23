<?php

namespace App\Console\Commands\Route;

use File;

use Illuminate\Routing\Router;
use Illuminate\Console\Command;

class Json extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate routes for Front-End';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $routes = [];

        foreach ($this->router->getRoutes() as $route) {
            $name = $route->getName();

            if (strlen($name) > 0) {
                $routes[$route->getName()] = $route->uri();
            }
        }

        $path = resource_path('js/helpers/_routes.json');
        
        File::put($path, json_encode($routes, JSON_PRETTY_PRINT));

        $this->info(sprintf('File %s successfully generated', $path));
    }
}
