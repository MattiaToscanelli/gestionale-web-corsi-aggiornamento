<?php

/**
 * Class EnrollmentCourseModel Model utilizzato per l'iscrizione ad un corso'.
 */
class EnrollmentCourseModel
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
     * Metodo per ricavare la data minima di iscrizione ad un corso.
     * @return mixed L'anno minimo di iscrizione.
     */
    public function getMinAgeBirthday()
    {
        $selectMinAge = "SELECT min_age FROM settings";
        return $this->connection->query($selectMinAge)[0][DB_MIN_AGE];
    }

    /**
     * Metodo per ricavare i posti rimanenti di uno svolgimento.
     * @param $idCourse L'id del corso
     * @param $idEnroll L'id dello svogimento.
     * @return mixed I posti rimanenti.
     */
    public function getNumberCourseEnrollments($idCourse, $idEnroll)
    {
        $selectEnroll = "SELECT COUNT(*) as 'member' FROM enrolls WHERE id_execution=%i;";
        $member = $this->connection->query($selectEnroll, $idEnroll);
        $selectCourse = "SELECT max_partecipants FROM course WHERE id=%i;";
        $max_member = $this->connection->query($selectCourse, $idCourse);
        if (is_numeric($member[0][MEMBER]) && is_numeric($max_member[0][DB_COURSE_MAX_PARTECIPANTS])) {
            return array(intval($max_member[0][DB_COURSE_MAX_PARTECIPANTS]) - intval($member[0][MEMBER]), $max_member[0][DB_COURSE_MAX_PARTECIPANTS]);
        } else {
            Util::fail();
        }
    }

    /**
     * Metodo per ricavare tutti i dati di un utente.
     * @param $email L'email dell'utente.
     * @return mixed I dati dell'utente.
     */
    public function getAllDataUser($email)
    {
        $selectUser = "SELECT * FROM user WHERE email=%s";
        $user = $this->connection->query($selectUser, $email);
        return $user;
    }

    /**
     * Metodo per ricavare la email di un utente.
     * @param $idUser L'id' dell'utente.
     * @return mixed la email dell'utente.
     */
    public function getEmailUser($idUser)
    {
        $selectUser = "SELECT * FROM user WHERE id=%i";
        $user = $this->connection->query($selectUser, $idUser);
        return $user[0][DB_USER_EMAIL];
    }

    /**
     * Metodo per ricavare i giorni per calcolare la data di scedenza.
     */
    public function getDeadline()
    {
        $selectDeadline = "SELECT day_deadline FROM settings";
        $deadline = $this->connection->query($selectDeadline);
        return $deadline[0][DB_DEADLINE];
    }

    /**
     * Metodo per ricavare tutte le date e partecipanti di un corsoo.
     * @param $idCourse L'id del corso.
     * @return mixed Le date delle esecuzioni di un corso.
     */
    public function getAllDataExecutions($idCourse)
    {
        $dateExecution = array();
        $selectIdExe = "SELECT id, start, id_user FROM execution WHERE id_course=%i AND date(start) >= DATE_ADD(CURDATE(), INTERVAL %i DAY) ORDER BY start, end;";
        $execution = $this->connection->query($selectIdExe, $idCourse, $this->getDeadline());
        for ($i = 0; count($execution) > $i; $i++) {
            if ($this->getNumberCourseEnrollments($idCourse, $execution[$i][DB_EXECUTION_ID])[0] > 0) {
                $selectLessons = "SELECT start,end FROM lesson WHERE id_execution=%i";
                $lessons = $this->connection->query($selectLessons, $execution[$i][DB_EXECUTION_ID]);
                $dateLessons = array();
                for ($j = 0; count($lessons) > $j; $j++) {
                    $dateLessons[$j][START_LESSON] = $lessons[$j][START_LESSON];
                    $dateLessons[$j][END_LESSON] = $lessons[$j][END_LESSON];
                }
                $emailTeacher = $this->getEmailUser($execution[$i][EXECUTION_ID_USER]);
                $user = $this->getAllDataUser($emailTeacher);
                $dateExecution[$execution[$i][DB_EXECUTION_ID]][DATE_EXECUTION] = $dateLessons;
                $dateExecution[$execution[$i][DB_EXECUTION_ID]][MEMBER] = $this->getNumberCourseEnrollments($idCourse, $execution[$i][DB_EXECUTION_ID]);
                $dateExecution[$execution[$i][DB_EXECUTION_ID]][DEADLINE] = date("d.m.Y", strtotime('-' . $this->getDeadline() . ' day', strtotime($dateLessons[0][START_LESSON])));
                $dateExecution[$execution[$i][DB_EXECUTION_ID]][USER] = $user[0];
            }
        }
        return $dateExecution;
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
     * @param $logged Flag per sapere se l'utente che si sta per iscrivere è registrato al sito.
     * @param $save Flag per sapere se l'utente vuole essere salvato o no.
     * @param $incluFood Flag per sapere nel corso è presente un pranzo.
     * @param $food Flag per sapere se l'utente vuole partecipare al pranzo.
     * @param $execution_id L'id dello svolgimento.
     * @param $password La password dell'utente.
     * @param $rePassword La re-password dell'utente.
     * @param $foodType La tipolgoia di cibo.
     * @param $email L'email dell'utente.
     * @param $intolerances Le intollernaze dell'utente.
     * @param $newsletter Flag per sapere se l'utente vuole iscriversi alla newsletter.
     * @param $courseId L'id del corso di riferimento.
     */
    function addEnrollment($firstname, $lastname, $birthday, $street, $zip, $city, $mobileNumber, $landlineNumber, $licenseNumber, $nip, $logged, $save, $incluFood, $food, $executionId, $password, $rePassword, $foodType, $email, $intolerances, $newsletter, $courseId)
    {
        $data = array();

        //variabili per salvare i controlli dei vari input
        $checkAll = $checkFirstname = $checkLastname = $checkBirthday = $checkStreet = $checkZip = $checkCity = $checkMobileNumber = $checkLandlineNumber = $checkCaptcha = $checkNip = $checkLicenseNumber = $checkFoodType = $checkIntolerances = $checkPassword = $checkEmail = $checkExecutionFull = $checkOverlap = SUCCESSFUL;

        //eseguo tutti i controlli
        $secretKey = SECRET_KEY;
        $responseKey = $_POST[CAPTCHA_V2];
        $userIP = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
        $response = file_get_contents($url);
        $response = json_decode($response);
        if (!$response->success) {
            $checkCaptcha = ERROR;
            $checkAll = ERROR;
        }
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
        if ($logged == "false") {
            if (!$this->validator->checkEmail($email)) {
                $checkEmail = ERROR;
                $checkAll = ERROR;
            }
        }
        if ($save == "true") {
            if (!$this->validator->checkPassword($password, $rePassword)) {
                $checkPassword = ERROR;
                $checkAll = ERROR;
            }
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
        if (!$this->getNumberCourseEnrollments($courseId, $executionId)[0] != 0) {
            $checkAll = ERROR;
            $checkExecutionFull = ERROR;
        }
        if ($checkAll == SUCCESSFUL) {
            if ($logged == "false") {
                if ($save == "true") {
                    $addUser = "INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,landline_number,flag_newsletter,password,type,nip,license_number) VALUES (%s,%s,%s,%s,%i,%s,%s,%s,%s,%i,%s,1,%s,%s)";
                    $this->connection->query($addUser, $email, $firstname, $lastname, $birthday, $zip, $city, $street, $mobileNumber, $landlineNumber, ($newsletter == "true") ? 1 : 0, password_hash($password, PASSWORD_DEFAULT), $nip, $licenseNumber);
                } else {
                    $addUser = "INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,landline_number,type,nip,license_number) VALUES (%s,%s,%s,%s,%i,%s,%s,%s,%s,0,%s,%s)";
                    $this->connection->query($addUser, $email, $firstname, $lastname, $birthday, $zip, $city, $street, $mobileNumber, $landlineNumber, $nip, $licenseNumber);
                }
            } else {
                $updateUser = "UPDATE user SET firstname=%s,lastname=%s,birthday=%s,zip=%i,city=%s,street=%s,mobile_number=%s,landline_number=%s,nip=%s,license_number=%s WHERE email=%s";
                $this->connection->query($updateUser, $firstname, $lastname, $birthday, $zip, $city, $street, $mobileNumber, $landlineNumber, $nip, $licenseNumber, $email);
            }
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
                require_once 'application/libs/sendMail.php';
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
                         <p><strong>Tipologia: </strong>" . $course[0][DB_COURSE_TYPOLOGY] . "</p><br> ";
                try {
                    $s = new SendMail();
                    $s->mailSend($email, "Iscrizione ".$course[0][DB_COURSE_TITLE], $body);
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
            CHECK_PASSWORD => $checkPassword,
            CHECK_EMAIL => $checkEmail,
            CHECK_EXECUTION_FULL => $checkExecutionFull,
            CHECK_OVERLAP => $checkOverlap,
            CHECK_CAPTCHA => $checkCaptcha
        );
        echo json_encode($data);
    }
}