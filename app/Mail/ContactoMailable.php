<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactoMailable extends Mailable
{
    use Queueable, SerializesModels;
    // public $subject = "Asunto Urgente"; //VARIABLE PARA EL ASUNTO
    public $contacto;                   //mensaje
    public $subject;
    public $from;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contacto)
    {
        //RECIVIENDO PARAMETROS
        $this->from($contacto['correo']);
        $this->contacto = $contacto;
        $this->subject = $contacto['asunto'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->view('emails.contactanos'); //MANDANDO INFORMACION A LA VISTA
    }
}
