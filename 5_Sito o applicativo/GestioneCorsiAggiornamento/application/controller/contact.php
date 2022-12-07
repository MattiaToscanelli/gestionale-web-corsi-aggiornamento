<?php

/**
 * Class Contact Controller della pagina dei contatti.
 */
class Contact
{

    /**
     * Metodo per la visualizzazione della pagina dei contatti.
     */
    public function index()
    {
        require_once 'application/models/contactModel.php';
        $cm = new ContactModel();
        $contact = $cm->getText();
        if ($contact == false) {
            $contact = "";
        }

        require 'application/views/_template/header.php';
        require 'application/views/contact.php';
        require 'application/views/_template/footer.php';
    }


}