<title>Gestione svolgimenti</title>
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
                <a class="nav-link" href="<?php echo URL . 'researchCourses' ?>">Ricerca Corsi</a>
            </li>
            <?php if (isset($_SESSION[SESSION_TYPE])): ?>
                <?php if ($_SESSION[SESSION_TYPE] >= TYPE_ADMIN): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL . 'adminPanel'; ?>">Pannello Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active " href="<?php echo URL . 'managementCourses'; ?>">Gestioni corsi<span
                                    class="sr-only">(current)</span></a>
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
                            <h2 class="mb-5 text-center"><?php echo $title; ?></h2>
                            <h4 class="mb-4">Informazioni</h4>
                            <p><strong>Orari</strong></p>
                            <?php for ($i = 0; $i < count($dateExecution[DATE_EXECUTION]); $i++): ?>
                                <p>
                                    <strong><?php echo date("d.m.Y", strtotime($dateExecution[DATE_EXECUTION][$i][START_LESSON])); ?></strong>
                                    Ora
                                    inzio: <?php echo date("H:i", strtotime($dateExecution[DATE_EXECUTION][$i][DB_EXECUTION_START])); ?>
                                    Ora
                                    fine: <?php echo date("H:i", strtotime($dateExecution[DATE_EXECUTION][$i][DB_EXECUTION_END])); ?>
                                </p>
                            <?php endfor; ?>
                            <p class="pt--10"><strong>Chiusura iscrizione</strong></p>
                            <p><?php echo $dateExecution[DEADLINE]; ?></p>
                            <p class="pt--10"><strong>Posti disponibili</strong></p>
                            <p><?php echo (($partecpiants[0] <= 0) ? "<span style='color:red;'>0</span>" : $partecpiants[0]) . " su " . $partecpiants[1]; ?></p>
                            <h4 class="mb-4 pt--50">Iscritti</h4>
                            <p class="pb--20">Questa tabella mostra tutti gli iscritti al corso. È possibile eliminare
                                un iscrizione (se fatto prima della data di chiusura iscrizione) o confermare/cancellare
                                il pagamento.</p>
                            <?php if (count($execution) != 0): ?>
                                <table id="enrollment_table"
                                       class="table table-striped table-bordered nowrap text-center"
                                       style="width:100%">
                                    <thead class="text-uppercase bg-dark">
                                    <tr class="text-white">
                                        <th scope="col">Email</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Cognome</th>
                                        <th scope="col">Pasto</th>
                                        <th scope="col">Tipologia</th>
                                        <th scope="col">Intolleranze</th>
                                        <th scope="col">Pagato</th>
                                        <th scope="col">Elimina</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($execution as $e): ?>
                                        <tr>
                                            <td>
                                                <?php echo $e[DB_USER_EMAIL]; ?>
                                            </td>
                                            <td>
                                                <?php echo $e[DB_USER_FIRSTNAME]; ?>
                                            </td>
                                            <td>
                                                <?php echo $e[DB_USER_LASTNAME]; ?>
                                            </td>
                                            <td>
                                                <?php if ($priceMealCourse > 0): ?>
                                                    <?php echo ($e[DB_FLAG_MEAL] == 1) ? "&#10004" : "&#10006"; ?>
                                                <?php else: ?>
                                                    Non presente
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo ($e[DB_MEAL_TYPOLOGY] == "") ? "-" : $e[DB_MEAL_TYPOLOGY]; ?>
                                            </td>
                                            <td>
                                                <div style="word-break: break-word; white-space: pre-line; margin-top: -20px">
                                                    <?php echo ($e[DB_INTOLERANCES] == "") ? "-" : $e[DB_INTOLERANCES]; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="checkbox" <?php echo ($e[DB_FLAG_PAID] == 1) ? "checked" : ""; ?>
                                                       onchange="paid(this,<?php echo $e[DB_ENROLL_ID]; ?>)">
                                            </td>
                                            <td>
                                                <div class="align-middle mb-1">
                                                    <button style="width: 160px" type="button"
                                                            class="btn btn-danger btn-fix-panel-control"
                                                            data-toggle="modal" data-target="#deleteEnrollmentModal"
                                                            onclick="setInfoEnrollment(<?php echo $e[DB_ENROLL_ID]; ?>)">
                                                        Elimina <i class="fa fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <h4 class='text-center' style="padding-top: 30px;">Non esistono iscrizioni</h4>
                            <?php endif; ?>
                            <div class="modal fade" id="deleteEnrollmentModal" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Elimina iscrizione</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body font-18">
                                            <div id="alert_enrollment_deleted" class="alert alert-success" role="alert"
                                                 style="display: none">
                                                Iscrizione eliminata!
                                            </div>
                                            <div id="alert_enrollment_date" class="alert alert-danger" role="alert"
                                                 style="display: none">
                                                Non è possibile eliminare l'iscrizione perché la data di scadenza del
                                                corso è già passata!
                                            </div>
                                            <div class="text-center">
                                                <i class="fa fa-warning" style="font-size:48px;"></i>
                                                <p>Sei sicuro di voler eliminare questo iscrizione?</p>
                                            </div>
                                        </div>
                                        <input type="hidden" id="modal_input_del_enrollment" disabled>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" onclick="deleteEnrollment()">
                                                Elimina
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Chiudi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (strtotime($dateExecution[DEADLINE]) >= strtotime('today midnight') && intval($partecpiants[0]) > 0): ?>
                            <h4 class="mb-4 pt--50">Aggiungi iscrizione</h4>
                            <div class="row">
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
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Email<span class="obligatory">*</span> <i
                                                    class="fa fa-info-circle"
                                                    data-container="body"
                                                    data-toggle="popover"
                                                    data-placement="top"
                                                    data-content="Inserisci una email nel formato testo@testo.com"></i></label>
                                        <input type="text" class="form-control enr">
                                    </div>
                                </div>
                                <?php if ($priceMealCourse > 0): ?>
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
                                            <textarea type="text" class="form-control enr fod" style="height: 75px"
                                                      disabled></textarea>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <span><span class="obligatory">*</span> campi da compilare</span>
                            <div class="pt--30"></div>
                            <div id="alert_validation_ok" class="alert alert-success mt-2" style="display:none;"
                                 role="alert">
                                Iscrizione Aggiunta!
                            </div>
                            <div id="alert_validation" class="alert alert-danger mt-2" style="display:none;"
                                 role="alert">
                                Uno o più valori non sono coretti!
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
                            <div class="row pt--50">
                                <div class="col-md-6 col-sm-12 pb--10">
                                    <div class="input-group">
                                        <a class="btn btn-info btn-lg btn-block"
                                           onclick="checkAll(<?php echo $idExecution; ?>)"
                                           style="color: white">Iscriviti
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="input-group">
                                        <a class="btn btn-outline-info btn-lg btn-block"
                                           href="<?php echo URL . 'managementCourses'; ?>">Torna indietro</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                            <div class="row pt--50">
                                <div class="col-12 pb--10">
                                    <div class="input-group">
                                        <a class="btn btn-outline-info btn-lg btn-block"
                                           href="<?php echo URL . 'managementCourses'; ?>">Torna indietro</a>
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
<script src="js/managementExecution.js"></script>