<title>Gestione corsi</title>
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
                            <h2 class="mb-5 text-center">Gestione corsi</h2>
                            <h4 class="mb-4">Corsi</h4>
                            <span>Questa tabella mostra i temi dei corsi. Cliccando sul bottone "Aggiungi corso" sarà possibile aggiungere un nuovo tema. Invece cliccando il "+" a inzio di ogni riga, si avrà la possibilita di creare degli svolgemineti,
                            modificare il corso o eliminare il corso.</span>
                            <div class="row mb-2 mt-4">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <a class="btn btn-outline-info btn-lg btn-block"
                                           href="<?php echo URL . "addCourse" ?>">Aggiungi corso</a>
                                    </div>
                                </div>
                            </div>
                            <?php if (count($courses) != 0): ?>
                                <table id="course_table" class="table table-striped table-bordered nowrap text-center"
                                       style="width:100%">
                                    <thead class="text-uppercase bg-dark">
                                    <tr class="text-white">
                                        <th scope="col">Tipologia</th>
                                        <th scope="col">Titolo</th>
                                        <th scope="col">Via</th>
                                        <th scope="col">Città</th>
                                        <th scope="col">CAP</th>
                                        <th scope="col">Numero max. partecipanti</th>
                                        <th scope="col">Prezzo corso</th>
                                        <th scope="col">Prezzo pasto</th>
                                        <th scope="col">Materiale</th>
                                        <th scope="col">Descrizione</th>
                                        <th scope="col">Azioni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($courses as $c): ?>
                                        <tr>
                                            <td>
                                                <?php echo $c[DB_COURSE_TYPOLOGY]; ?>
                                            </td>
                                            <td>
                                                <?php echo $c[DB_COURSE_TITLE]; ?>
                                            </td>
                                            <td>
                                                <?php echo $c[DB_COURSE_STREET]; ?>
                                            </td>
                                            <td>
                                                <?php echo $c[DB_COURSE_CITY]; ?>
                                            </td>
                                            <td>
                                                <?php echo $c[DB_COURSE_ZIP]; ?>
                                            </td>
                                            <td>
                                                <?php echo $c[DB_COURSE_MAX_PARTECIPANTS]; ?>
                                            </td>
                                            <td>
                                                <?php echo $c[DB_COURSE_COURSE_PRICE]; ?>
                                            </td>
                                            <td>
                                                <?php echo $c[DB_COURSE_MEAL_PRICE]; ?>
                                            </td>
                                            <td>
                                                <div style="word-break: break-word; white-space: pre-line; margin-top: -20px">
                                                    <?php echo ($c[DB_COURSE_MATERIALS] == null) ? " -" : $c[DB_COURSE_MATERIALS]; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="word-break: break-word; white-space: pre-line; margin-top: -20px">
                                                    <?php echo $c[DB_COURSE_DESCRIPTION]; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="align-middle mb-1">
                                                    <a style="width: 160px" type="button"
                                                       class="btn btn-info btn-fix-panel-control"
                                                       href="<?php echo URL . 'modifyCourse/getDataCourse/' . $c[DB_COURSE_ID] ?>">Modifica
                                                        <i class="fa fa-pencil-square-o"></i></a>
                                                </div>
                                                <div class="align-middle mb-1">
                                                    <button style="width: 160px" type="button"
                                                            class="btn btn-warning btn-fix-panel-control"
                                                            data-toggle="modal" data-target="#addExecutionModal"
                                                            onclick="prepareExecution(<?php echo $c[DB_COURSE_ID]; ?>)">
                                                        Crea svolgimento <i class="fa fa-clock-o"></i></button>
                                                </div>
                                                <div class="align-middle mb-1">
                                                    <button style="width: 160px" type="button"
                                                            class="btn btn-danger btn-fix-panel-control"
                                                            data-toggle="modal" data-target="#deleteCourseModal"
                                                            onclick="setInfoCourse(<?php echo $c[DB_COURSE_ID]; ?>)">
                                                        Elimina
                                                        <i class="fa fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <h4 class='text-center' style="padding-top: 30px;">Non esistono corsi</h4>
                            <?php endif; ?>
                            <div class="modal fade" id="deleteCourseModal" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Elimina corso</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body font-18">
                                            <div id="alert_course_deleted" class="alert alert-success" role="alert"
                                                 style="display: none">
                                                Corso eliminato!
                                            </div>
                                            <div class="text-center">
                                                <i class="fa fa-warning" style="font-size:48px;"></i>
                                                <p>Sei sicuro di voler eliminare questo corso? Eliminerai anche tutti
                                                    gli svolgimenti di questo corso.</p>
                                            </div>
                                        </div>
                                        <input type="hidden" id="modal_input_del_course" disabled>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" onclick="deleteCourse()">
                                                Elimina
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Chiudi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="addExecutionModal" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Aggiungi svolgimento</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body font-18">
                                            <div id="alert_validation_date_fail" class="alert alert-danger" role="alert"
                                                 style="display: none">
                                                Uno o più campi non validi!
                                            </div>
                                            <div id="alert_validation_hours_fail" class="alert alert-danger"
                                                 role="alert"
                                                 style="display: none">
                                                Una o più ore non valide!
                                            </div>
                                            <div id="alert_validation_overlap" class="alert alert-danger"
                                                 role="alert"
                                                 style="display: none">
                                                Insegnante già occupato in un altro corso in questo periodo di date!
                                            </div>
                                            <div id="alert_validation_execution_succ" class="alert alert-success"
                                                 role="alert"
                                                 style="display: none">
                                                Svolgimento aggiunto!
                                            </div>
                                            <input type="hidden" id="modal_input_add_exe" disabled>
                                            <form id="form_add_execution">
                                                <table class="table" style="margin-bottom: 0">
                                                    <tbody id="exe_body">
                                                    <tr>
                                                        <td>Data inizio <i class="fa fa-info-circle"
                                                                           data-container="body" data-toggle="popover"
                                                                           data-placement="top"></i>
                                                            <input id="in_date" type="date" id="typology_modal_input"
                                                                   class="form-control mb-1"
                                                                   onchange="updateDedalineExecution()">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Durata Scadenza <i class="fa fa-info-circle"
                                                                               data-container="body"
                                                                               data-toggle="popover"
                                                                               data-placement="top"
                                                                               data-content="La data di scadenza per l'iscrizione al corso. (Calcolata automaticamente con le impostazioni del sito)"></i>
                                                            <br><span id="deadline_date"></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Durata corso <i class="fa fa-info-circle"
                                                                            data-container="body" data-toggle="popover"
                                                                            data-placement="top"
                                                                            data-content="Numero di giorni consecutivi del corso"></i>
                                                            <select class="form-control mb-1"
                                                                    style="height: 45px" onchange="changeDay(this)">
                                                                <option value="1">1 Giorno</option>
                                                                <option value="2">2 Giorni</option>
                                                                <option value="3">3 Giorni</option>
                                                                <option value="4">4 Giorni</option>
                                                                <option value="5">5 Giorni</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Insegnate <i class="fa fa-info-circle" data-container="body"
                                                                         data-toggle="popover" data-placement="top"
                                                                         data-content="Insegnate del corso"></i>
                                                            <select id="teach" class="form-control mb-1"
                                                                    style="height: 45px">
                                                                <?php foreach ($teachers as $t): ?>
                                                                    <option value="<?php echo $t[DB_USER_ID]; ?>"><?php echo $t[DB_USER_FIRSTNAME] . " " . $t[DB_USER_LASTNAME] . " (" . $t[DB_USER_EMAIL] . ")"; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="raw_exe1">Inserisci ora inzio e ora fine dei seguenti
                                                            giorni: <i
                                                                    class="fa fa-info-circle" data-container="body"
                                                                    data-toggle="popover" data-placement="top"
                                                                    data-content="Ora inizale deve essere maggiore di quella finale"></i><br><strong
                                                                    id="day1"></strong><br>
                                                            Inizio: <input id="start_time1" type="time"
                                                                           id="typology_modal_input"
                                                                           class="form-control mb-1" min="06:00"
                                                                           max="22:00" value="14:00" required>
                                                            Fine: <input id="end_time2" type="time"
                                                                         id="typology_modal_input"
                                                                         class="form-control mb-1" min="06:00"
                                                                         max="22:00" value="15:00" required>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" onclick="checkExecution()">
                                                Aggiungi
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Chiudi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="mt-5 mb-4">Svolgimenti</h4>
                            <span>Questa tabella mostra gli svolgimenti dei corsi. È possibile vedere le persone che si sono iscritte a uno svolgimento (così da verificare il pagamento) oppure eliminare lo svolgimento stesso.</span>
                            <?php if (count($executions) != 0): ?>
                                <table id="execution_table"
                                       class="table table-striped table-bordered nowrap text-center"
                                       style="width:100%">
                                    <thead class="text-uppercase bg-dark">
                                    <tr class="text-white">
                                        <th scope="col">Titolo</th>
                                        <th scope="col">Docente</th>
                                        <th scope="col">Inizio</th>
                                        <th scope="col">Fine</th>
                                        <th scope="col">Azioni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($executions as $e): ?>
                                        <tr>
                                            <td>
                                                <?php echo $e[DB_COURSE_TITLE]; ?>
                                            </td>
                                            <td>
                                                <?php echo $e[DB_USER_FIRSTNAME] . " " . $e[DB_USER_LASTNAME] . " (" . $e[DB_USER_EMAIL] . ")"; ?>
                                            </td>
                                            <td>
                                                <span style="display:none;"><?php echo $e[DB_EXECUTION_START]; ?></span><?php echo date("d.m.Y", strtotime($e[DB_EXECUTION_START])); ?>
                                            </td>
                                            <td>
                                                <span style="display:none;"><?php echo $e[DB_EXECUTION_END]; ?></span><?php echo date("d.m.Y", strtotime($e[DB_EXECUTION_END])); ?>
                                            </td>
                                            <td>
                                                <div class="align-middle mb-1">
                                                    <a style="width: 160px" type="button"
                                                       class="btn btn-info btn-fix-panel-control"
                                                       href="<?php echo URL . 'managementExecution/getDataExecution/' . $e[DB_EXECUTION_ID]; ?>">
                                                        Gestisci iscrizioni <i class="fa fa-clock-o"></i></a>
                                                </div>
                                                <div class="align-middle mb-1">
                                                    <button style="width: 160px" type="button"
                                                            class="btn btn-danger btn-fix-panel-control"
                                                            data-toggle="modal" data-target="#deleteExecutionModal"
                                                            onclick="setInfoExecution(<?php echo $e[DB_EXECUTION_ID]; ?>)">
                                                        Elimina
                                                        <i class="fa fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <h4 class='text-center' style="padding-top: 30px;">Non esistono svolgimenti</h4>
                            <?php endif; ?>
                            <div class="modal fade" id="deleteExecutionModal" tabindex="-1" role="dialog"
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
                                            <div id="alert_execution_deleted" class="alert alert-success" role="alert"
                                                 style="display: none">
                                                Svolgimento eliminato!
                                            </div>
                                            <div class="text-center">
                                                <i class="fa fa-warning" style="font-size:48px;"></i>
                                                <p>Sei sicuro di voler eliminare questo svolgimento? Eliminerai anche
                                                    tutte le iscrizioni di questo svolgimento.</p>
                                            </div>
                                        </div>
                                        <input type="hidden" id="modal_input_del_execution" disabled>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" onclick="deleteExecution()">
                                                Elimina
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Chiudi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/managementCourses.js"></script>