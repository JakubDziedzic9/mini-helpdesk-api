<?php

namespace App\Domain\Tickets\Models;

use App\Models\User;
use Database\Factories\TicketHistoryFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketHistory extends Model
{
    use HasFactory;
    
    protected static function newFactory(): TicketHistoryFactory
    {
        return TicketHistoryFactory::new();
    }

    protected $fillable = [
        'ticket_id',
        'actor_id',
        'action',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
