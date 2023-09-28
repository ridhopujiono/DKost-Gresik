<?php

namespace App\Jobs;

use App\Mail\PaymentAcceptedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PaymentAcceptedMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $room_name;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $room_name)
    {
        $this->email = $email;
        $this->room_name = $room_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new PaymentAcceptedMail($this->room_name));
    }
}
