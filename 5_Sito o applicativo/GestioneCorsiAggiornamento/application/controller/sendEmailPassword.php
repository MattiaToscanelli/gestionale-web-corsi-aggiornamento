<?php

/**
 * Class SendEmailPassword Controller per mostrare il messaggio che è stata inviata una email di recupero password.
 */
class SendEmailPassword
{

    /**
     * Metodo per la visualizzazione della pagina per mostrare il messaggio che è stata inviata una email di recupero password.
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/login/sendEmailPassword.php';
        require 'application/views/_template/footer.php';
    }


}