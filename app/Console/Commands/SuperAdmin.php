<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'superadmin:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is a Super Admin Command';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $super_admin = User::where('email', 'superadmin@rumahsidqia.com')->get();

        if (count($super_admin) == 0) {
            User::create([
                'name' => 'Admin',
                'email' => 'superadmin@rumahsidqia.com',
                'password' => bcrypt('fvrPjH4G7P'),
                'level' => 'admin'
            ]);
            return Command::SUCCESS;
        } else {
            return Command::INVALID;
        }
    }
}
