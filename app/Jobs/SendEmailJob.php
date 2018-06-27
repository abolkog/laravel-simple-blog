<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

use App\Mail\ContactUs;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    protected $email;
    protected $subject;
    protected $body;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $email, $subject, $body)
    {
        $this->name = $name;
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
        $contactUs = new ContactUs($this->name, $this->email, $this->subject, $this->body);
        Mail::to('abolkog@gmail.com')->send($contactUs);
    }
}
