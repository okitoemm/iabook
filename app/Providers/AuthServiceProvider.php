<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Project;
use App\Policies\ProjectPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Models\Project' => 'App\Policies\ProjectPolicy',
    ];

    // ...existing code...
}
