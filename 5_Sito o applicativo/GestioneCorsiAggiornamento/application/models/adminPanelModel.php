<?php

/**
 * Model oer gestire il pannello admin.
 */
class AdminPanelModel
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
     * @var string Percorso del file di descrizione.
     */
    private $pathDescription = "application/libs/description.txt";

    /**
     * @var string Percorso del file di contatti.
     */
    private $pathContact = "application/libs/contact.txt";

    /**
     * Metodo costruttore senza parametri, instanzia le varibili $validator e $connection.
     */
    function __construct()
    {
        require_once "application/libs/database.php";
        require_once "application/libs/validator.php";
        $this->connection = new Database();
        $this->validator = new Validator($this->connection);
    }

    /**
     * Metodo per ricavare tutte le foto da mettere nella pagina principale.
     * @return array Tutte le foto.
     */
    public function getAllPhotos()
    {
        $selectPhotos = "SELECT * FROM photo";
        $photos = $this->connection->query($selectPhotos);
        return $photos;
    }

    /**
     * Metodo per eliminare una foto.
     * @param $path Il percorso della foto da eliminare.
     */
    public function delPhoto($path)
    {
        $selectPhoto = "SELECT * FROM photo WHERE path=%s";
        $photo = $this->connection->query($selectPhoto, $path);
        if (count($photo) > 0) {
            $deletePhoto = "DELETE FROM photo WHERE path=%s";
            $this->connection->query($deletePhoto, $path);
            if(file_exists ($photo[0][DB_PATH_PHOTO])) {
                unlink($photo[0][DB_PATH_PHOTO]);
            }
            echo SUCCESSFUL;
        } else {
            echo ERROR;
        }
    }

    /**
     * Metodo per aggiungere una foto.
     * @param $photo La foto da aggiungere.
     */
    function addPhoto($photo)
    {
        $target_dir = "img/";
        $target_file = $target_dir . basename($photo[PICTURE_NAME]);
        $uploadOk = SUCCESSFUL;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        //Verifico che il file è un'immagine
        if ($photo[PICTURE_TMP_NAME] != null) {
            if (!(getimagesize($photo[PICTURE_TMP_NAME]) !== false)) {
                $uploadOk = ERROR;
            }
        } else {
            $uploadOk = ERROR;
        }
        //controllo se la grandezza è minore di 5MB
        if ($photo[PICTURE_SIZE] > 5000000) {
            $uploadOk = ERROR;
        }
        //controllo l'estensione del file
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $uploadOk = ERROR;
        }
        $hash = hash('sha256', basename($photo[PICTURE_NAME]) . time());
        $target_file = $target_dir . $hash . "." . $imageFileType;
        if ($uploadOk == 1) {
            if (move_uploaded_file($photo[PICTURE_TMP_NAME], $target_file)) {
                $os = $this->getOS();
                if ($os == OS_WIN) {
                    exec('icacls "' . $target_file . '" /q /c /reset');
                } else if ($os == OS_LINUX || $os == OS_OSX) {
                    chmod($target_file, 0777);
                } else {
                    echo ERR_OS;
                    exit;
                }
                $insertPhoto = "INSERT INTO photo (path) VALUES (%s)";
                $this->connection->query($insertPhoto, $target_file);
                echo SUCCESSFUL;
            } else {
                echo ERR_IMP;
            }
        } else {
            echo ERROR;
        }
    }

    /**
     * Metodo per sapere quale sistema operativo sta girando il servizio di php
     * @return mixed Il sistema operativo
     */
    public function getOS()
    {
        if (stristr(PHP_OS, 'DAR')) {
            return OS_OSX;
        } else if (stristr(PHP_OS, 'WIN')) {
            return OS_WIN;
        } else if (stristr(PHP_OS, 'LINUX')) {
            return OS_LINUX;
        } else {
            return OS_UNKNOWN;
        }
    }

    /**
     * Metodo per salvare il testo della descrizione.
     * @param $text Il testo da salvare.
     */
    public function saveDescription($text)
    {
        file_put_contents($this->pathDescription, $text);
    }

    /**
     * Metodo per leggere la descrizione.
     * @return bool|false|string False se non è possibile legger il file altrimenti il contenuto del file
     */
    public function getDescription()
    {
        if (file_exists($this->pathDescription)) {
            return file_get_contents($this->pathDescription);
        } else {
            return false;
        }
    }

    /**
     * Metodo per salvare il testo dei contatti.
     * @param $text Il testo da salvare.
     */
    public function saveContact($text)
    {
        file_put_contents($this->pathContact, $text);
    }

    /**
     * Metodo per leggere i contatti.
     * @return bool|false|string False se non è possibile legger il file altrimenti il contenuto del file
     */
    public function getContact()
    {
        if (file_exists($this->pathContact)) {
            return file_get_contents($this->pathContact);
        } else {
            return false;
        }
    }

    /**
     * Metodo per ricavare tutte le impostazioni del sito.
     * @return array Tutte le impostazioni.
     */
    public function getSettings()
    {
        $selectSettings = "SELECT * FROM settings";
        $settings = $this->connection->query($selectSettings);
        return $settings;
    }

    /**
     * Metodo per ricavare tutti gli utenti del sito.
     * @return array Tutti gli utenti.
     */
    public function getAllUsers()
    {
        $selectUsers = "SELECT * FROM user WHERE type <> 0";
        $users = $this->connection->query($selectUsers);
        return $users;
    }

    /**
     * Metodo per modificare i dati di pagamento.
     * @param $iban Il numero iban.
     * @param $bank Il nome della banca.
     * @param $beneficiary Il nome e congnome del beneficiario.
     */
    public function modifyPayment($iban, $bank, $beneficiary)
    {
        $data = array();
        $checkIBAN = $checkBank = $checkBeneficiary = $checkAll = SUCCESSFUL;
        if (!$this->validator->checkIBAN($iban)) {
            $checkIBAN = ERROR;
            $checkAll = ERROR;
        }
        if (!$this->validator->checkNameNumber($bank)) {
            $checkBank = ERROR;
            $checkAll = ERROR;
        }
        if (!$this->validator->checkName($beneficiary)) {
            $checkBeneficiary = ERROR;
            $checkAll = ERROR;
        }
        if ($checkAll == SUCCESSFUL) {
            $updateSettings = "UPDATE settings SET iban_number=%s, bank=%s, beneficiary=%s";
            $this->connection->query($updateSettings, $iban, $bank, $beneficiary, $iban);
        }
        $data[] = array(
            SATUTS => $checkAll,
            CHECK_IBAN => $checkIBAN,
            CHECK_BANK => $checkBank,
            CHECK_BENEFICIARY => $checkBeneficiary
        );
        echo json_encode($data);
    }

    /**
     * Metodo per modificare i giorni di scadenza.
     * @param $deadline I giorni di scadenza
     */
    public function modifyDeadline($deadline)
    {
        if ($this->validator->checkDayDeadline($deadline)) {
            $updateSettings = "UPDATE settings SET day_deadline=%i";
            $this->connection->query($updateSettings, $deadline);
            echo SUCCESSFUL;
        } else {
            echo ERROR;
        }
    }

    /**
     * Metodo per modificare gli anni minimi per iscriversi ad un corso.
     * @param $minAge Gli anni minimi.
     */
    public function modifyMinAge($minAge)
    {
        if ($this->validator->checkMinAge($minAge)) {
            $updateSettings = "UPDATE settings SET min_age=%i";
            $this->connection->query($updateSettings, $minAge);
            echo SUCCESSFUL;
        } else {
            echo ERROR;
        }
    }

    /**
     * Metodo per ricevere la tabella html con i dati.
     */
    public function getTypologyRowTable()
    {
        $html = "";
        $selectTypologies = "SELECT * FROM typology";
        $typologies = $this->connection->query($selectTypologies);
        foreach ($typologies as $t) {
            $html .= "<tr>
                        <td>" . $t["name"] . "</td>
                        <td>
                            <button style='width: 130px' type='button'
                                class='btn btn-danger btn-fix-panel-control'
                                data-toggle='modal'
                                data-target='#deleteTypologyModal'
                                onclick='setInfoTypology(\"" . $t["name"] . "\")'>Elimina <i class='fa fa-trash'></i>
                        </td>
                      </tr>";
        }
        echo $html;
    }

    /**
     * Metodo per aggiugere una tipologia.
     * @param $typology La tipologia da aggiungere.
     */
    function addTypology($typology)
    {
        if ($this->validator->checkNameNumber($typology)) {
            $selectTypology = "SELECT * FROM typology WHERE name=%s";
            $typologies = $this->connection->query($selectTypology, $typology);
            if (count($typologies) == 0) {
                $insertTypology = "INSERT INTO typology (name) VALUES (%s)";
                $this->connection->query($insertTypology, $typology);
                echo SUCCESSFUL;
            } else {
                echo ERR_DUP;
            }
        } else {
            echo ERROR;
        }
    }

    /**
     * Metodo per eliminare una tipologia.
     * @param $name Il nome della tipologia da eliminare.
     */
    public function delTypology($name)
    {
        $selectTypology = "SELECT * FROM typology WHERE name=%s";
        $typologies = $this->connection->query($selectTypology, $name);
        if (count($typologies) > 0) {
            $deleteTypology = "DELETE FROM typology WHERE name=%s";
            $this->connection->query($deleteTypology, $name);
            echo SUCCESSFUL;
        } else {
            echo ERROR;
        }
    }

    /**
     * Metodo per inviare le email della neswletter.
     * @param $files La lista dei file.
     * @param $text Il testo della email.
     */
    public function sendNewsMail($files, $text)
    {
        require 'application/libs/sendMail.php';
        $body = $text;
        try {
            $selectEmail = "SELECT email FROM user WHERE flag_newsletter=1";
            $emails = $this->connection->query($selectEmail);
            $s = new SendMail();
            for ($i = 0; $i < count($files); $i++) {
                try {
                    $s->addFile($files["files" . $i][FILE_TMP_NAME], $files["files" . $i][FILE_NAME]);
                } catch (Exception $e) {
                    Util::fail();
                }
            }
            try {
                $es = array();
                for ($i = 0; count($emails) > $i; $i++){
                    $es[$i] = $emails[$i][DB_USER_EMAIL];
                }
                $s->mailSendList($es, "News", $body);
            } catch (Exception $e) {
            }
        } catch (Exception $e) {
        }
        echo SUCCESSFUL;
    }

}