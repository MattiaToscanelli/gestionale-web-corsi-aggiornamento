<?php

/**
 * Classe utile per la Validazione dei dati.
 */
class Validator
{

    /**
     * @var Database Connessione per il database.
     */
    private $connection;


    /**
     * Metodo costrruttore con un parametro, instazia le variabile $connection.
     * @param $connection La connessione al database.
     */
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /**
     * Metodo per verificare se due password sono uguali e rispetta i criteri di sicurezza.
     * @param $val1 La prima password.
     * @param $val2 La password ripetuta.
     * @return bool True se le password sono uguali e rispettano i criteri di sicurezza, False se non sono uguali o
     * non rispettano i criteri.
     */
    function checkPassword($val1, $val2)
    {
        $regexLetter = '/[a-zA-Z]/';
        $regexDigit = '/\d/';
        $regexSpecial = '/[^a-zA-Z\d]/';
        return (preg_match($regexDigit, $val1) || preg_match($regexSpecial, $val1)) &&
            preg_match($regexLetter, $val1) && strlen($val1) >= 8 &&
            $val1 == $val2;
    }

    /**
     * Metodo per controllare un nome contentente numeri.
     * @param $val Il nome da controllare.
     * @return bool True se è valido, False se non è valido.
     */
    function checkNameNumber($val)
    {
        return (preg_match('/^[0-9()a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]{2}[0-9()a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.\'-]+$/', $val) && count($val) <= 50);
    }

    /**
     * Metodo per verificare un iban.
     * @param $iban L'iban da verificare.
     * @return bool True se è valido, False se non è valido.
     */
    function checkIBAN($iban)
    {
        $iban = strtoupper(str_replace(' ', '', $iban));

        if (preg_match('/^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$/', $iban)) {
            $country = substr($iban, 0, 2);
            $check = intval(substr($iban, 2, 2));
            $account = substr($iban, 4);

            $search = range('A', 'Z');
            foreach (range(10, 35) as $tmp)
                $replace[] = strval($tmp);
            $numstr = str_replace($search, $replace, $account . $country . '00');

            $checksum = intval(substr($numstr, 0, 1));
            for ($pos = 1; $pos < strlen($numstr); $pos++) {
                $checksum *= 10;
                $checksum += intval(substr($numstr, $pos, 1));
                $checksum %= 97;
            }

            return ((98 - $checksum) == $check);
        } else
            return false;
    }

    /**
     * Metodo per verificare un nome.
     * @param $val Il nome da verificare.
     * @return bool True se il nome è valido, False non è valido.
     */
    function checkName($val)
    {
        return (preg_match('/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]{2}[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.\'-]+$/', $val) && count($val) <= 50);
    }

    /**
     * Metodo per verificare i giorni di scadenza.
     * @param $val I giorni di scadenza.
     * @return bool True se i giorni inseriti sono validi, False se non sono validi.
     */
    function checkDayDeadline($val)
    {
        return is_numeric($val) && $val >= 0;
    }

    /**
     * Metodo per verificare gli anni minimi per iscriversi ad un corso.
     * @param $val Gli anni da verificare.
     * @return bool True se gli anni inseriti sono validi, False se non sono validi.
     */
    function checkMinAge($val)
    {
        return is_numeric($val) && $val >= 0;
    }

    /**
     * Metodo per controllare il titolo di un corso.
     * @param $val Il titolo da controllare.
     * @return bool True se è valido, False se non è valido.
     */
    function checkTitle($val)
    {
        return (preg_match('/^[0-9a-zA-Z!?()%*+^$£àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]{2}[0-9a-zA-Z!?()%*+^$£àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.\'-]+$/', $val) && count($val) <= 100);
    }

    /**
     * Metodo per verificare una textarea
     * @param $val La via da verificare.
     * @return bool True se la via è valida, False non è valida.
     */
    function checkTextArea($val)
    {
        return (preg_match('/^[\r\n0-9a-zA-Z!?()%*+^$£àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.\'-]+$/', $val)) && strlen($val) > 2;
    }

    /**
     * Metodo per verificare se il cap è valido.
     * @param $val Il cap da verificare.
     * @return false|int True se il cap è valido, False se non è valdio.
     */
    function checkZip($val)
    {
        $val = str_replace(" ", "", $val);
        return preg_match('/^[0-9]{4}$/', $val);
    }

    /**
     * Metodo per verificare una via.
     * @param $val La via da verificare.
     * @return bool True se la via è valida, False non è valida.
     */
    function checkStreet($val)
    {
        return (preg_match('/^[0-9a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]{2}[0-9a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.\'-]+$/', $val) && count($val) <= 50);
    }

    /**
     * Metodo per controllare il numero massimo di partecipanti.
     * @param val $ Il numero di partecipanti da controllare.
     * @return bool True se è valido, False se non è valido.
     */
    function checkPartecipants($val)
    {
        return is_numeric($val) && $val > 0 && $val <= 999;
    }

    /**
     * Metodo per controllare il prezzo di un pasto.
     * @param val $ Il prezzo da controllare.
     * @return bool True se è valido, False se non è valido.
     */
    function checkMealPrice($val)
    {
        return is_numeric($val) && $val >= 0 && $val <= 999;
    }

    /**
     * Metodo per controllare il prezzo di un pasto.
     * @param val $ Il prezzo da controllare.
     * @return bool True se è valido, False se non è valido.
     */
    function checkCoursePrice($val)
    {
        return is_numeric($val) && $val > 0 && $val <= 999;
    }

    /**
     * Metodo per controllare se una tipologia esiste.
     * @param val $ La tipologia da controllare.
     * @return bool True se è valido, False se non è valido.
     */
    function checkTypology($val)
    {
        $query = "SELECT * FROM typology WHERE name=%s";
        $result = $this->connection->query($query, $val);
        return count($result) > 0;
    }

    /**
     * Metodo per controllare se l'utente esiste ed è un docente o amministratore.
     * @param val $ L'utente da controllare.
     * @return bool True se è valido, False se non è valido.
     */
    function checkTeacher($val)
    {
        $query = "SELECT * FROM user WHERE id=%i and type>1";
        $result = $this->connection->query($query, $val);
        return count($result) > 0;
    }

    /**
     * Metodo per controllare il numero di giorni di uno svolgimento.
     * @param val $ Il numero di giorni da controllare da controllare.
     * @return bool True se è valido, False se non è valido.
     */
    function checkDuration($val)
    {
        return is_numeric($val) && $val > 0 && $val <= 5;
    }

    /**
     * Metodo per controllare gli orari delle lezioni di uno svolgimento.
     * @param $val Gli orari da controllare.
     * @return bool True se sono validi, False se non sono validi.
     */
    function checkTimes($val)
    {
        $check = 1;
        $times = explode(",", $val);
        if (count($times) % 2 == 0 && count($times) > 1 && count($times) < 11) {
            for ($i = 0; $i < count($times); $i += 2) {
                $t1 = explode(":", $times[$i]);
                $t2 = explode(":", $times[$i + 1]);
                if (count($t1) > 1 && count($t2) > 1) {
                    if ((strtotime($times[$i]) > strtotime($times[$i + 1])) || !($this->checkFormatTime($t1[0], $t1[1])) || !($this->checkFormatTime($t2[0], $t2[1]))) {
                        $check = false;
                    }
                } else {
                    $check = false;
                }
            }
        }
        return $check;
    }

    /**
     * Metodo per verificare la formattazione di un orario.
     * @param $hour Le ore.
     * @param $min I minuti.
     * @return bool True se l'orario é valido, False se non è valido.
     */
    function checkFormatTime($hour, $min)
    {
        if ($hour < 0 || $hour > 23 || !is_numeric($hour)) {
            return false;
        }
        if ($min < 0 || $min > 59 || !is_numeric($min)) {
            return false;
        }
        return true;
    }

    /**
     * Metodo per controllare l'overlap tra gli svolgimenti dei corsi.
     * @param $start La data della prima lezione.
     * @param $end La data del'ultima lezione.
     * @param $idU L'id dell'utente.
     * @return bool True se c'è l'overlap, False se non c'è l'overlap.
     */
    public function checkOverlapTeacher($start, $end, $idU)
    {
        $dStart = strtotime($start);
        $dEnd = strtotime($end);
        $selectDays = "SELECT start, end FROM execution WHERE id_user=%i";
        $days = $this->connection->query($selectDays, $idU);
        $check = 0;
        foreach ($days as $row) {
            $xstart = strtotime($row[DB_EXECUTION_START]);
            $xend = strtotime($row[DB_EXECUTION_END]);
            if (!(($dStart > $xend) || ($dEnd < $xstart))) {
                $check++;
            }
        }
        return $check != 0;
    }

    /**
     * Metodo per controllare la data di nascita.
     * @param $date La data di nascita.
     * @return bool True se è valida, False se non è valida
     */
    function checkBirthday($date)
    {
        $selectMinAge = "SELECT min_age FROM settings";
        $minAge = $this->connection->query($selectMinAge)[0][DB_MIN_AGE];
        $minAge = strtotime("-$minAge YEAR");
        $age = strtotime($date);
        return $age < $minAge;
    }

    /**
     * Metodo per verificare se un numero di telefono è valido.
     * @param $val Il numero da verificare.
     * @return false|int True se il numero è valido, False se non è valdio.
     */
    function checkPhoneNumber($val)
    {
        $val = str_replace(" ", "", $val);
        $val = str_replace("-", "", $val);
        return preg_match('/^[\+]?[0-9-#]{10,14}$/', $val);
    }

    /**
     * Metodo per verificare se il numero di licenza è valido.
     * @param $val Il numero di licenza da verificare.
     * @return false|int True se il numero di licenza valido, False se non è valdio.
     */
    function checkLicenseNumber($val)
    {
        $val = str_replace(" ", "", $val);
        return preg_match('/^[0-9]{12}$/', $val);
    }

    /**
     * Metodo per verificare se il nip è valido.
     * @param $val Il nip da verificare.
     * @return false|int True se il nip è valido, False se non è valdio.
     */
    function checkNip($val)
    {
        $val = str_replace(" ", "", $val);
        return preg_match('/^[0-9]{9}$/', $val);
    }

    /**
     * Metodo per verificare se una email è valida.
     * @param $val La email da verificare.
     * @return bool True se la email è valida, False se non è valida.
     */
    function checkEmail($val)
    {
        return preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $val) && $this->checkEmailExists($val);
    }

    /**
     * Metodo per verificare se una email esiste già nel database.
     * @param $val La email da verificare.
     * @return bool True se la email esiste, False se non esiste.
     */
    function checkEmailExists($val)
    {
        $selectUsers = "SELECT id FROM user WHERE email=%s AND type<>0";
        $users = $this->connection->query($selectUsers, $val);
        return count($users) == 0;
    }

    /**
     * Metodo per verificae il tipo di cibo.
     * @param $val Il cibo da verificare.
     * @return bool True se il cibo è valido, False se non è valido.
     */
    function checkFoodType($val)
    {
        return $val == "Nessuna Preferenza" || $val == "Vegetariano" || $val == "Vegano" || $val == "Fruttariano";
    }

    /**
     * Metodo per controllare  se un utente si è gia iscritto al corso.
     * @param $emailU La data della prima lezione.
     * @param $idExecution La data del'ultima lezione.
     * @return bool True se c'è l'overlap, False se non c'è l'overlap.
     */
    public function checkOverlapExecution($emailU, $idExecution)
    {
        $selectIdUser = "SELECT id FROM user WHERE email=%s";
        $idUser = $this->connection->query($selectIdUser, $emailU);
        if (count($idUser) > 0) {
            $selectEnroll = "SELECT id FROM enrolls WHERE id_user=%i AND id_execution=$idExecution";
            $result = $this->connection->query($selectEnroll, $idUser[0][DB_USER_ID]);
            return count($result) != 0;
        } else {
            return false;
        }
    }

}