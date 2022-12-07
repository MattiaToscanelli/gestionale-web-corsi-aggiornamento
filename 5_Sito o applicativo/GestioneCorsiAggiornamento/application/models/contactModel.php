<?php

/**
 * Model per la pagina di contatti.
 */
class ContactModel
{

    /**
     * @var Database Connessione per il database.
     */
    private $connection;

    /**
     * @var string Percorso del file per dei contatti.
     */
    private $pathContact = "application/libs/contact.txt";

    /**
     * Metodo costruttore senza parametri, instanzia la variabile $connection.
     */
    public function __construct()
    {
        require_once "application/libs/database.php";
        $this->connection = new Database();
    }

    /**
     * Metodo per leggere i contatti.
     * @return bool|false|string False se non è possibile leggere il file altrimenti il contenuto del file.
     */
    public function getText()
    {
        if (file_exists($this->pathContact)) {
            return file_get_contents($this->pathContact);
        } else {
            return false;
        }
    }

}