<?php

/**
 * Model per la pagina di ricerca corsi.
 */
class ResearchCoursesModel
{

    /**
     * @var Database Connessione per il database.
     */
    private $connection;


    /**
     * Metodo costruttore senza parametri, instanzia la variabile $connection.
     */
    public function __construct()
    {
        require_once "application/libs/database.php";
        $this->connection = new Database();
    }

    /**
     * Metodo per ricavare tutte le informazioni di un corso.
     * @return array Le informazioni di un corso.
     */
    public function getAllCourses()
    {
        $selectCourses = "SELECT * FROM course";
        $courses = $this->connection->query($selectCourses);
        return $courses;
    }

}