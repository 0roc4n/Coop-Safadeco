<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class LogoutUserSession extends Command
{
    protected $signature = 'session:logout-user {user_id}';
    protected $description = 'Delete all active sessions for a specific user';

    public function handle()
    {
        $userId = $this->argument('user_id');

        $count = DB::table('sessions')->where('user_id', $userId)->delete();

        $this->info("Deleted {$count} session(s) for user ID {$userId}");
    }
}
