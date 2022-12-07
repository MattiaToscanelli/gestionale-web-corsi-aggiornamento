<?php

/**
 * Class Login Controller della pagina di login.
 */
class Login
{

    /**
     * Metodo per la visualizzazione della pagina di login.
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/login/login.php';
        require 'application/views/_template/footer.php';
    }

    /**
     * Metodo per effettuare il login.
     */
    public function access()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[EMAIL], $_POST[PASSWORD])) {
                Util::fail();
            }
            $email = Util::test_input($_POST[EMAIL]);
            $password = $_POST[PASSWORD];
            require_once 'application/models/loginModel.php';
            $loginModel = new LoginModel();
            $result = $loginModel->access($email, $password);
            if ($result != null) {
                $_SESSION[SESSION_TYPE] = $result[0][DB_USER_TYPE];
                $_SESSION[SESSION_EMAIL] = $email;
            }
        } else {
            header("Location:" . URL . "err");
        }
    }
}
