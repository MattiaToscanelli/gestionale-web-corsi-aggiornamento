<title>Iscriviti</title>
</head>
<body class="body-bg">
<!--[if lt IE 8]>
<p class="browserupgrade">Stai utilizzando una versione di browser obsoleta. Per favore <a
        href="http://browsehappy.com/">esegui l'upgrade del browser</a> per aumentare la tua esperienza di navigazione.
</p>
<![endif]-->
<!-- preloader area start -->
<div id="preloader">
    <div class="loader"></div>
</div>
<!-- preloader area end -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo URL; ?>">
        Corsi Aggiornamento
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URL; ?>">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URL . 'contact' ?>">Contatti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo URL . 'researchCourses' ?>">Ricerca Corsi<span
                            class="sr-only">(current)</span></a>
            </li>
            <?php if (isset($_SESSION[SESSION_TYPE])): ?>
                <?php if ($_SESSION[SESSION_TYPE] >= TYPE_ADMIN): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL . 'adminPanel'; ?>">Pannello Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL . 'managementCourses'; ?>">Gestioni corsi</a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <li class="nav-item">
                <?php if (!isset($_SESSION[SESSION_EMAIL])): ?>
                    <a class="nav-link" href="<?php echo URL . 'login' ?>">Login</a>
                <?php else: ?>
                    <a class="nav-link" href="<?php echo URL . 'profile' ?>">Profilo</a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</nav>
<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-9 m-auto">
            <div class="row">
                <div class="col-12" style="margin-top: 100px">
                    <div class="card">
                        <div class="card-body col-md-9 col-sm-12" style="margin: auto">
                            <h2 class="mb-5 text-center"><?php echo $course[DB_COURSE_TITLE]; ?></h2>
                            <div class="row">
                                <div class="col-sm-6 mb-4">
                                    <h4 class="mb-2">Informazioni</h4>
                                    <p><strong>Tipologia: </strong><?php echo $course[DB_COURSE_TYPOLOGY]; ?></p>
                                    <p><strong>Descrizione: </strong><br><?php echo $course[DB_COURSE_DESCRIPTION]; ?>
                                    </p>
                                    <p><strong>Materiale necessario:
                                            <br></strong><?php echo ($course[DB_COURSE_MATERIALS] == "") ? " - " : $course[DB_COURSE_MATERIALS]; ?>
                                    </p>
                                </div>
                                <div class="col-sm-6 mb-4">
                                    <h4 class="mb-2">Dove</h4>
                                    <p><strong>Città: </strong><?php echo $course[DB_COURSE_CITY]; ?></p>
                                    <p><strong>CAP: </strong><?php echo $course[DB_COURSE_ZIP]; ?></p>
                                    <p><strong>Via: </strong><?php echo $course[DB_COURSE_STREET]; ?></p>
                                </div>
                                <div class="col-sm-6 mb-4">
                                    <h4 class="mb-2">Costi</h4>
                                    <p><strong>Prezzo corso: </strong><?php echo $course[DB_COURSE_COURSE_PRICE]; ?>.-
                                    </p>
                                    <?php if ($course[DB_COURSE_MEAL_PRICE] > 0): ?>
                                        <p><strong>Prezzo pasto
                                                (opzionale): </strong><?php echo $course[DB_COURSE_MEAL_PRICE]; ?>.-</p>
                                    <?php endif; ?>
                                    <p>(Dati di pagamento vengono inviati per e-mail dopo aver effettuato
                                        l'iscrizione)</p>
                                </div>
                            </div>
                            <div class="no-print">
                                <div class="row pt--50">
                                    <div class="col-12 pb--10">
                                        <div class="input-group">
                                            <a class="btn btn-info btn-lg btn-block" href="javascript:printCourse()"
                                               style="color: white">Scarica Corso
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <?php if (count($execution) > 0): ?>
                                <?php if (!isset($_SESSION[SESSION_EMAIL])): ?>
                                    <div class="no-print">
                                        <h4 class="mb-2 pt--50">Login</h4>
                                        <span>Esegui il login per compilare il form con i dati utilizzati in una vecchia iscrizione.</span>
                                        <div id="alert_validation_login" class="alert alert-danger mt-2" role="alert"
                                             style="display: none">
                                            Email o password errati!
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control login">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control login">
                                                    <div class="form-gp pt--10">
                                                        <a href="<?php echo URL . 'forgotPassword'; ?>">Password
                                                            dimenticata?</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <button class="btn btn-info btn-lg btn-block"
                                                            onclick="login()">Accedi
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                <?php endif; ?>
                                <div class="no-print">
                                    <div class="row pt--50">
                                        <div class="col-md-6 col-sm-12 mb-4">
                                            <h4 class="mb-2">Date</h4>
                                            <label class="mb-1 mr-3">Segli la data <i class="fa fa-info-circle"
                                                                                      data-container="body"
                                                                                      data-toggle="popover"
                                                                                      data-placement="top"
                                                                                      data-content='Scegli la data in cui vorrai eseguire il corso'></i></label>
                                            <select id="date" class="form-control" style="height: 45px"
                                                    onchange="changeData()">
                                                <?php foreach ($execution as $key => $e): ?>
                                                    <option value="<?php echo $key; ?>"><?php echo date("d.m.Y", strtotime($e[DATE_EXECUTION][0][DB_EXECUTION_START])) . " - " . date("d.m.Y", strtotime($e[DATE_EXECUTION][count($e[DATE_EXECUTION]) - 1][DB_EXECUTION_START])); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <h4 class="mb-2">Info Data</h4>
                                            <?php foreach ($execution as $key => $e): ?>
                                                <div id="hours<?php echo $key ?>" class="hours" style="display: none">
                                                    <p><strong>Orari</strong></p>
                                                    <?php for ($i = 0; $i < count($e[DATE_EXECUTION]); $i++): ?>
                                                        <p>
                                                            <strong><?php echo date("d.m.Y", strtotime($e[DATE_EXECUTION][$i][DB_EXECUTION_START])); ?></strong>
                                                            Ora
                                                            inzio: <?php echo date("H:i", strtotime($e[DATE_EXECUTION][$i][DB_EXECUTION_START])); ?>
                                                            Ora
                                                            fine: <?php echo date("H:i", strtotime($e[DATE_EXECUTION][$i][DB_EXECUTION_END])); ?>
                                                        </p>
                                                    <?php endfor; ?>
                                                    <p class="pt--10"><strong>Posti disponibili</strong></p>
                                                    <p><?php echo (($e[MEMBER][0] <= 0) ? "<span style='color:red;'>0</span>" : $e[MEMBER][0]) . " su " . $e[MEMBER][1]; ?></p>
                                                    <p class="pt--10"><strong>Chiusura iscrizione</strong></p>
                                                    <p><?php echo $e[DEADLINE]; ?></p>
                                                    <p class="pt--10"><strong>Insegnate</strong></p>
                                                    <p>Nome: <?php echo $e[USER][DB_USER_FIRSTNAME]; ?></p>
                                                    <p>Cognome: <?php echo $e[USER][DB_USER_LASTNAME]; ?></p>
                                                    <p>Email: <?php echo $e[USER][DB_USER_EMAIL]; ?></p>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="no-print">
                                    <h4 class="mb-2 pt--50">Compila l'iscrizione</h4>
                                    <div class="row">
                                        <?php if (!isset($_SESSION[SESSION_EMAIL])): ?>
                                            <div class="col-12 mb-1 logged">
                                                <label class="mb-1 mr-3">Salva Account <i class="fa fa-info-circle"
                                                                                          data-container="body"
                                                                                          data-toggle="popover"
                                                                                          data-placement="top"
                                                                                          data-content='Cliccando "SI" i tuoi dati verranno salvati nel sito così che quando ti vorrai iscrivere ad un altro corso dovrai solamente effettuare il login'></i></label>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="saveYes" name="save"
                                                           class="custom-control-input" onchange="togglePassword()"
                                                           value="Y">
                                                    <label class="custom-control-label" for="saveYes">Si</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="saveNo" name="save"
                                                           class="custom-control-input"
                                                           onchange="togglePassword()" value="N" checked>
                                                    <label
                                                            class="custom-control-label" for="saveNo">NO</label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Nome<span class="obligatory">*</span> <i
                                                            class="fa fa-info-circle"
                                                            data-container="body"
                                                            data-toggle="popover"
                                                            data-placement="top"
                                                            data-content="3-50 caratteri, lettere e caratteri da scrittura"></i></label>
                                                <input type="text" class="form-control enr"
                                                       value="<?php echo(isset($user[DB_USER_FIRSTNAME]) ? $user[DB_USER_FIRSTNAME] : ""); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Cognome<span class="obligatory">*</span> <i
                                                            class="fa fa-info-circle"
                                                            data-container="body"
                                                            data-toggle="popover"
                                                            data-placement="top"
                                                            data-content="3-50 caratteri, lettere e caratteri da scrittura"></i></label>
                                                <input type="text" class="form-control enr"
                                                       value="<?php echo(isset($user[DB_USER_LASTNAME]) ? $user[DB_USER_LASTNAME] : ""); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Data di nascita<span class="obligatory">*</span> <i
                                                            class="fa fa-info-circle"
                                                            data-container="body"
                                                            data-toggle="popover"
                                                            data-placement="top"
                                                            data-content="Data di nascita, almeno <?php echo $minAge ?> anni."></i></label>
                                                <input type="date" class="form-control enr"
                                                       value="<?php echo(isset($user[DB_USER_BIRTHDAY]) ? $user[DB_USER_BIRTHDAY] : ""); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Via<span class="obligatory">*</span> <i class="fa fa-info-circle"
                                                                                               data-container="body"
                                                                                               data-toggle="popover"
                                                                                               data-placement="top"
                                                                                               data-content="3-50 caratteri, lettere, numeri e caratteri da scrittura"></i></label>
                                                <input type="text" class="form-control enr"
                                                       value="<?php echo(isset($user[DB_USER_STREET]) ? $user[DB_USER_STREET] : ""); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Città<span class="obligatory">*</span> <i
                                                            class="fa fa-info-circle"
                                                            data-container="body"
                                                            data-toggle="popover"
                                                            data-placement="top"
                                                            data-content="3-50 caratteri, lettere e caratteri da scrittura"></i></label>
                                                <input type="text" class="form-control enr"
                                                       value="<?php echo(isset($user[DB_USER_CITY]) ? $user[DB_USER_CITY] : ""); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>CAP<span class="obligatory">*</span> <i class="fa fa-info-circle"
                                                                                               data-container="body"
                                                                                               data-toggle="popover"
                                                                                               data-placement="top"
                                                                                               data-content="4 numeri"></i></label>
                                                <input type="number" class="form-control enr"
                                                       value="<?php echo(isset($user[DB_USER_ZIP]) ? $user[DB_USER_ZIP] : ""); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Numero mobile<span class="obligatory">*</span> <i
                                                            class="fa fa-info-circle"
                                                            data-container="body"
                                                            data-toggle="popover"
                                                            data-placement="top"
                                                            data-content="10-14 numeri"></i></label>
                                                <input type="tel" class="form-control enr"
                                                       value="<?php echo(isset($user[DB_USER_MOBILE_NUMBER]) ? $user[DB_USER_MOBILE_NUMBER] : ""); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Numero fisso <i class="fa fa-info-circle"
                                                                       data-container="body"
                                                                       data-toggle="popover"
                                                                       data-placement="top"
                                                                       data-content="10-14 numeri"></i></label>
                                                <input type="tel" class="form-control enr"
                                                       value="<?php echo(isset($user[DB_USER_LANDLINE_NUMBER]) ? $user[DB_USER_LANDLINE_NUMBER] : ""); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Numero licenza <i class="fa fa-info-circle"
                                                                         data-container="body"
                                                                         data-toggle="popover"
                                                                         data-placement="top"
                                                                         data-content="12 numeri"></i></label>
                                                <input type="number" class="form-control enr"
                                                       value="<?php echo(isset($user[DB_USER_LICENSE_NUMBER]) ? $user[DB_USER_LICENSE_NUMBER] : ""); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Numero nip <i class="fa fa-info-circle"
                                                                     data-container="body"
                                                                     data-toggle="popover"
                                                                     data-placement="top"
                                                                     data-content="9 numeri"></i></label>
                                                <input type="text" class="form-control enr"
                                                       value="<?php echo(isset($user[DB_USER_NIP]) ? $user[DB_USER_NIP] : ""); ?>">
                                            </div>
                                        </div>
                                        <?php if (!isset($_SESSION[SESSION_EMAIL])): ?>
                                            <div class="col-12 logged">
                                                <div class="form-group">
                                                    <label>Email<span class="obligatory">*</span> <i
                                                                class="fa fa-info-circle"
                                                                data-container="body"
                                                                data-toggle="popover"
                                                                data-placement="top"
                                                                data-content="Inserisci una email nel formato testo@testo.com"></i></label>
                                                    <input type="text" class="form-control em">
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="col-md-6 col-sm-12 pass" style="display: none">
                                            <div class="form-group">
                                                <label>Password <i class="fa fa-info-circle"
                                                                   data-container="body"
                                                                   data-toggle="popover"
                                                                   data-placement="top"
                                                                   data-content="La password deve avere almeno 8 caratteri e 1 numero/carattere speciale"></i></label>
                                                <input type="password" class="form-control ps">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 pass" style="display: none">
                                            <div class="form-group">
                                                <label>Re-password <i class="fa fa-info-circle"
                                                                      data-container="body"
                                                                      data-toggle="popover"
                                                                      data-placement="top"
                                                                      data-content="Deve corrispondere alla password inserita precedentemente"></i></label>
                                                <input type="password" class="form-control ps">
                                            </div>
                                        </div>
                                        <?php if ($course[DB_COURSE_MEAL_PRICE] > 0): ?>
                                            <div class="col-md-6 col-sm-12 incluFood">
                                                <div class="form-group">
                                                    <label class="mr-3">Pranzo<span class="obligatory">*</span> <i
                                                                class="fa fa-info-circle"
                                                                data-container="body"
                                                                data-toggle="popover"
                                                                data-placement="top"
                                                                data-content="Pranzo a pagamento durante il corso (partecipazione opzionale)"></i></label>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="foodYes" name="food"
                                                               class="custom-control-input" onchange="toggleFood()"
                                                               value="Y">
                                                        <label class="custom-control-label" for="foodYes">Si</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="foodNo" name="food"
                                                               class="custom-control-input"
                                                               value="N" onchange="toggleFood()" checked>
                                                        <label
                                                                class="custom-control-label" for="foodNo">NO</label>
                                                    </div>
                                                    <br>
                                                    <label class="mr-3">Tipologia cibo <i class="fa fa-info-circle"
                                                                                          data-container="body"
                                                                                          data-toggle="popover"
                                                                                          data-placement="top"
                                                                                          data-content="Seleziona la tipologia di cibo"></i></label>
                                                    <select class="form-control mb-1 fod enr"
                                                            style="height: 45px" disabled>
                                                        <option value="Nessuna Preferenza">Nessuna Preferenza</option>
                                                        <option value="Vegetariano">Vegetariano</option>
                                                        <option value="Vegano">Vegano</option>
                                                        <option value="Fruttariano">Fruttariano</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 incluFood">
                                                <div class="form-group">
                                                    <label>Intolleranze <i class="fa fa-info-circle"
                                                                           data-container="body"
                                                                           data-toggle="popover"
                                                                           data-placement="top"
                                                                           data-content="Elenca i profotti che non puoi mangiare"></i></label>
                                                    <textarea type="text" class="form-control enr fod"
                                                              style="height: 75px"
                                                              disabled></textarea>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="col-md-6 col-sm-12 pass" style="display: none">
                                            <div class="form-group">
                                                <label class="mr-3">Newsletter<span class="obligatory">*</span> <i
                                                            class="fa fa-info-circle"
                                                            data-container="body"
                                                            data-toggle="popover"
                                                            data-placement="top"
                                                            data-content="Iscrivendoti alla newsletter riceverai delle email di notizie riguardanti nuovi corsi"></i></label>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="newsletterYes" name="newsletter"
                                                           class="custom-control-input" value="Y">
                                                    <label class="custom-control-label" for="newsletterYes">Si</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="newsletterNo" name="newsletter"
                                                           class="custom-control-input" value="N" checked>
                                                    <label
                                                            class="custom-control-label" for="newsletterNo">NO</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="no-print">
                                    <span><span class="obligatory">*</span> campi da compilare</span>
                                    <div class="pt--15"></div>
                                    <div class="g-recaptcha" data-sitekey="<?php echo WEBSITE_KEY; ?>"></div>
                                    <div class="pt--30"></div>
                                    <div id="alert_validation" class="alert alert-danger mt-2" style="display:none;"
                                         role="alert">
                                        Uno o più valori non sono coretti!
                                    </div>
                                    <div id="alert_validation_data_full" class="alert alert-danger mt-2"
                                         style="display:none;"
                                         role="alert">
                                        La data selezionata è al completo!
                                    </div>
                                    <div id="alert_validation_overlap" class="alert alert-danger mt-2"
                                         style="display:none;"
                                         role="alert">
                                        Un utente con questa email è gia iscritto al corso!
                                    </div>
                                    <div id="alert_validation_email" class="alert alert-danger mt-2"
                                         style="display:none;"
                                         role="alert">
                                        La email in uso appartiene già a un utente iscritto al sito oppure non è valida!
                                    </div>
                                    <div id="alert_validation_captcha" class="alert alert-danger mt-2"
                                         style="display:none;"
                                         role="alert">
                                        Verifica captcha non effettuata!
                                    </div>
                                    <div class="row pt--50">
                                        <div class="col-md-6 col-sm-12 pb--10">
                                            <div class="input-group">
                                                <a class="btn btn-info btn-lg btn-block" onclick="checkAll()"
                                                   style="color: white">Iscriviti
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="input-group">
                                                <a class="btn btn-outline-info btn-lg btn-block"
                                                   href="<?php echo URL . 'researchCourses'; ?>">Torna indietro</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="no-print">
                                    <h4 class='text-center' style="padding-top: 30px;">Non ci sono date di questo di
                                        questo
                                        corso, riprova più tardi</h4>
                                    <div class="row pt--50">
                                        <div class="col-12 pb--10">
                                            <div class="input-group">
                                                <a class="btn btn-outline-info btn-lg btn-block"
                                                   href="<?php echo URL . 'researchCourses'; ?>">Torna indietro</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/enrollmentCourse.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>