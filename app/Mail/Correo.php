<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Correo extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Crea una nueva instancia del Mailable.
     *
     * @param array $details Datos a enviar al correo
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Construye el correo.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Asunto del Correo')
                    ->view('emails.mi_correo'); // Vista para el correo
    }
}
