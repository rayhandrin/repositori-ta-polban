<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteForgotPasswordRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:forgot-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete forgot password records that are more than 2 minutes.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('password_resets')->where('created_at', '>=', Carbon::now()->addMinutes(2))->delete();
    }
}
