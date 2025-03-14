<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'title',
        'description',
        'category',
        'budget',
        'budget_type',
        'city',
        'postal_code',
        'address',
        'urgent',
        'verification_method',
        'availability_days',
        'availability_hours',
        'status'
    ];

    protected $casts = [
        'urgent' => 'boolean',
        'budget' => 'decimal:2',
        'availability_days' => 'array',
        'availability_hours' => 'array'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function artisan()
    {
        return $this->belongsTo(User::class, 'artisan_id');
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
