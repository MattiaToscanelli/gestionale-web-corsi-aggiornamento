<?php

/**
 * Class ManagementCourseModel Classe per la gestione dei corsi
 */
class ManagementCourseModel
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
     * Metodo costruttore senza parametri, instanzia la variabile $connection.
     */
    public function __construct()
    {
        require_once "application/libs/database.php";
        require_once "application/libs/validator.php";
        $this->connection = new Database();
        $this->validator = new Validator($this->connection);
    }


    /**
     * Metodo per ricavare tutti i corsi.
     * @return array Tutte le tipologie.
     */
    public function getAllCourses()
    {
        $selectCourses = "SELECT * FROM course";
        $courses = $this->connection->query($selectCourses);
        return $courses;
    }

    /**
     * Metodo per eliminare un corso.
     * @param $id L'id del corso da eliminare.
     */
    public function deleteCourse($id)
    {
        $selectCourse = "SELECT * FROM course WHERE id=%i";
        $courses = $this->connection->query($selectCourse, $id);
        if (count($courses) > 0) {
            $selectIdExecutions = "SELECT e.id FROM course c, execution e WHERE c.id=e.id_course AND c.id=%i";
            $idsExe = $this->connection->query($selectIdExecutions,$id);
            foreach ($idsExe as $idExe){
                $this->deleteExecution($idExe[DB_EXECUTION_ID],1);
            }
            $deleteCourse = "DELETE FROM course WHERE id=%i";
            $this->connection->query($deleteCourse, $id);
            echo SUCCESSFUL;
        } else {
            echo ERROR;
        }
    }


    /**
     * Metodo per eliminare uno svolgimento.
     * @param $id L'id dello svolgimento da eliminare.
     * @param null $dCourse attibuto per sapere se il metodo è stato chiamato per eliminare un corso.
     */
    public function deleteExecution($id, $dCourse = null)
    {
        $selectExecution = "SELECT * FROM execution WHERE id=%i";
        $execution = $this->connection->query($selectExecution, $id);
        if (count($execution) > 0) {
            $selectEmail = "SELECT u.firstname, u.lastname, u.email, ex.start FROM user u, enrolls en, execution ex 
                            WHERE en.id_user=u.id AND en.id_execution = ex.id AND ex.start > CURDATE() AND ex.id=%i";
            $user = $this->connection->query($selectEmail, $id);
            if (count($user) > 0) {
                $selectTitleCourse = "SELECT title FROM course c, execution e WHERE c.id = e.id_course AND e.id=%i";
                $title = $this->connection->query($selectTitleCourse,$id);
                require_once 'application/libs/sendMail.php';
                $body = "Ciao,<br>
                        Il corso ".$title[0][DB_COURSE_TITLE]." del ".date("d.m.Y", strtotime($user[0][DB_EXECUTION_START]))." è stato annullato! In caso che avessi già pagato il corso nei prossimi giorni il saldo verrà rimborsato!</a>";
                try {
                    $s = new SendMail();
                    $emails = array();
                    for ($i = 0; count($user) > $i; $i++){
                        $emails[$i] = $user[$i][DB_USER_EMAIL];
                    }
                    $s->mailSendList($emails, "Annullamento corso", $body);
                } catch (Exception $e) {
                }
            }
            $deleteExecution = "DELETE FROM execution WHERE id=%i";
            $this->connection->query($deleteExecution, $id);
            if ($dCourse == null){
                echo SUCCESSFUL;
            }
        } else {
            if ($dCourse == null){
                echo ERROR;
            }
        }
    }

    /**
     * Metodo per ricavare i giorni per calcolare la data di scedenza.
     */
    public function getDeadline(){
        $selectDeadline= "SELECT day_deadline FROM settings";
        $deadline = $this->connection->query($selectDeadline);
        echo $deadline[0][DEADLINE];
    }

    /**
     * Metodo per ricavare tutti i docenti che possono insegnare un corso.
     * @return mixed La lista di utenti.
     */
    public function getTeachers(){
        $SelectUsers = "SELECT * FROM user WHERE type>1";
        $users = $this->connection->query($SelectUsers);
        return $users;
    }

    /**
     * Metodo per aggiungere uno svolgimento di un corso.
     * @param $start_day_lesson Il giorno di inizio svolgimento.
     * @param $duration_day Il giorno di fine svolgimento.
     * @param $teacher L'insegnate dello svolgimento.
     * @param $times Gli orari dello svoglimento.
     * @param $id_course L'id del corso di riferimento.
     */
    public function addExecution($start_day_lesson,$duration_day,$teacher,$times,$id_course)
    {
        $data = array();
        $checkStartDayLesson = $checkDurationDay = $checkTeacher = $checkTimes = $checkOverlap = $checkAll = SUCCESSFUL;
        $end = "";
        $day = explode("-",$start_day_lesson);
        if (!checkdate($day[1],$day[2],$day[0])) {
            $checkStartDayLesson = ERROR;
            $checkAll = ERROR;
        }else{
            $end = date('Y-m-d', strtotime($start_day_lesson. ' + '.($duration_day-1).' days'));
            if($this->validator->checkOverlapTeacher($start_day_lesson,$end,$teacher)){
                $checkOverlap = ERROR;
                $checkAll = ERROR;
            }
        }
        if (!$this->validator->checkDuration($duration_day)) {
            $checkDurationDay = ERROR;
            $checkAll = ERROR;
        }
        if (!$this->validator->checkTeacher($teacher)) {
            $checkTeacher = ERROR;
            $checkAll = ERROR;
        }
        if (!$this->validator->checkTimes($times)){
            $checkTimes = ERROR;
            $checkAll = ERROR;
        }

        if ($checkAll == SUCCESSFUL) {
            $selectCourse = "SELECT id FROM course WHERE id=%i";
            $course = $this->connection->query($selectCourse,$id_course);
            if(count($course)>0){
                $addExecution = "INSERT INTO execution (id_user,id_course,start,end) VALUES (%i,%i,%s,%s)";
                $this->connection->query($addExecution, $teacher, $id_course, $start_day_lesson, $end);
                $result = $this->connection->query("SELECT LAST_INSERT_ID() as 'id'");
                $idE = $result[0]["id"];
                $date = $start_day_lesson;
                $times = explode(",", $times);
                for ($i = 0; $i < count($times);$i+=2){
                    $addLesson = "INSERT INTO lesson (start,end,id_execution) VALUES (%s,%s,%i)";
                    $this->connection->query($addLesson, $date." ".$times[$i],$date." ".$times[$i+1], $idE);
                    $date = date('Y-m-d', strtotime($date. ' + 1 days'));
                }
            }else{
                Util::fail();
            }
        }
        $data[] = array(
            SATUTS => $checkAll,
            CHECK_START_DAY => $checkStartDayLesson,
            CHECK_OVERLAP => $checkOverlap,
            CHECK_DURATION => $checkDurationDay,
            CHECK_TEACHER => $checkTeacher,
            CHECK_TIMES => $checkTimes
        );
        echo json_encode($data);
    }

    /**
     * Metodo per ricavare tutti gli svolgimenti.
     * @return array Tutte gli svolgimenti tipologie.
     */
    public function getAllExecution()
    {
        $selectExecution = "SELECT u.email, u.firstname, u.lastname, e.start, e.end, c.title, e.id
                          FROM execution e, user u, course c
                          WHERE e.id_user = u.id
                          AND e.id_course = c.id;";
        $execution = $this->connection->query($selectExecution);
        return $execution;
    }
}

