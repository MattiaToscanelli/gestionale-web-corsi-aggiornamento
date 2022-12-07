<?php

/**
 * Model per gestire il login.
 */
class LoginModel
{

    /**
     * @var Database Connessione per il database.
     */
    private $connection;

    /**
     * Metodo costruttore senza parametri, instanzia la variabile $connection.
     */
    function __construct()
    {
        require_once "application/libs/database.php";
        $this->connection = new Database();
    }

    /**
     * Metodo per effettuare il login.
     */
    public function access($email, $password)
    {
        $result = $this->getUser($email);
        if (count($result) > 0) {
            if (password_verify($password, $result[0][DB_USER_PASSWORD])) {
                echo SUCCESSFUL;
                return $result;
            } else {
                echo LOGIN_DENY;
            }
        } else {
            echo LOGIN_DENY;
        }
    }

    /**
     * Metodo utilizzato per ricavare tutte le info di un utente, dunque per effettuare il login.
     * @param $email La email dell'utente che vuole accedere.
     * @return array I dati dell'utente.
     */
    private function getUser($email)
    {
        $selectAccess = "SELECT * FROM user WHERE email=%s && type <> 0";
        return $this->connection->query($selectAccess, $email);
    }

}