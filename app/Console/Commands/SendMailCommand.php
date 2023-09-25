<?php

namespace App\Console\Commands;

use App\Mail\SendExampleMail;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:example_mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Example Email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $send = Mail::to('fahmaalfa7@gmail.com')->send(new SendExampleMail());
            if ($send) {
                return Command::SUCCESS;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
