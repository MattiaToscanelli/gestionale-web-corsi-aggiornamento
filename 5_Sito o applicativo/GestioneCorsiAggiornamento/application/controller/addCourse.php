<?php

/**
 * Class AddCourse Controller per aggiungere un corso.
 */
class AddCourse
{

    /**
     * Metodo per visualizzare la pagina di aggiunta corsi.
     */
    public function index()
    {
        MSession::checkAdmin();
        require 'application/models/addCourseModel.php';

        $acm = new AddCourseModel();
        $typologies = $acm->getAllTypology();

        require 'application/views/_template/header.php';
        require 'application/views/courses/addCourse.php';
        require 'application/views/_template/footer.php';
    }

    /**
     * Metodo per aggiungere un corso.
     */
    function addCor()
    {
        MSession::checkAdmin();
        require_once 'application/models/addCourseModel.php';
        $acm = new AddCourseModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[TITLE], $_POST[STREET], $_POST[ZIP], $_POST[CITY], $_POST[MAX_PARTECIPANTS], $_POST[TYPOLOGY], $_POST[COURSE_PRICE], $_POST[MEAL_PRICE], $_POST[COURSE_DESCRIPTION], $_POST[MATERIALS])) {
                Util::fail();
            }
            $title = Util::test_input($_POST[TITLE]);
            $street = Util::test_input($_POST[STREET]);
            $zip = Util::test_input($_POST[ZIP]);
            $city = Util::test_input($_POST[CITY]);
            $max_partecipants = Util::test_input($_POST[MAX_PARTECIPANTS]);
            $typology = Util::test_input($_POST[TYPOLOGY]);
            $coursePrice = Util::test_input($_POST[COURSE_PRICE]);
            $mealPrice = Util::test_input($_POST[MEAL_PRICE]);
            $courseDescription = Util::test_input($_POST[COURSE_DESCRIPTION]);
            $materials = Util::test_input($_POST[MATERIALS]);
            $acm->addCourse($title, $street, $zip, $city, $max_partecipants, $typology, $coursePrice, $mealPrice, $courseDescription, $materials);
        } else {
            header("Location: " . URL . "err");
        }
    }

}