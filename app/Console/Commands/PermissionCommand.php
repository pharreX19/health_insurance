<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Routing\Router;
use Illuminate\Console\Command;

class PermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permission synchronization';
    protected $router;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Creating resources and permissions.');

        $defaultPermissions = ['index', 'show', 'store', 'update', 'destroy'];
        $action = null;

        foreach($this->router->getRoutes() as $key => $route){
            $name = $route->getName();
            $this->action = last(explode('@', $route->getActionName()));
            $resourceName = substr($name, 0, strpos($name, '.'));
            if(empty($name)){
                $this->warn("The route [{$route->uri}] does not have a route name.]");
                continue;
            }
            
            $this->createPermission($resourceName, $name);
        }
        $this->info('Resource and permissions synchronizing finished.');
        return 0;
    }

    private function createPermission($name, $slug){
        $result =  Permission::create([
            'name' => $name, 
            'slug' => $slug,
            'description' => $this->getPermissionDescription($name, $this->action)
        ]);
        
        Role::where('name', 'admin')->first()->permissions()->attach($result->id);
        // $this->info($result);
    }

    private function getPermissionDescription($resourceName, $action){
        $resourceName = str_replace('-', ' ', $resourceName);
        switch($action){
            case 'index': 
                $permissionName = "List {$resourceName}";
                break;
            case 'show': 
                $permissionName = "View {$resourceName}";
                break;
            case 'store': 
                $permissionName = "Create {$resourceName}";
                break;
            case 'update': 
                $permissionName = "Update {$resourceName}";
                break;
            case 'destroy': 
                $permissionName = "Delete {$resourceName}";
                break;
            default: 
                if(($action)." ".$resourceName == 'App\Http\Controllers\SubscribersImportController subscribers'){
                    $permissionName = "Import subscribers list";
                }else if(strtolower($action." ".$resourceName) == 'grantorrevokepermission role'){
                    $permissionName = 'Grant or revoke permission role';
                }else if(strtolower($action." ".$resourceName) == 'assignrole user'){
                    $permissionName = 'Assign role to user';
                }else{
                    $permissionName = $action." ".$resourceName;
                }
                break;                          
        }
        return $permissionName;
    }
}
