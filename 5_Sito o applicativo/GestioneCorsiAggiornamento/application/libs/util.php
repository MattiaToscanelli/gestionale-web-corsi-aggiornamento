<?php

/**
 * Classe che mi permette di convalidare i dati passati da form.
 */
class Util
{

    /**
     * Metodo per rendere "pulito" un input.
     * @param $data Il dato da revisionare.
     * @return string Il dato revisionato.
     */
    public static function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * Metodo per ritornare al client che qualcosa è andato storto.
     */
    public static function fail()
    {
        echo ERROR;
        header("Location: " . URL . "err");
        exit;
    }
}