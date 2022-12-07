<?php

/**
 * Model per la pagina principale.
 */
class HomeModel
{

    /**
     * @var Database Connessione per il database.
     */
    private $connection;

    /**
     * @var string Percorso del file per la descrizione.
     */
    private $pathDescription = "application/libs/description.txt";

    /**
     * Metodo costruttore senza parametri, instanzia la variabile $connection.
     */
    public function __construct()
    {
        require_once "application/libs/database.php";
        $this->connection = new Database();
    }

    /**
     * Metodo per ricavare tutte le foto della home da mettere nel carosello.
     * @return array Tutti i percorsi delle foto.
     */
    public function getAllPathHomePicture()
    {
        $selectPicture = "SELECT path FROM photo";
        $pictures = $this->connection->query($selectPicture);
        return $pictures;
    }

    /**
     * Metodo per leggere la descrizione.
     * @return bool|false|string False se non è possibile legger il file altrimenti il contenuto del file
     */
    public function getText()
    {
        if (file_exists($this->pathDescription)) {
            return file_get_contents($this->pathDescription);
        } else {
            return false;
        }
    }

}