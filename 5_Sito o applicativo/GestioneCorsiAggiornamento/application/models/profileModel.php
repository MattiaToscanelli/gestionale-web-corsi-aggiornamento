<?php

/**
 * Class ProfileModel Model per gestire la pagina personale.
 */
class ProfileModel
{

    /**
     * @var Database Connessione per il database.
     */
    private $connection;

    /**
     * @var Validator Validatore per vari input.
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
     * Metodo per ricavare i giorni per calcolare la data di scedenza.
     */
    public function getDeadline()
    {
        $selectDeadline = "SELECT day_deadline FROM settings";
        $deadline = $this->connection->query($selectDeadline);
        return $deadline[0][DEADLINE];
    }

    /**
     * Metodo per ricavare i corsi da fare.
     * @param $email L'email dell'utente.
     * @return mixed I corsi da fare.
     */
    public function getEnrollmentToDo($email)
    {
        $selectEnrollment = "SELECT en.id, c.title, ex.start, ex.end, DATE_SUB(ex.start, INTERVAL " . $this->getDeadline() . " DAY) as 'day_deadline', en.flag_meal, en.flag_paid, en.food_type, en.intolerances, c.meal_price
                            FROM user u, enrolls en, execution ex, course c
                            WHERE u.id = en.id_user
                            AND ex.id = en.id_execution
                            AND ex.id_course = c.id
                            AND u.email = %s
                            AND ex.end >= CURDATE();";
        $enrollment = $this->connection->query($selectEnrollment, $email);
        return $enrollment;
    }

    /**
     * Metodo per ricavare i corsi fatti.
     * @param $email L'email dell'utente.
     * @return mixed I corsi da fare.
     */
    public function getEnrollmentDone($email)
    {
        $selectEnrollment = "SELECT c.title, ex.start, ex.end, en.flag_meal, en.food_type, en.intolerances, c.meal_price
                            FROM user u, enrolls en, execution ex, course c
                            WHERE u.id = en.id_user
                            AND ex.id = en.id_execution
                            AND ex.id_course = c.id
                            AND en.flag_paid = 1
                            AND u.email = %s
                            AND ex.end < CURDATE();";
        $enrollment = $this->connection->query($selectEnrollment, $email);
        return $enrollment;
    }
}