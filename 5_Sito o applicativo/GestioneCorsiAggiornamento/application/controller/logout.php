<?php

/**
 * Class Logout Controller per mostrare il messaggio che l'utente è stato disconesso.
 */
class  Logout
{

    /**
     * Metodo per la visualizzazione della pagina che mostra il messaggio di disconessione.
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/login/logout.php';
        require 'application/views/_template/footer.php';
    }


}