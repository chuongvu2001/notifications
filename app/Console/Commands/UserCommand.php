<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SendEmailNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class UserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::create([
            'name' => Str::random(8),
            'email' => 'chdddnnnnnun@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now()
        ]);

        $this->info('done');
    }
}
