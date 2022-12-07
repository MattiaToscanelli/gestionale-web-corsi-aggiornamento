<?php

/**
 * Class ResetPassword Controller per cambiare la password.
 */
class ResetPassword
{

    /**
     * Metodo per la visualizzazion della pagina per cambiare la password.
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/login/resetPassword.php';
        require 'application/views/_template/footer.php';
    }

    /**
     * Metodo per confermare che l'utente che sta cambiano la password sia quello che lo ha richiesto.
     * @param $hash La hash per identificare la persona che ha verificato la email.
     * @param $email La email della persona che sta cambiando la password.
     */
    public function resPassword($hash = null, $email = null)
    {
        if (($email != null) && ($hash != null)) {
            require_once 'application/models/resetPasswordModel.php';
            $rpm = new ResetPasswordModel();
            if ($rpm->resPassword(Util::test_input($hash), Util::test_input($email))) {
                $_SESSION[SESSION_CHANGE_PASSWORD] = Util::test_input($email);
                header("Location: " . URL . "resetPassword");
            } else {
                header("Location: " . URL . "err");
            }
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per modificare la password
     */
    public function modifyPassword()
    {
        require_once 'application/models/resetPasswordModel.php';
        $rpm = new ResetPasswordModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[PASSWORD], $_POST[RE_PASSWORD])) {
                Util::fail();
            }
            if ($rpm->modifyPassword($_SESSION[SESSION_CHANGE_PASSWORD], Util::test_input($_POST[PASSWORD]), Util::test_input($_POST[RE_PASSWORD]))) {
                require_once 'application/libs/mSession.php';
                MSession::changePass();
            }
        } else {
            header("Location: " . URL . "err");
        }
    }
}