<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $agent;
    public $date;
    public $bookings;
    public $baseMessage;

    public function __construct($subject, $agent, $date, $bookings, $baseMessage)
    {
        $this->subject = $subject;
        $this->agent = $agent;
        $this->date = $date;
        $this->bookings = $bookings;
        $this->baseMessage = $baseMessage;
    }

    public function build()
    {
        return $this->subject($this->subject)
            ->view('emails.daily_report');
    }

}

