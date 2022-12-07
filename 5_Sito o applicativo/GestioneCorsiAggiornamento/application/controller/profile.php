<?php

/**
 * Class Profile Controller per mostrare la pagina personale.
 */
class Profile
{

    /**
     * Metodo per la visualizzazione della pagina personale.
     */
    public function index()
    {
        MSession::checkUser();
        if (!isset($_SESSION[SESSION_EMAIL])) {
            Util::fail();
        }
        require_once 'application/models/profileModel.php';
        $p = new ProfileModel();
        $toDoExe = $p->getEnrollmentToDo($_SESSION[SESSION_EMAIL]);
        $doneExe = $p->getEnrollmentDone($_SESSION[SESSION_EMAIL]);

        require 'application/views/_template/header.php';
        require 'application/views/login/profile.php';
        require 'application/views/_template/footer.php';
    }

    /**
     * Metodo per eseguire il logout.
     */
    function logout()
    {
        MSession::checkUser();
        MSession::stop();
        header("Location: " . URL . "logout");
    }
}