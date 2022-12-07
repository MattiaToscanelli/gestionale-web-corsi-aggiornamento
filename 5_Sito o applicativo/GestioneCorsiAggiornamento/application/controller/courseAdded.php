<?php

/**
 * Class CourseAdded Controller per mostrare il messaggio che il corso è stato aggiunto.
 */
class  CourseAdded
{

    /**
     * Metodo per la visualizzazione della pagina che mostra il messaggio che il corso è stato aggiunto.
     */
    public function index()
    {
        MSession::checkAdmin();
        require 'application/views/_template/header.php';
        require 'application/views/courses/courseAdded.php';
        require 'application/views/_template/footer.php';
    }


}