<?php

namespace App\Domain\Tickets\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\TicketFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected static function newFactory(): TicketFactory
    {
        return TicketFactory::new();
    }

    protected $fillable = [
        'creator_id',
        'assignee_id',
        'title',
        'description',
        'status',
        'priority',
        'is_archived',
        'archived_at',
    ];

    protected $casts = [
        'is_archived' => 'boolean',
        'archived_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function history(): HasMany
    {
        return $this->hasMany(TicketHistory::class);
    }
}
