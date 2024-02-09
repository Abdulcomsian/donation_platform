<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class EventMail extends Mailable
{
    use Queueable, SerializesModels;
    public $eventType;
    public $user;
    /**
     * Create a new message instance.
     */
    public function __construct($eventType)
    {
        $this->eventType = $eventType;
        $this->user = User::with(
                                'donationSuccessMail' , 'subscriptionSuccessMail' , 'subscriptionFailedMail' , 'donationRefundMail',
                                'subscriptionCanceledMail' , 'membershipSubscriptionMail' , 'membershipRenewelMail' , 'membershipCanceledMail',
                                'membershipRenewelFailedMail' , 'membershipRefundMail' , 'eventRegistrationMail' , 'eventCanceledMail' , 'eventTicketRefundMail'   
                            )
                            ->where('id' , auth()->user()->id)
                            ->first(); 
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Event Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.general-event',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
