<?php

/**
 * Class AddCourseModel Model utilizzato per l'aggiunta di corso.
 */
class AddCourseModel
{

    /**
     * @var Database Connessione per il database.
     */
    private $connection;

    /**
     * @var Validator Validatore degli input.
     */
    private $validator;

    /**
     * Metodo costruttore senza parametri, instanzia le varibili $validator e $connection.
     */
    public function __construct()
    {
        require_once "application/libs/database.php";
        require_once "application/libs/validator.php";
        $this->connection = new Database();
        $this->validator = new Validator($this->connection);
    }


    /**
     * Metodo per ricavare tutte le tipologie di corsi.
     * @return array Tutte le tipologie.
     */
    public function getAllTypology()
    {
        $selectTypologies = "SELECT * FROM typology";
        $typology = $this->connection->query($selectTypologies);
        return $typology;
    }

    /**
     * Metodo per aggiungere un corso.
     * @param $title Il titolo del corso.
     * @param $street La via del corso.
     * @param $zip Il cap del corso.
     * @param $city La citta del corso.
     * @param $maxPartecipants Il numero massimo di partecipanti del corso.
     * @param $typology La tipologia del corso.
     * @param $coursePrice Il costo del corso.
     * @param $mealPrice Il costo del pasto presente nel corso.
     * @param $courseDescription La descrizione del corso.
     * @param $materials I materiali necessari per eseguire il corso.
     */
    public function addCourse($title, $street, $zip, $city, $maxPartecipants, $typology, $coursePrice, $mealPrice, $courseDescription, $materials)
    {
        $data = array();

        //variabili per salvare i controlli dei vari input
        $checkTitle = $checkStreet = $checkZip = $checkCity = $checkMaxPartecipants = $checkTypology = $checkCoursePrice = $checkMealPrice = $checkCourseDescription = $checkMaterials = $checkAll = SUCCESSFUL;

        //eseguo tutti i controlli
        if (!$this->validator->checkTitle($title)) {
            $checkTitle = ERROR;
            $checkAll = ERROR;
        }
        if (!$this->validator->checkStreet($street)) {
            $checkStreet = ERROR;
            $checkAll = ERROR;
        }
        if (!$this->validator->checkZip($zip)) {
            $checkZip = ERROR;
            $checkAll = ERROR;
        }
        if (!$this->validator->checkName($city)) {
            $checkCity = ERROR;
            $checkAll = ERROR;
        }
        if (!$this->validator->checkPartecipants($maxPartecipants)) {
            $checkMaxPartecipants = ERROR;
            $checkAll = ERROR;
        }
        if (!$this->validator->checkTypology($typology)) {
            $checkTypology = ERROR;
            $checkAll = ERROR;
        }
        if (!$this->validator->checkCoursePrice($coursePrice)) {
            $checkCoursePrice = ERROR;
            $checkAll = ERROR;
        }
        if (!$this->validator->checkMealPrice($mealPrice)) {
            $checkMealPrice = ERROR;
            $checkAll = ERROR;
        }
        if (!$this->validator->checkTextArea($courseDescription)) {
            $checkCourseDescription = ERROR;
            $checkAll = ERROR;
        }
        if ((!$this->validator->checkTextArea($materials)) && $materials != "") {
            $checkMaterials = ERROR;
            $checkAll = ERROR;
        }
        if ($materials != "") {
            $materials == null;
        }
        if ($checkAll == SUCCESSFUL) {
            $addCourse = "INSERT INTO course (title,description,zip,city,street,max_partecipants,materials,meal_price,course_price,name_typology) VALUES (%s,%s,%i,%s,%s,%i,%s,%d,%d,%s)";
            $this->connection->query($addCourse, $title, $courseDescription, $zip, $city, $street, $maxPartecipants, $materials, $mealPrice, $coursePrice, $typology);
        }

        // preparo il json con tutti i controlli da ritornare al client
        $data[] = array(
            SATUTS => $checkAll,
            CHECK_TITLE => $checkTitle,
            CHECK_COURSE_DESCRIPTION => $checkCourseDescription,
            CHECK_ZIP => $checkZip,
            CHECK_CITY => $checkCity,
            CHECK_STREET => $checkStreet,
            CHECK_MAX_PARTECIPANTS => $checkMaxPartecipants,
            CHECK_MATERIALS => $checkMaterials,
            CHECK_MEAL_PRICE => $checkMealPrice,
            CHECK_COURSE_PRICE => $checkCoursePrice,
            CHECK_TYPOLOGY => $checkTypology
        );
        echo json_encode($data);
    }

}