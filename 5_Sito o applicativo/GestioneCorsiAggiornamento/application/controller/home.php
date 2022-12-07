<?php

/**
 * Class Home Controller della pagina home.
 */
class Home
{

    /**
     * Metodo per la visualizzazione della pagina home.
     */
    public function index()
    {
        require_once 'application/models/homeModel.php';
        $hm = new HomeModel();
        $pictures = $hm->getAllPathHomePicture();
        $text = $hm->getText();
        if ($text == false) {
            $text = "";
        }

        require 'application/views/_template/header.php';
        require 'application/views/home.php';
        require 'application/views/_template/footer.php';
    }


}