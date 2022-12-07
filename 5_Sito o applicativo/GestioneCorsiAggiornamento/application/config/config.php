<?php

/**
 * Configurazione
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 */

/**
 * Configurazione di : Error reporting
 * Utile per vedere tutti i piccoli problemi in fase di sviluppo, in produzione solo quelli gravi
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Configurazione di : URL del progetto
 */
define('URL', 'http://localhost/gestione-web-corsi-aggiornamento/5_Sito%20o%20applicativo/GestioneCorsiAggiornamento/');

/**
 * Costate per l'accesso per il database.
 */
define('DB_HOST', 'localhost');
define('DB_USER', 'courses_management_admin');
define('DB_PASS', 'CoursesManagement&1');
define('DB_NAME', 'courses_management');

/**
 * Costanti captcha google
 */
define('SECRET_KEY',"6Lfyo_sUAAAAAPE5kuGuU1PCvqgfnADUZVt3a_Kc");
define('WEBSITE_KEY',"6Lfyo_sUAAAAACnSGyCxQHDClkm54dVcKy6n-lpN");

/**
 * Costanti di configurazione per la posta elettronica.
 */
define('EMAIL_EMAIL', 'gestionecorsiaggiornamento@gmail.com');
define('PASSWORD_MAIL', 'ProgettoLIP');
define('SMTP','smtp.gmail.com');
define('PORT',587);
define('SMTP_SECURE','tls');
define('CHAR_SET','UTF-8');

/**
 * Costanti per accedere ai dati del database di un utente.
 */
define('DB_USER_PASSWORD', 'password');
define('DB_USER_TYPE', 'type');
define('DB_USER_FIRSTNAME', 'firstname');
define('DB_USER_LASTNAME', 'lastname');
define('DB_USER_EMAIL', 'email');
define('DB_USER_ID', 'id');
define('DB_USER_BIRTHDAY', 'birthday');
define('DB_USER_ZIP', 'zip');
define('DB_USER_CITY', 'city');
define('DB_USER_STREET', 'street');
define('DB_USER_MOBILE_NUMBER', 'mobile_number');
define('DB_USER_LANDLINE_NUMBER', 'landline_number');
define('DB_USER_NEWSLETTER', 'flag_newsletter');
define('DB_USER_TOKEN', 'token');
define('DB_USER_NIP', 'nip');
define('DB_USER_LICENSE_NUMBER', 'license_number');

/**
 * Constante per accedere ai dati del database di una foto.
 */
define('DB_PATH_PHOTO', 'path');

/**
 * Risposte server
 */
define("ERROR", 0);
define("LOGIN_DENY", 0);
define("SUCCESSFUL", 1);
define("ERR_DUP", 2);
define("ERR_IMP", 0);
define("ERR_OS", 2);
define("ERR_DATE", 2);

/**
 * Costanti per il login.
 */
define('EMAIL', 'email');
define('PASSWORD', 'password');
define('RE_PASSWORD', 're_password');

/**
 * Costanti per accedere velocemente ai dati dell'utente.
 */
define('SESSION_CHANGE_PASSWORD', 'change_password');
define('SESSION_EMAIL', 'email_login');
define('SESSION_TYPE', 'tipo');

/**
 * Costanti per pannello admin.
 */
define('PATH', 'path');
define('PICTURE', 'file');
define('FILES', 'files');
define('TEXT', 'text');
define("PICTURE_TMP_NAME", "tmp_name");
define("PICTURE_NAME", "name");
define("PICTURE_SIZE", "size");
define("FILE_NAME", "name");
define("FILE_SIZE", "size");
define("FILE_TMP_NAME", "tmp_name");
define("DESCRIPTION", "text");
define('TYPOLOGY', 'typology');
define("IBAN", "iban");
define("BANK", "bank");
define("BENEFICIARY", "beneficiary");
define("DEADLINE", "day_deadline");
define("DB_IBAN", "iban_number");
define("DB_BANK", "bank");
define("DB_BENEFICIARY", "beneficiary");
define("DB_DEADLINE", "day_deadline");
define("DB_MIN_AGE", "min_age");
define("SATUTS", "status");
define("CHECK_IBAN", "c_iban");
define("CHECK_BANK", "c_bank");
define("CHECK_BENEFICIARY", "c_beneficiary");
define("MIN_AGE", "min_age");
define("TYPE_USER",1);
define("TYPE_TEACHER",2);
define("TYPE_ADMIN",3);

/**
 * Costanti per i sistemi operativi.
 */
define('OS_OSX', 1);
define('OS_WIN', 2);
define('OS_LINUX', 3);
define('OS_UNKNOWN', 4);

/**
 * Costanti per la gestione dei corsi.
 */
define("TITLE", "title");
define("STREET", "street");
define("ZIP", "zip");
define("CITY", "city");
define("MAX_PARTECIPANTS", "max_partecipants");
define("COURSE_PRICE", "course_price");
define("MEAL_PRICE", "meal_price");
define("COURSE_DESCRIPTION", "description");
define("MATERIALS", "materials");
define("CHECK_TITLE", "c_title");
define("CHECK_STREET", "c_street");
define("CHECK_ZIP", "c_zip");
define("CHECK_CITY", "c_city");
define("CHECK_MAX_PARTECIPANTS", "c_max_partecipants");
define("CHECK_COURSE_PRICE", "c_course_price");
define("CHECK_MEAL_PRICE", "c_meal_price");
define("CHECK_COURSE_DESCRIPTION", "c_description");
define("CHECK_MATERIALS", "c_materials");
define("CHECK_TYPOLOGY", "c_typology");
define("ID_MODIFY_COURSE", "id_course");
define("NAME_TYPOLOGY", "name");
define("COURSE_ID", "id");
define("ID_COURSE", "id_course");

/**
 * Costanti per la gestione degli svolgimenti.
 */
define("START_DAY_LESSON", "start_day_lesson");
define("DURATION_DAY", "duration_day");
define("TEACHER", "teacher");
define("TIMES", "times");
define("DB_EXECUTION_END", "end");
define("DB_EXECUTION_START", "start");
define("CHECK_START_DAY", "c_start_day");
define("CHECK_OVERLAP", "c_overlap");
define("CHECK_DURATION", "c_duration");
define("CHECK_TEACHER", "c_teacher");
define("CHECK_TIMES", "c_times");
define("MEMBER", "member");
define("START_LESSON", "start");
define("END_LESSON", "end");
define("DATE_EXECUTION", "date");
define('DB_EXECUTION_ID', 'id');
define('FIRSTNAME', 'firstname');
define('LASTNAME', 'lastname');
define('BIRTHDAY', 'birthday');
define('MOBILE_NUMBER', 'mobile_number');
define('LANDLINE_NUMBER', 'landline_number');
define('NIP', 'nip');
define('LICENSE_NUMBER', 'license_number');
define('LOGGED', 'logged');
define('SAVE', 'save');
define('FOOD', 'food');
define('INCLUDE_FOOD', 'inclu_food');
define('FOOD_TYPE', 'food_type');
define('INTOLERANCES', 'intolerances');
define('ID_EXECUTION', 'id');
define('EXECUTION_ID', 'id_execution');
define('EXECUTION_ID_USER', 'id_user');
define('USER', 'user');
define('NEWSLETTER', 'newsletter');
define("CHECK_FIRSTNAME", "c_firstname");
define("CHECK_LASTNAME", "c_lastname");
define("CHECK_BIRTHDAY", "c_birthday");
define("CHECK_MOBILE_NUMBER", "c_mobile_number");
define("CHECK_LANDLINE_NUMBER", "c_landline_number");
define("CHECK_NIP", "c_nip");
define("CHECK_LICENSE_NUMBER", "c_license_number");
define("CHECK_FOOD_TYPE", "c_food_type");
define("CHECK_INTOLERANCES", "c_intolerances");
define("CHECK_PASSWORD", "c_password");
define("CHECK_EMAIL", "c_email");
define("CHECK_EXECUTION_FULL", "c_execution_full");
define("CAPTCHA_V2", "g-recaptcha");
define("CHECK_CAPTCHA", "c_captcha");
define("ID_MANAGE_EXECUTION","id_execution");
define("DB_FLAG_MEAL", "flag_meal");
define("DB_MEAL_TYPOLOGY", "food_type");
define("DB_FLAG_PAID","flag_paid");
define("DB_INTOLERANCES","intolerances");
define("DB_ENROLL_ID","id");
define("ENROLL_ID","id");
define("DB_ID_COURSE","id_course");
define("DB_ID_USER","id_user");
define("FLAG_PAID","flag_paid");

/**
 * Costanti per accedere ai dati del database di un corso.
 */
define('DB_COURSE_ID', 'id');
define('DB_COURSE_TITLE', 'title');
define('DB_COURSE_DESCRIPTION', 'description');
define('DB_COURSE_ZIP', 'zip');
define('DB_COURSE_CITY', 'city');
define('DB_COURSE_STREET', 'street');
define('DB_COURSE_MAX_PARTECIPANTS', 'max_partecipants');
define('DB_COURSE_MATERIALS', 'materials');
define('DB_COURSE_MEAL_PRICE', 'meal_price');
define('DB_COURSE_COURSE_PRICE', 'course_price');
define('DB_COURSE_TYPOLOGY', 'name_typology');

