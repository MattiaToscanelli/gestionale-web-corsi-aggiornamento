<?php

/**
 * Class ForgotPassword Classe per l'invio del link di recupero password.
 */
class ForgotPassword
{

    /**
     * Metodo per la visualizzazione della pagina per l'invio del link di recupero password.
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/login/forgotPassword.php';
        require 'application/views/_template/footer.php';
    }

    /**
     * Metodo per invire la mail di recupero password.
     */
    public function sendEmail()
    {
        if ($_SERVER["REQUEST_METHOD"] = "POST") {
            if (!isset($_POST[EMAIL])) {
                Util::fail();
            }
            require 'application/models/forgotPasswordModel.php';
            $fpm = new ForgotPasswordModel(Util::test_input($_POST[EMAIL]));
            if ($fpm->sendEmail()) {
                header("Location: " . URL . "sendEmailPassword");
            } else {
                header("Location: " . URL . "err");
            }
        } else {
            header("Location: " . URL . "err");
        }
    }
}