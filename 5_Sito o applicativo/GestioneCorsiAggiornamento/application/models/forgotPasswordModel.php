<?php

/**
 * Model per la richiesta di una nuova password.
 */
class ForgotPasswordModel
{

    /**
     * @var Connessione al database.
     */
    private $connection;

    /**
     * @var La email dell'utente che vuole recuperare la password.
     */
    private $email;

    /**
     * Metodo costruttore con 1 parametro. Instanzia le varibaili $connection, $util e $email.
     * @param $email La email di chi vuole richiedere il recupero password.
     */
    function __construct($email)
    {
        require_once "application/libs/database.php";
        $this->connection = new Database();
        $this->email = $email;
    }

    /**
     * Metodo per inviare una mail di recupero password.
     * @return bool True se la mail è stata inviata, False se la mail non è stata inviata.
     */
    function sendEmail()
    {
        $selectCheck = "select * from user where email=%s && type <> 0";
        $result = $this->connection->query($selectCheck, $this->email);
        if ($result != null) {
            try {
                $token = hash('sha256', random_bytes(16) . $this->email);
                $updateUsers = "UPDATE user SET token=%s WHERE email=%s";
                require 'application/libs/sendMail.php';
                $body = "Ciao " . $result[0][DB_USER_FIRSTNAME] . " " . $result[0][DB_USER_LASTNAME] . ",<br>
                         Recentemente è stata richiesta la procedura di modifica password!<br><br>
                         <a href='" . URL . "resetPassword/resPassword/" . $token . "/$this->email'> Per modificare la tua password clicca questo link!</a>";
                try {
                    $s = new SendMail();
                    $s->mailSend($this->email, "Modifica la password", $body);
                    $this->connection->query($updateUsers, $token, $this->email);
                    return true;
                } catch (Exception $e) {
                    return false;
                }
            } catch (Exception $e) {
                return false;
            }
        } else {
            return true;
        }
    }

}