<?php

/**
 * Class ModifyCourse Controller per modificare un corso.
 */
class ModifyCourse
{

    /**
     * Metodo per visualizzare la pagina di aggiunta corsi.
     */
    public function index()
    {
        MSession::checkAdmin();
        if (!isset($_SESSION[ID_MODIFY_COURSE])) {
            header("Location: " . URL . "err");
        }
        require_once 'application/models/modifyCourseModel.php';
        $mcm = new ModifyCourseModel();
        $course = $mcm->getAllDataCourse($_SESSION[ID_MODIFY_COURSE])[0];
        $typologies = $mcm->getAllTypology();

        require 'application/views/_template/header.php';
        require 'application/views/courses/modifyCourse.php';
        require 'application/views/_template/footer.php';
    }

    /**
     * Metodo per sapere quale corso modificare.
     * @param $id L'id del corso
     */
    function getDataCourse($id)
    {
        MSession::checkAdmin();
        require_once 'application/models/modifyCourseModel.php';
        $mcm = new ModifyCourseModel();
        $course = $mcm->getAllDataCourse($id);
        if (count($course) > 0) {
            $_SESSION[ID_MODIFY_COURSE] = $id;
            header("Location: " . URL . "modifyCourse");
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per modificare un corso.
     */
    function modifyCor()
    {
        MSession::checkAdmin();
        require_once 'application/models/modifyCourseModel.php';
        $mcm = new ModifyCourseModel();
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
            $mcm->modifyCourse($_SESSION[ID_MODIFY_COURSE], $title, $street, $zip, $city, $max_partecipants, $typology, $coursePrice, $mealPrice, $courseDescription, $materials);
        } else {
            header("Location: " . URL . "err");
        }
    }
}