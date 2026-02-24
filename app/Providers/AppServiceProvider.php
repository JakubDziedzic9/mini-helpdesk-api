<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Auth\Repositories\UserRepository;
use App\Domain\Auth\Repositories\Eloquent\EloquentUserRepository;
use App\Domain\Tickets\Repositories\TicketRepository;
use App\Domain\Tickets\Repositories\Eloquent\EloquentTicketRepository;

use App\Domain\Tickets\Repositories\CommentRepository;
use App\Domain\Tickets\Repositories\Eloquent\EloquentCommentRepository;

use App\Domain\Tickets\Repositories\TicketHistoryRepository;
use App\Domain\Tickets\Repositories\Eloquent\EloquentTicketHistoryRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);

        $this->app->bind(TicketRepository::class, EloquentTicketRepository::class);
        $this->app->bind(CommentRepository::class, EloquentCommentRepository::class);
        $this->app->bind(TicketHistoryRepository::class, EloquentTicketHistoryRepository::class);
    }

    public function boot(): void
    {
    }
}