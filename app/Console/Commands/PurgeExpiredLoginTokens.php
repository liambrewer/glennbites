<?php

namespace App\Console\Commands;

use App\Models\LoginToken;
use Illuminate\Console\Command;

class PurgeExpiredLoginTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:purge-tokens {--days=7 : Number of days to keep used or expired tokens}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove old login tokens from the database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = $this->option('days');
        $threshold = now()->subDays($days);

        $count = LoginToken::where('created_at', '<', $threshold)
            ->where(function ($query) {
                $query->whereNotNull('used_at')
                    ->orWhere('expires_at', '<', now());
            })
            ->delete();

        $this->info("Deleted {$count} login tokens older than {$days} days.");

        return Command::SUCCESS;
    }
}
