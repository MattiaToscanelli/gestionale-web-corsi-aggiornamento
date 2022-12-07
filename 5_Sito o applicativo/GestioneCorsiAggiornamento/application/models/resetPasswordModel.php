<?php

/**
 * Model per modificare la password.
 */
class ResetPasswordModel
{

    /**
     * @var Database Connessione per il database.
     */
    private $connection;

    /**
     * @var Validator Velidatore per vari input.
     */
    private $validator;

    /**
     * Metodo costruttore senza parametri, instanzia le varibili $connection e $validator.
     */
    function __construct()
    {
        require_once "application/libs/database.php";
        require_once "application/libs/validator.php";
        $this->connection = new Database();
        $this->validator = new Validator($this->connection);
    }


    /**
     * Metodo per confermare la email quando si vuole cambiare la password.
     * @param $hash La hash per identificare la persona che ha verificato la email.
     * @param $email La email della persona che vuole cambiare password.
     * @return bool True se l'identificazione dell'utente è andato a buone fine, False se non è andato a buon fine.
     */
    function resPassword($hash, $email)
    {
        if ($hash != null) {
            $selectUsers = "SELECT * FROM user WHERE email=%s AND token=%s";
            $result = $this->connection->query($selectUsers, $email, $hash);
            if ($result != null) {
                $updateUsers = "UPDATE user SET token=NULL WHERE email=%s";
                $this->connection->query($updateUsers, $email);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Metodo per modificare la password.
     * @param $email La email di chi vuole modificare la password.
     * @param $password1 La nuova password che si vuole impostare.
     * @param $password2 Nuovamente la password che si vuole impostare.
     * @return bool True se il cambiamento della password è andato a buone fine, False se non è andato a buon fine.
     */
    public function modifyPassword($email, $password1, $password2)
    {
        if ($this->validator->checkPassword($password1, $password2)) {
            $password = password_hash($password1, PASSWORD_DEFAULT);
            $updateUsers = "UPDATE user SET password=%s WHERE email=%s";
            $this->connection->query($updateUsers, $password, $email);
            echo SUCCESSFUL;
            return true;
        }
        echo ERROR;
        return false;
    }
}