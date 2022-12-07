<?php

/**
 * Class AdminPanel Controller per la pagina d'amministrazione.
 */
class AdminPanel
{

    /**
     * Metodo per la visualizzazione della pagina di amministrazione.
     */
    public function index()
    {
        MSession::checkAdmin();
        require_once 'application/models/adminPanelModel.php';
        $apm = new AdminPanelModel();
        $photos = $apm->getAllPhotos();
        $settings = $apm->getSettings();
        $users = $apm->getAllUsers();
        $text = $apm->getDescription();
        if ($text == false) {
            $text = "";
        }
        $contact = $apm->getContact();
        if ($text == false) {
            $contact = "";
        }

        require 'application/views/_template/header.php';
        require 'application/views/management/adminPanel.php';
        require 'application/views/_template/footer.php';
    }

    /**
     * Metodo per eliminare una foto.
     */
    public function deletePhoto()
    {
        MSession::checkAdmin();
        require_once 'application/models/adminPanelModel.php';
        $apm = new AdminPanelModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[PATH])) {
                Util::fail();
            }
            $apm->delPhoto(Util::test_input($_POST[PATH]));
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per aggiungere una foto.
     */
    public function addPhoto()
    {
        MSession::checkAdmin();
        require_once 'application/models/adminPanelModel.php';
        $apm = new AdminPanelModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_FILES[PICTURE])) {
                Util::fail();
            }
            $photo = $_FILES[PICTURE];
            $apm->addPhoto($photo);
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per modifica la descrizione della pagina principale.
     */
    public function saveDescription()
    {
        MSession::checkAdmin();
        require_once 'application/models/adminPanelModel.php';
        $apm = new AdminPanelModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[DESCRIPTION])) {
                Util::fail();
            }
            $text = $_POST[DESCRIPTION];
            $apm->saveDescription($text);
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per modifica il testo della pagina di contatti.
     */
    public function saveContact()
    {
        MSession::checkAdmin();
        require_once 'application/models/adminPanelModel.php';
        $apm = new AdminPanelModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[DESCRIPTION])) {
                Util::fail();
            }
            $text = $_POST[DESCRIPTION];
            $apm->saveContact($text);
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per modificare i dati di pagamento
     */
    public function modifyPayment()
    {
        MSession::checkAdmin();
        require_once 'application/models/adminPanelModel.php';
        $apm = new AdminPanelModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[IBAN], $_POST[BANK], $_POST[BENEFICIARY])) {
                Util::fail();
            }
            $iban = Util::test_input($_POST[IBAN]);
            $bank = Util::test_input($_POST[BANK]);
            $beneficiary = Util::test_input($_POST[BENEFICIARY]);
            $apm->modifyPayment($iban, $bank, $beneficiary);
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per modificare i giorni di scadenza.
     */
    public function modifyDeadline()
    {
        MSession::checkAdmin();
        require_once 'application/models/adminPanelModel.php';
        $apm = new AdminPanelModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[DEADLINE])) {
                Util::fail();
            }
            $deadline = Util::test_input($_POST[DEADLINE]);
            $apm->modifyDeadline($deadline);
        } else {
            header("Location: " . URL . "err");
        }
    }


    /**
     * Metodo per modificare i giorni di scadenza.
     */
    public function modifyMinAge()
    {
        MSession::checkAdmin();
        require_once 'application/models/adminPanelModel.php';
        $apm = new AdminPanelModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[MIN_AGE])) {
                Util::fail();
            }
            $minAge = Util::test_input($_POST[MIN_AGE]);
            $apm->modifyMinAge($minAge);
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per ricavare le riche della tabella tipologia.
     */
    public function getTypologyRowTable()
    {
        MSession::checkAdmin();
        require_once 'application/models/adminPanelModel.php';
        $apm = new AdminPanelModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $apm->getTypologyRowTable();
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per aggiungere una tipologia.
     */
    public function addTypology()
    {
        MSession::checkAdmin();
        require_once 'application/models/adminPanelModel.php';
        $apm = new AdminPanelModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[TYPOLOGY])) {
                Util::fail();
            }
            $typology = Util::test_input($_POST[TYPOLOGY]);
            $apm->addTypology($typology);
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per eliminare una tipologia.
     */
    public function deleteTypology()
    {
        MSession::checkAdmin();
        require_once 'application/models/adminPanelModel.php';
        $apm = new AdminPanelModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[TYPOLOGY])) {
                Util::fail();
            }
            $apm->delTypology(Util::test_input($_POST[TYPOLOGY]));
        } else {
            header("Location: " . URL . "err");
        }
    }

    /**
     * Metodo per inviare le email della newsletter.
     */
    public function sendNewsMail()
    {
        MSession::checkAdmin();
        require_once 'application/models/adminPanelModel.php';
        $apm = new AdminPanelModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST[TEXT])) {
                Util::fail();
            }
            $text = $_POST[TEXT];
            $apm->sendNewsMail($_FILES, $text);
        } else {
            header("Location: " . URL . "err");
        }
    }
}