<?php

/**
 * Class PasswordChanged Controller per mostrare il messaggio che la password è stata cambiata.
 */
class  PasswordChanged
{

    /**
     * Metodo per la visualizzazione della pagina che mostra il messaggio che la password è stata cambiata.
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/login/passwordChanged.php';
        require 'application/views/_template/footer.php';
    }


}