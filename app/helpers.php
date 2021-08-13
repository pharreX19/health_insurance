<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


function hasPermission($routeName)
{
    $key = 'permissions'. auth()->user()->id;
    $permissions = Cache::remember('$key', 60, function () {
        $collection = collect();

        $user = auth()->user()->load('role.permissions');
        foreach($user->role->permissions as $permission){
            $collection->push($permission->slug);
        }
        return $collection;
    });
    return $permissions->contains($routeName);
}