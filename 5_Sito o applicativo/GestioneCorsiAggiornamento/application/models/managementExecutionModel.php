<?php

/**
 * Class ManagementExecutionModel Classe per la gestione delle iscrizioni di un corso.
 */
class ManagementExecutionModel
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
     * Metodo per ricavare tutti i dati di uno svolgimenti.
     * @param $id L'id dello svolgimento.
     * @return mixed I dati dello svolgimento.
     */
    public function getAllDataExecution($id)
    {
        $selectExecution = "SELECT * FROM execution WHERE id=%i";
        $execution = $this->connection->query($selectExecution, $id);
        return $execution;
    }

    /**
     * Metodo per ricavare la data minima di iscrizione ad un corso.
     * @return mixed L'anno minimo di iscrizione.
     */
    public function getMinAgeBirthday()
    {
        $selectMinAge = "SELECT min_age FROM settings";
        return $this->connection->query($selectMinAge)[0][DB_MIN_AGE];
    }

    /**
     * Metodo per ricavare il titolo di un corso.
     * @param $id L'id dello svolgimento.
     * @return mixed Il titolo del corso.
     */
    public function getTitleCourse($id)
    {
        $selectTitle = "SELECT c.title FROM course c, execution e
                            WHERE c.id = e.id_course
                            AND e.id = %i;";
        $title = $this->connection->query($selectTitle, $id);
        return $title[0][DB_COURSE_TITLE];
    }

    /**
     * Metodo per ricavare il prezzo del pasto del corso.
     * @param $id L'id dello svolgimento.
     * @return mixed Il prezzo del pasto del corso.
     */
    public function getMealPriceCourse($id)
    {
        $selectMealPrice = "SELECT c.meal_price FROM course c, execution e
                            WHERE c.id = e.id_course
                            AND e.id = %i;";
        $title = $this->connection->query($selectMealPrice, $id);
        return $title[0][DB_COURSE_MEAL_PRICE];
    }

    /**
     * Metodo per ricavare tutti i parteciupanti di uno svolgimento.
     * @param $id L'id dello svolgimento.
     * @return mixed I parteciupanti di uno svolgimento.
     */
    public function getAllPartecipantsExecution($id)
    {
        $selectPartecipants = "SELECT u.firstname, u.lastname, u.email, e.flag_paid, e.flag_meal, e.food_type, e.intolerances, e.id
                            FROM user u, enrolls e
                            WHERE e.id_user=u.id
                            AND id_execution=%i";
        $partecipants = $this->connection->query($selectPartecipants, $id);
        return $partecipants;
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
     * Metodo per ricavare i posti rimanenti di uno svolgimento.
     * @param $idExecution L'id dello svolgimento.
     * @return mixed I posti rimanenti.
     */
    public function getNumberCourseEnrollments($idExecution)
    {
        $selectCourseId = "SELECT id_course FROM execution WHERE id=%i;";
        $idCourse = $this->connection->query($selectCourseId, $idExecution);
        if (count($idCourse) > 0) {
            $selectEnroll = "SELECT COUNT(*) as 'member' FROM enrolls WHERE id_execution=%i;";
            $member = $this->connection->query($selectEnroll, $idExecution);
            $selectCourse = "SELECT max_partecipants FROM course WHERE id=%i;";
            $max_member = $this->connection->query($selectCourse, $idCourse[0][DB_ID_COURSE]);
            if (is_numeric($member[0][MEMBER]) && is_numeric($max_member[0][DB_COURSE_MAX_PARTECIPANTS])) {
                return array(intval($max_member[0][DB_COURSE_MAX_PARTECIPANTS]) - intval($member[0][MEMBER]), $max_member[0][DB_COURSE_MAX_PARTECIPANTS]);
            } else {
                Util::fail();
            }
        } else {
            Util::fail();
        }
    }

    /**
     * Metodo per ricavare tutti i dati di un corso.
     * @param $id L'id del corso.
     * @return mixed I dati del corso.
     */
    public function getAllDataCourse($id)
    {
        $selectCourse = "SELECT * FROM course WHERE id=%i";
        $course = $this->connection->query($selectCourse, $id);
        return $course;
    }

    /**
     * Metodo per ricavare tutte le date di uno svolgimento.
     * @param $idExecution L'id dello svolgimento.
     * @return mixed Le date dello svoglimento.
     */
    public function getAllDateExecution($idExecution)
    {
        $dateExecution = array();
        $selectLessons = "SELECT start,end FROM lesson WHERE id_execution=%i";
        $lessons = $this->connection->query($selectLessons, $idExecution);
        $dateLessons = array();
        for ($i = 0; count($lessons) > $i; $i++) {
            $dateLessons[$i][START_LESSON] = $lessons[$i][START_LESSON];
            $dateLessons[$i][END_LESSON] = $lessons[$i][END_LESSON];
        }
        $dateExecution[DATE_EXECUTION] = $dateLessons;
        $dateExecution[DEADLINE] = date("d.m.Y", strtotime('-' . $this->getDeadline() . ' day', strtotime($dateLessons[0][START_LESSON])));
        return $dateExecution;
    }

    /**
     * Metodo per assegnare il pagamento o non di un iscrzione.
     * @param $idErollment l'id dell'iscrzione.
     * @param $status Lo stato del pagamento.
     */
    public function enrollmentPaid($idErollment, $status)
    {
        if ($status == "true" || $status == "false") {
            $updateEnrollment = "UPDATE enrolls SET flag_paid=%i WHERE id=%i";
            $this->connection->query($updateEnrollment, ($status == "true") ? 1 : 0, $idErollment);
            $selectIdExecution = "SELECT id_execution FROM enrolls WHERE id=%i";
            $idExe = $this->connection->query($selectIdExecution, $idErollment);
            $dateExecution = $this->getAllDateExecution($idExe[0][EXECUTION_ID]);
            $selectIdUser = "SELECT id_user FROM enrolls WHERE id=%i";
            $idUser = $this->connection->query($selectIdUser, $idErollment);
            $selectUser = "SELECT * FROM user WHERE id=%i";
            $result = $this->connection->query($selectUser, $idUser[0][DB_ID_USER]);
            require 'application/libs/sendMail.php';
            if ($status == "true") {
                $body = "Ciao " . $result[0][DB_USER_FIRSTNAME] . " " . $result[0][DB_USER_LASTNAME] . ",<br>
                             il pagamento del corso è stato ricevuto con successo! Qui di seguito puoi trovare gli orari del corso: <br><br>
                             <p><strong>Orari</strong></p>";
                for ($i = 0; $i < count($dateExecution[DATE_EXECUTION]); $i++) {
                    $body .= "<p>
                                <strong>" . date("d.m.Y", strtotime($dateExecution[DATE_EXECUTION][$i][START_LESSON])) . "</strong>
                                Ora inzio:" . date("H:i", strtotime($dateExecution[DATE_EXECUTION][$i][DB_EXECUTION_START])) .
                        " Ora fine:" . date("H:i", strtotime($dateExecution[DATE_EXECUTION][$i][DB_EXECUTION_END])) . "</p>";
                }
                try {
                    $s = new SendMail();
                    $s->mailSend($result[0][EMAIL], "Pagamento", $body);
                } catch (Exception $e) {
                }
            } else {
                $body = "Ciao " . $result[0][DB_USER_FIRSTNAME] . " " . $result[0][DB_USER_LASTNAME] . ",<br>
                             il pagamento del corso è stato rimborsato con successo! In caso di problemi contatta l'amministratore della pagina.";
                try {
                    $s = new SendMail();
                    $s->mailSend($result[0][EMAIL], "Pagamento", $body);
                } catch (Exception $e) {
                }
            }
        } else {
            Util::fail();
        }
    }

    /**
     * Metodo per aggiungere un iscrizione.
     * @param $firstname Il nome dell'utente.
     * @param $lastname Il cognome dell'utente.
     * @param $birthday La data di nacita dell'utente.
     * @param $street La via dell'utente.
     * @param $zip Il codice di avviamento postale dell'utente.
     * @param $city La città dell'utente.
     * @param $mobileNumber Il numero di telefono mobile dell'utente.
     * @param $landlineNumber Il numero di telefono fisso dell'utente.
     * @param $licenseNumber Il numero di licenza dell'utente.
     * @param $nip Il codice nip dell'utente.
     * @param $incluFood Flag per sapere nel corso è presente un pranzo.
     * @param $food Flag per sapere se l'utente vuole partecipare al pranzo.
     * @param $executionId L'id dello svolgimento.
     * @param $foodType La tipolgoia di cibo.
     * @param $intolerances Le intollernaze dell'utente.
     */
    function addEnrollment($firstname, $lastname, $birthday, $street, $zip, $city, $mobileNumber, $landlineNumber, $licenseNumber, $nip, $incluFood, $food, $executionId, $foodType, $intolerances, $email)
    {
        $data = array();

        $checkAll = $checkFirstname = $checkLastname = $checkBirthday = $checkStreet = $checkZip = $checkCity = $checkMobileNumber = $checkLandlineNumber = $checkNip = $checkEmail = $checkLicenseNumber = $checkFoodType = $checkIntolerances = $checkOverlap = SUCCESSFUL;

        //eseguo tutti i controlli
        if (!$this->validator->checkName($firstname)) {
            $checkFirstname = ERROR;
            $checkAll = ERROR;
        }
        if (!$this->validator->checkName($lastname)) {
            $checkLastname = ERROR;
            $checkAll = ERROR;
        }
        if (!$this->validator->checkBirthday($birthday) || $birthday == "") {
            $checkBirthday = ERROR;
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
        if (!$this->validator->checkPhoneNumber($mobileNumber)) {
            $checkMobileNumber = ERROR;
            $checkAll = ERROR;
        } else {
            $mobileNumber = str_replace(" ", "", $mobileNumber);
            $mobileNumber = str_replace("-", "", $mobileNumber);
        }
        if (!$this->validator->checkPhoneNumber($landlineNumber) && $landlineNumber != "") {
            $checkLandlineNumber = ERROR;
            $checkAll = ERROR;
        } else {
            $mobileNumber = str_replace(" ", "", $mobileNumber);
            $mobileNumber = str_replace("-", "", $mobileNumber);
        }
        if (!$this->validator->checkLicenseNumber($licenseNumber) && $licenseNumber != "") {
            $checkLicenseNumber = ERROR;
            $checkAll = ERROR;
        }
        if (!$this->validator->checkNip($nip) && $nip != "") {
            $checkNip = ERROR;
            $checkAll = ERROR;
        }
        if (!$this->validator->checkEmail($email)) {
            $checkEmail = ERROR;
            $checkAll = ERROR;
        }
        if ($incluFood == "false") {
            if ($food == "true") {
                if (!$this->validator->checkFoodType($foodType)) {
                    $checkFoodType = ERROR;
                    $checkAll = ERROR;
                }
                if (!$this->validator->checkTextArea($intolerances) && $intolerances != "") {
                    $checkIntolerances = ERROR;
                    $checkAll = ERROR;
                }
            }
        }
        if ($this->validator->checkOverlapExecution($email, $executionId)) {
            $checkAll = ERROR;
            $checkOverlap = ERROR;
        }
        $selectCourseId = "SELECT id_course FROM execution WHERE id=%i";
        $courseId = $this->connection->query($selectCourseId, $executionId);
        if (count($courseId) <= 0) {
            Util::fail();
        }
        $courseId = $courseId[0][ID_COURSE];
        if ($checkAll == SUCCESSFUL) {
            $addUser = "INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,landline_number,type,nip,license_number) VALUES (%s,%s,%s,%s,%i,%s,%s,%s,%s,0,%s,%s)";
            $this->connection->query($addUser, $email, $firstname, $lastname, $birthday, $zip, $city, $street, $mobileNumber, $landlineNumber, $nip, $licenseNumber);
            $selectUser = "SELECT id, firstname, lastname FROM user WHERE email=%s";
            $result = $this->connection->query($selectUser, $email);
            if (count($result) > 0) {
                $insertEnroll = "INSERT INTO enrolls (id_user,id_execution,intolerances,food_type,flag_meal,flag_paid) VALUES (%i,%i,%s,%s,%s,0)";
                $this->connection->query($insertEnroll, $result[0][DB_USER_ID], $executionId, $intolerances, $foodType, ($food == "true") ? 1 : 0);
                $selectPayment = "SELECT iban_number, bank, beneficiary FROM settings";
                $payment = $this->connection->query($selectPayment, $email);
                $course = $this->getAllDataCourse($courseId);
                $price = doubleval($course[0][DB_COURSE_COURSE_PRICE]);
                if ($incluFood == "false") {
                    if ($food == "true") {
                        $price += doubleval($course[0][DB_COURSE_MEAL_PRICE]);
                    }
                }
                require 'application/libs/sendMail.php';
                $body = "Ciao " . $result[0][DB_USER_FIRSTNAME] . " " . $result[0][DB_USER_LASTNAME] . ",<br>
                         per completare la tua iscrizione esegui questo pagamento: <br><br>
                         <p><strong>IBAN: </strong>" . $payment[0][DB_IBAN] . "</p>
                         <p><strong>Banca: </strong>" . $payment[0][DB_BANK] . "</p>
                         <p><strong>Beneficiario: </strong>" . $payment[0][DB_BENEFICIARY] . "</p>
                         <p><strong>Costo: </strong>$price CHF</p><br>                    
                         Inserisci nel messaggio di pagamento la tua email per poter confermare il pagamento! Appena riceveremo i soldi ti arriverà un ulteriore email.<br><br>  
                         <p><strong>Informazioni corso</strong></p>
                         <p><strong>Titolo: </strong>" . $course[0][DB_COURSE_TITLE] . "</p>
                         <p><strong>Città: </strong>" . $course[0][DB_COURSE_CITY] . "</p>
                         <p><strong>Via: </strong>" . $course[0][DB_COURSE_STREET] . "</p>
                         <p><strong>Tipologia: </strong>" . $course[0][DB_COURSE_TYPOLOGY] . "</p><br>";
                try {
                    $s = new SendMail();
                    $s->mailSend($email, "Iscrizione", $body);
                } catch (Exception $e) {
                }
            } else {
                Util::fail();
            }
        }

        // preparo il json con tutti i controlli da ritornare al client
        $data[] = array(
            SATUTS => $checkAll,
            CHECK_FIRSTNAME => $checkFirstname,
            CHECK_LASTNAME => $checkLastname,
            CHECK_BIRTHDAY => $checkBirthday,
            CHECK_ZIP => $checkZip,
            CHECK_CITY => $checkCity,
            CHECK_STREET => $checkStreet,
            CHECK_MOBILE_NUMBER => $checkMobileNumber,
            CHECK_LANDLINE_NUMBER => $checkLandlineNumber,
            CHECK_NIP => $checkNip,
            CHECK_LICENSE_NUMBER => $checkLicenseNumber,
            CHECK_FOOD_TYPE => $checkFoodType,
            CHECK_INTOLERANCES => $checkIntolerances,
            CHECK_EMAIL => $checkEmail,
            CHECK_OVERLAP => $checkOverlap
        );
        echo json_encode($data);
    }

    /**
     * Metodo per eliminare un'iscrizione.
     * @param $id L'id dell'iscrizione da eliminare.
     */
    public function deleteEnrollment($id)
    {
        $selectEnrolls = "SELECT id_user, id_execution, flag_paid FROM enrolls WHERE id=%i";
        $enrollment = $this->connection->query($selectEnrolls, $id);
        if (count($enrollment) > 0) {
            if ($enrollment[0][DB_FLAG_PAID] == 1) {
                $selectLessons = "SELECT * FROM execution WHERE id=%i";
                $lessons = $this->connection->query($selectLessons, ($enrollment[0][EXECUTION_ID]));
                $deadline = $this->getDeadline();
                $deadline = strtotime("-$deadline day", strtotime($lessons[0][DB_EXECUTION_START]));
                if ($deadline < strtotime('today midnight')) {
                    echo ERR_DATE;
                    exit;
                }
            }
            $selectEmail = "SELECT u.firstname, u.lastname, u.email FROM user u, enrolls en, execution ex 
                            WHERE en.id_user=u.id AND en.id_execution=ex.id AND ex.start > CURDATE() AND en.id=%i;";
            $user = $this->connection->query($selectEmail, $id);
            if (count($user) > 0) {
                $selectTitleCourse = "SELECT title FROM course c, execution e WHERE c.id = e.id_course AND e.id=%i";
                $title = $this->connection->query($selectTitleCourse,$enrollment[0][EXECUTION_ID]);
                require 'application/libs/sendMail.php';
                $body = "Ciao " . $user[0][DB_USER_FIRSTNAME] . " " . $user[0][DB_USER_LASTNAME] . ",<br>
                         Sei stato rimosso dal corso ".$title[0][DB_COURSE_TITLE]."! In caso che avessi già pagato il corso nei prossimi giorni il saldo verrà rimborsato!</a>";
                try {
                    $s = new SendMail();
                    $s->mailSend($user[0][DB_USER_EMAIL], "Disiscrizione corso", $body);
                } catch (Exception $e) {
                }
            }
            $deleteEnrollment = "DELETE FROM enrolls WHERE id=%i";
            $this->connection->query($deleteEnrollment, $id);
            echo SUCCESSFUL;
        } else {
            echo ERROR;
        }
    }


}

