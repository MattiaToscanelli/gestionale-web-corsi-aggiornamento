<?php

/**
 * Class EnrollmentCourse Controller della pagina di iscrizione ad un corso.
 */
class EnrollmentCourse
{

    /**
     * Metodo per la visualizzazione della pagina home.
     */
    public function index()
    {
        if (!isset($_SESSION[ID_MODIFY_COURSE])) {
            header("Location: " . URL . "err");
        }
        require_once 'application/models/enrollmentCourseModel.php';
        $ecm = new EnrollmentCourseModel();
        $execution = $ecm->getAllDataExecutions($_SESSION[ID_COURSE]);
        $course = $ecm->getAllDataCourse($_SESSION[ID_COURSE])[0];
        $minAge = $ecm->getMinAgeBirthday();
        $user = "";
        if (isset($_SESSION[SESSION_EMAIL])) {
            $user = $ecm->getAllDataUser($_SESSION[SESSION_EMAIL])[0];
        }

        require 'application/views/_template/header.php';
        require 'application/views/courses/enrollmentCourse.php';
        require 'application/views/_template/footer.php';
    }

    /**
     * Metodo per ricavare tutti i dati di un corso.
     * @param $id L'id del corso
     */
    function getDataCourse($id)
    {
        require_once 'application/models/enrollmentCourseModel.php';
        $ecm = new EnrollmentCourseModel();
        $course = $ecm->getAllDataCourse($id);
        if (count($course) > 0) {
            $_SESSION[ID_COURSE] = $id;
            header("Location: " . URL . "enrollmentCourse");
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per aggiungere un iscrizione.
     */
    function addEnrollment()
    {
        require_once 'application/models/enrollmentCourseModel.php';
        $ecm = new EnrollmentCourseModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[FIRSTNAME], $_POST[LASTNAME], $_POST[BIRTHDAY], $_POST[STREET], $_POST[CITY], $_POST[ZIP], $_POST[MOBILE_NUMBER], $_POST[LANDLINE_NUMBER], $_POST[LICENSE_NUMBER], $_POST[NIP], $_POST[SAVE], $_POST[LOGGED], $_POST[INCLUDE_FOOD], $_POST[EXECUTION_ID])) {
                Util::fail();
            }
            $password = $rePassword = $food = $foodType = $email = $intolerances = $newsletter = null;
            $firstname = Util::test_input($_POST[FIRSTNAME]);
            $lastname = Util::test_input($_POST[LASTNAME]);
            $birthday = Util::test_input($_POST[BIRTHDAY]);
            $street = Util::test_input($_POST[STREET]);
            $zip = Util::test_input($_POST[ZIP]);
            $city = Util::test_input($_POST[CITY]);
            $mobileNumber = Util::test_input($_POST[MOBILE_NUMBER]);
            $landlineNumber = Util::test_input($_POST[LANDLINE_NUMBER]);
            $licenseNumber = Util::test_input($_POST[LICENSE_NUMBER]);
            $nip = Util::test_input($_POST[NIP]);
            $logged = Util::test_input($_POST[LOGGED]);
            if ($logged == "false") {
                if (isset($_POST[EMAIL])) {
                    $email = Util::test_input($_POST[EMAIL]);
                } else {
                    Util::fail();
                }
            } else {
                $email = $_SESSION[SESSION_EMAIL];
            }
            $save = Util::test_input($_POST[SAVE]);
            if ($save == "true") {
                if (isset($_POST[PASSWORD], $_POST[RE_PASSWORD], $_POST[NEWSLETTER])) {
                    $password = Util::test_input($_POST[PASSWORD]);
                    $rePassword = Util::test_input($_POST[RE_PASSWORD]);
                    $newsletter = Util::test_input($_POST[NEWSLETTER]);
                } else {
                    Util::fail();
                }
            }
            $incluFood = Util::test_input($_POST[INCLUDE_FOOD]);
            if ($incluFood == "false") {
                $food = Util::test_input($_POST[FOOD]);
                if ($food == "true") {
                    if (isset($_POST[FOOD_TYPE], $_POST[INTOLERANCES])) {
                        $foodType = $_POST[FOOD_TYPE];
                        $intolerances = $_POST[INTOLERANCES];
                    } else {
                        Util::fail();
                    }
                }
            }
            $execution_id = Util::test_input($_POST[EXECUTION_ID]);
            $ecm->addEnrollment($firstname, $lastname, $birthday, $street, $zip, $city, $mobileNumber, $landlineNumber, $licenseNumber, $nip, $logged, $save, $incluFood, $food, $execution_id, $password, $rePassword, $foodType, $email, $intolerances, $newsletter, $_SESSION[ID_COURSE], $_POST[CAPTCHA_V2]);
        } else {
            header("Location: " . URL . "err");
        }
    }

}