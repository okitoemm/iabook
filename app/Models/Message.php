<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sender_id',
        'recipient_id',
        'project_id',
        'content',
        'is_read'  // Changé de 'read' à 'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',  // Changé de 'read' à 'is_read'
        'estimated_price' => 'decimal:2',
        'estimated_days' => 'integer'
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
