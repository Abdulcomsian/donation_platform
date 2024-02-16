<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MailingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $mailType;
    public $email;
    public $userId;

    /**
     * Create a new job instance.
     */
    public function __construct($mailType , $email , $userId)
    {
        $this->mailType = $mailType;
        $this->email = $email;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Helper::sendMail($this->mailType , $this->email , $this->userId);
    }
}
