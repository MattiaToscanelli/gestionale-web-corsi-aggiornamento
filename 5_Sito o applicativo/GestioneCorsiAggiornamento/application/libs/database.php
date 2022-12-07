<?php

/**
 * Class Database Classe che mi permette di eseguire tutte le query sul database. Estende la classe MeekroDB. MeekroDB è
 * un libreria che utilizzo per fare i prepare statement in modo più rapido.
 */
class Database extends MeekroDB
{

    /**
     * Database constructor. Viene istanziato un nuovo oggetto prendendo i parametri dal file di config.
     */
    public function __construct()
    {
        parent::__construct(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }
}

?>