<?php

/**
 * Class ManagementExecution Controller per gestire le iscrizioni di uno svolgimento.
 */
class ManagementExecution
{

    /**
     * Metodo per la visualizzazione della pagina di gestione delle iscrizioni di uno svolgimento.
     */
    public function index()
    {
        MSession::checkAdmin();
        if (!isset($_SESSION[ID_MANAGE_EXECUTION])) {
            header("Location: " . URL . "err");
        }
        require_once 'application/models/managementExecutionModel.php';
        $mem = new ManagementExecutionModel();
        $idExecution = $_SESSION[ID_MANAGE_EXECUTION];
        $execution = $mem->getAllPartecipantsExecution($idExecution);
        $title = $mem->getTitleCourse($idExecution);
        $priceMealCourse = $mem->getMealPriceCourse($idExecution);
        $dateExecution = $mem->getAllDateExecution($idExecution);
        $partecpiants = $mem->getNumberCourseEnrollments($idExecution);
        $minAge = $mem->getMinAgeBirthday();

        require 'application/views/_template/header.php';
        require 'application/views/courses/managementExecution.php';
        require 'application/views/_template/footer.php';
    }

    /**
     * Metodo per sapere quale svolgimento gestire.
     * @param $id L'id del corso
     */
    function getDataExecution($id)
    {
        MSession::checkAdmin();
        require_once 'application/models/managementExecutionModel.php';
        $mem = new ManagementExecutionModel();
        $execution = $mem->getAllDataExecution($id);
        if (count($execution) > 0) {
            $_SESSION[ID_MANAGE_EXECUTION] = $id;
            header("Location: " . URL . "managementExecution");
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per assegnare il pagamento o non di un iscrzione.
     */
    function enrollmentPaid()
    {
        MSession::checkAdmin();
        require_once 'application/models/managementExecutionModel.php';
        $mem = new ManagementExecutionModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[FLAG_PAID], $_POST[ENROLL_ID])) {
                Util::fail();
            }
            $enroll_id = Util::test_input($_POST[ENROLL_ID]);
            $flag_paid = Util::test_input($_POST[FLAG_PAID]);
            $mem->enrollmentPaid($enroll_id, $flag_paid);
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per aggiungere un'iscrizione.
     */
    function addEnrollment()
    {
        MSession::checkAdmin();
        require_once 'application/models/managementExecutionModel.php';
        $mem = new ManagementExecutionModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[FIRSTNAME], $_POST[LASTNAME], $_POST[BIRTHDAY], $_POST[STREET], $_POST[CITY], $_POST[ZIP], $_POST[MOBILE_NUMBER], $_POST[LANDLINE_NUMBER], $_POST[LICENSE_NUMBER], $_POST[NIP], $_POST[INCLUDE_FOOD], $_POST[EXECUTION_ID])) {
                Util::fail();
            }
            $food = $foodType = $intolerances = null;
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
            $email = Util::test_input($_POST[EMAIL]);
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
            $mem->addEnrollment($firstname, $lastname, $birthday, $street, $zip, $city, $mobileNumber, $landlineNumber, $licenseNumber, $nip, $incluFood, $food, $execution_id, $foodType, $intolerances, $email);
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per eliminare un'iscrizione.
     */
    public function deleteEnrollment()
    {
        MSession::checkUser();
        require_once 'application/models/managementExecutionModel.php';
        $mem = new ManagementExecutionModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[ENROLL_ID])) {
                Util::fail();
            }
            $mem->deleteEnrollment(Util::test_input($_POST[ENROLL_ID]));
        } else {
            header("Location: " . URL . "err");
        }
    }
}