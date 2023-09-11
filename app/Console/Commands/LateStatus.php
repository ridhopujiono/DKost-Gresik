<?php

namespace App\Console\Commands;

use App\Models\Resident;
use Illuminate\Console\Command;

class LateStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'late_status:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status telat pembayaran';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $residents = Resident::all();

        foreach ($residents as $resident) {
            $resident->updateLateStatus();
        }

        $this->info('Status telat pembayaran telah diperbarui.');
    }
}
