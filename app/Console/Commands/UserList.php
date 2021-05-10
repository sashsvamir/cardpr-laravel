<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;


class UserList extends Command
{
    protected $signature = 'user:list';

    protected $description = 'List users';

    public function handle()
    {
        $users = User::all(['id', 'email', 'phone']);

        $this->table(['id', 'email', 'phone'], $users);
        $this->info("Total users count: {$users->count()}");
    }

}
