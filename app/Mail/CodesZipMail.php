<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodesZipMail extends Mailable
{
    use Queueable, SerializesModels;

    public $zipPath;
    public $serie;

    public function __construct($zipPath, $serie)
    {
        $this->zipPath = $zipPath;
        $this->serie = $serie;
    }

    public function build()
    {
        return $this->subject("Codici generati per la serie {$this->serie}")
                    ->markdown('emails.codes.zip')
                    ->attach($this->zipPath, [
                        'as' => basename($this->zipPath),
                        'mime' => 'application/zip',
                    ]);
    }
}

