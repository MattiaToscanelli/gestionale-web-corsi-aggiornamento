<?php

/**
 * Class ResearchCourses Controller della pagina di ricerca corsi.
 */
class ResearchCourses
{

    /**
     * Metodo per la visualizzazione della pagina di ricerca corsi.
     */
    public function index()
    {
        require_once 'application/models/researchCoursesModel.php';
        $rcm = new ResearchCoursesModel();
        $courses = $rcm->getAllCourses();

        require 'application/views/_template/header.php';
        require 'application/views/courses/researchCourses.php';
        require 'application/views/_template/footer.php';
    }

}