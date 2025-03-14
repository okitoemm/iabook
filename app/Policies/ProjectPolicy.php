<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->role === 'client';
    }

    public function view(User $user, Project $project)
    {
        return $user->id === $project->client_id || $user->role === 'artisan';
    }

    public function update(User $user, Project $project)
    {
        return $user->id === $project->client_id;
    }
}
