<?php

/**
 * Class Err Pagina per mostrare la pagina di errore.
 */
class Err
{

    /**
     * Metodo per la visualizzazione della pagina di errore.
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/error.php';
        require 'application/views/_template/footer.php';
    }


}