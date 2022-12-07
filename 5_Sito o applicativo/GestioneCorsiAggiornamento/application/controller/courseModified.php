<?php

/**
 * Class CourseModified Controller per mostrare il messaggio che il corso è stato modificato.
 */
class  CourseModified
{

    /**
     * Metodo per la visualizzazione della pagina che mostra il messaggio che il corso è stato modificato.
     */
    public function index()
    {
        MSession::checkAdmin();
        require 'application/views/_template/header.php';
        require 'application/views/courses/courseModified.php';
        require 'application/views/_template/footer.php';
    }

}