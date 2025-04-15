<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


//Artisan::command('add-admin-role-to-user', function () {
//    $user = User::find(1);
//    $role = Role::findByName('admin');
//    $user->assignRole($role);
//})->purpose('Added admin role to user');
