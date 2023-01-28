<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\NotifyInactiveUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EmailInactivceUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is for send notification all user';

    /**
     * Execute the console command.
     *
     * @return void
     */
    /** @var TYPE_NAME $ */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user){
            $user->notify(new NotifyInactiveUser());
            info("email send to ". $user->name);
        }
    }
}
