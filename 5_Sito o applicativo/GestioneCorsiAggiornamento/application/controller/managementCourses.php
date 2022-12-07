<?php

/**
 * Class ManagementCourses Controller per gestire i corsi.
 */
class ManagementCourses
{

    /**
     * Metodo per la visualizzazione della pagina di gestione dei corsi.
     */
    public function index()
    {
        MSession::checkAdmin();
        require 'application/models/managementCourseModel.php';

        $mcm = new ManagementCourseModel();
        $courses = $mcm->getAllCourses();
        $teachers = $mcm->getTeachers();
        $executions = $mcm->getAllExecution();

        require 'application/views/_template/header.php';
        require 'application/views/courses/managementCourses.php';
        require 'application/views/_template/footer.php';
    }

    /**
     * Metodo per eliminare un corso.
     */
    public function deleteCourse()
    {
        MSession::checkAdmin();
        require_once 'application/models/managementCourseModel.php';
        $mpm = new ManagementCourseModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[COURSE_ID])) {
                Util::fail();
            }
            $mpm->deleteCourse(Util::test_input($_POST[COURSE_ID]));
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per eliminare uno svolgimento.
     */
    public function deleteExecution()
    {
        MSession::checkAdmin();
        require_once 'application/models/managementCourseModel.php';
        $mpm = new ManagementCourseModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[ID_EXECUTION])) {
                Util::fail();
            }
            $mpm->deleteExecution(Util::test_input($_POST[ID_EXECUTION]));
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per ricavare i giorni per calcolare la data di scedenza.
     */
    public function getDeadline()
    {
        MSession::checkAdmin();
        require_once 'application/models/managementCourseModel.php';
        $mpm = new ManagementCourseModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $mpm->getDeadline();
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per ricavare tutti i docenti che possono insegnare un corso.
     */
    public function getTeachers()
    {
        MSession::checkAdmin();
        require_once 'application/models/managementCourseModel.php';
        $mpm = new ManagementCourseModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $mpm->getTeachers();
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per aggiungere uno svolgimento.
     */
    function addExecution()
    {
        MSession::checkAdmin();
        require_once 'application/models/managementCourseModel.php';
        $mcm = new ManagementCourseModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[START_DAY_LESSON], $_POST[DURATION_DAY], $_POST[TEACHER], $_POST[TIMES], $_POST[COURSE_ID])) {
                Util::fail();
            }
            $start_day_lesson = Util::test_input($_POST[START_DAY_LESSON]);
            $duration_day = Util::test_input($_POST[DURATION_DAY]);
            $teacher = Util::test_input($_POST[TEACHER]);
            $times = Util::test_input($_POST[TIMES]);
            $id_course = Util::test_input($_POST[COURSE_ID]);
            $mcm->addExecution($start_day_lesson, $duration_day, $teacher, $times, $id_course);
        } else {
            header("Location: " . URL . "err");
        }
    }
}