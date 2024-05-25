<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Task; // Make sure to import the Task model
use Illuminate\Database\Eloquent\Factories\HasFactory; 

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    // Other model properties and methods

    /**
     * Get the tasks for the user.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
