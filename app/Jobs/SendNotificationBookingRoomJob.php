<?php

namespace App\Jobs;

use App\Mail\RoomBookingNotificationEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNotificationBookingRoomJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $subject;
    public $body;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $subject, $body)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new RoomBookingNotificationEmail($this->subject, $this->body));
    }
}
