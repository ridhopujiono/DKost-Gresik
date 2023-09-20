<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AdminGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is a command to generate admin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $admin = User::where('email', 'andhika@rumahsidqia.com')->get();

        if (count($admin) == 0) {
            User::create([
                'name' => 'Andhika',
                'email' => 'andhika@rumahsidqia.com',
                'password' => bcrypt('L8Hrpqw3xR'),
                'level' => 'admin'
            ]);
            return Command::SUCCESS;
        } else {
            return Command::INVALID;
        }
    }
}
