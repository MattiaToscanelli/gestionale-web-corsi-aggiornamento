<?php

/**
 * Class ESession Classe per la gestione delle sessioni
 */
class MSession
{

    /**
     * Metodo che mi permette di distruggere la sessione. (usato per il logout)
     */
    public static function stop()
    {
        session_destroy();
    }

    /**
     * Metodo che mi permette di distruggere la sessione per cambiare password.
     */
    public static function changePass()
    {
        unset($_SESSION[SESSION_CHANGE_PASSWORD]);
    }

    /**
     * Metodo per verificare se un utente è un admin.
     */
    public static function checkAdmin()
    {
        if (isset($_SESSION[SESSION_TYPE])) {
            if ($_SESSION[SESSION_TYPE] >= TYPE_ADMIN) {
                return;
            } else {
                echo ERROR;
                header("Location: " . URL . "err");
                exit;
            }
        } else {
            echo ERROR;
            header("Location: " . URL . "err");
            exit;
        }
    }

    /**
     * Metodo per verificare se un utente è un insegnante (Non utilizzato).
     */
    public static function checkTeacher()
    {
        if (isset($_SESSION[SESSION_TYPE])) {
            if ($_SESSION[SESSION_TYPE] >= TYPE_TEACHER) {
                return;
            } else {
                echo ERROR;
                header("Location: " . URL . "err");
                exit;
            }
        } else {
            echo ERROR;
            header("Location: " . URL . "err");
            exit;
        }
    }

    /**
     * Metodo per verificare se un utente è registrato al sito.
     */
    public static function checkUser()
    {
        if (isset($_SESSION[SESSION_TYPE])) {
            if ($_SESSION[SESSION_TYPE] >= TYPE_USER) {
                return;
            } else {
                echo ERROR;
                header("Location: " . URL . "err");
                exit;
            }
        } else {
            echo ERROR;
            header("Location: " . URL . "err");
            exit;
        }
    }
}