<?php

/**
 * Class EnrollAdded Controller per mostrare il messaggio che l'iscrizione è stata aggiunta.
 */
class EnrollAdded
{

    /**
     * Metodo per la visualizzazione della pagina che mostra il messaggio che l'iscrizione è stata aggiunta.
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/courses/enrollAdded.php';
        require 'application/views/_template/footer.php';
    }


}