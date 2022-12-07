<title>Profilo</title>
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
                        <a class="nav-link " href="<?php echo URL . 'managementCourses'; ?>">Gestioni corsi</a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <li class="nav-item">
                <?php if (!isset($_SESSION[SESSION_EMAIL])): ?>
                    <a class="nav-link" href="<?php echo URL . 'login' ?>">Login</a>
                <?php else: ?>
                    <a class="nav-link active" href="<?php echo URL . 'profile' ?>">Profilo<span
                                class="sr-only">(current)</span></a>
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
                            <h2 class="mb-5 text-center">Profilo</h2>
                            <h4 class="mb-4">Corsi da fare:</h4>
                            <p class="pb--20">Questa tabella mostra tutti i corsi ancora da fare. In questa tabella ti
                                puoi disiscrivere ad corso se fatto prima della loro scadenza.</p>
                            <?php if (count($toDoExe) != 0): ?>
                                <table id="todo_table" class="table table-striped table-bordered nowrap text-center"
                                       style="width:100%">
                                    <thead class="text-uppercase bg-dark">
                                    <tr class="text-white">
                                        <th scope="col">Titolo</th>
                                        <th scope="col">Pagato</th>
                                        <th scope="col">Data chiusura iscrizione</th>
                                        <th scope="col">Inzio</th>
                                        <th scope="col">Fine</th>
                                        <th scope="col">Pasto</th>
                                        <th scope="col">Tipologia</th>
                                        <th scope="col">Intolleranze</th>
                                        <th scope="col">Disiscriviti</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($toDoExe as $t): ?>
                                        <tr>
                                            <td>
                                                <?php echo $t[DB_COURSE_TITLE]; ?>
                                            </td>
                                            <td>
                                                <?php echo ($t[DB_FLAG_PAID] == 1) ? "&#10004" : "&#10006"; ?>
                                            </td>
                                            <td>
                                                <span style="display:none;"><?php echo $t[DB_DEADLINE]; ?></span><?php echo date("d.m.Y", strtotime($t[DB_DEADLINE])); ?>
                                            </td>
                                            <td>
                                                <span style="display:none;"><?php echo $t[DB_EXECUTION_START]; ?></span><?php echo date("d.m.Y", strtotime($t[DB_EXECUTION_START])); ?>
                                            </td>
                                            <td>
                                                <span style="display:none;"><?php echo $t[DB_EXECUTION_START]; ?></span><?php echo date("d.m.Y", strtotime($t[DB_EXECUTION_END])); ?>
                                            </td>
                                            <td>
                                                <?php if ($t[DB_COURSE_MEAL_PRICE] > 0): ?>
                                                    <?php echo ($t[DB_FLAG_MEAL] == 1) ? "&#10004" : "&#10006"; ?>
                                                <?php else: ?>
                                                    Non presente
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo ($t[DB_MEAL_TYPOLOGY] == "") ? "-" : $t[DB_MEAL_TYPOLOGY]; ?>
                                            </td>
                                            <td>
                                                <div style="word-break: break-word; white-space: pre-line; margin-top: -20px">
                                                    <?php echo ($t[DB_INTOLERANCES] == "") ? "-" : $t[DB_INTOLERANCES]; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="align-middle mb-1">
                                                    <button style="width: 160px" type="button"
                                                            class="btn btn-danger btn-fix-panel-control"
                                                            data-toggle="modal" data-target="#deleteEnrollmentModal"
                                                            onclick="setInfoEnrollment(<?php echo $t[DB_ENROLL_ID]; ?>)">
                                                        Disiscriviti <i class="fa fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <h4 class='text-center' style="padding-top: 30px;">Non ti sei iscritti a nessun
                                    corso</h4>
                            <?php endif; ?>
                            <div class="modal fade" id="deleteEnrollmentModal" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Disiscriviti</h5>
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
                                                Disiscriviti
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Chiudi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="mb-4 pt--50">Corsi fatti:</h4>
                            <p class="pb--20">Questa tabella mostra tutti i corsi fatti.</p>
                            <?php if (count($doneExe) != 0): ?>
                                <table id="done_table" class="table table-striped table-bordered nowrap text-center"
                                       style="width:100%">
                                    <thead class="text-uppercase bg-dark">
                                    <tr class="text-white">
                                        <th scope="col">Titolo</th>
                                        <th scope="col">Inzio</th>
                                        <th scope="col">Fine</th>
                                        <th scope="col">Pasto</th>
                                        <th scope="col">Tipologia</th>
                                        <th scope="col">Intolleranze</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($doneExe as $t): ?>
                                        <tr>
                                            <td>
                                                <?php echo $t[DB_COURSE_TITLE]; ?>
                                            </td>
                                            <td>
                                                <span style="display:none;"><?php echo $t[DB_EXECUTION_START]; ?></span><?php echo date("d.m.Y", strtotime($t[DB_EXECUTION_START])); ?>
                                            </td>
                                            <td>
                                                <span style="display:none;"><?php echo $t[DB_EXECUTION_START]; ?></span><?php echo date("d.m.Y", strtotime($t[DB_EXECUTION_END])); ?>
                                            </td>
                                            <td>
                                                <?php if ($t[DB_COURSE_MEAL_PRICE] > 0): ?>
                                                    <?php echo ($t[DB_FLAG_MEAL] == 1) ? "&#10004" : "&#10006"; ?>
                                                <?php else: ?>
                                                    Non presente
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo ($t[DB_MEAL_TYPOLOGY] == "") ? "-" : $t[DB_MEAL_TYPOLOGY]; ?>
                                            </td>
                                            <td>
                                                <div style="word-break: break-word; white-space: pre-line; margin-top: -20px">
                                                    <?php echo ($t[DB_INTOLERANCES] == "") ? "-" : $t[DB_INTOLERANCES]; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <h4 class='text-center' style="padding-top: 30px; padding-bottom: 30px">Non hai concluso
                                    nessun corso</h4>
                            <?php endif; ?>
                            <div class="row mb-2 mt-4 pt--50">
                                <div class="col-12">
                                    <div class="input-group">
                                        <a class="btn btn-danger btn-lg btn-block"
                                           href="<?php echo URL . "profile/logout" ?>">Disconnettiti</a>
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
<script src="js/profile.js"></script>