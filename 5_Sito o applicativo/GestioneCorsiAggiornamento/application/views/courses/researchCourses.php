<title>Ricerca Corsi</title>
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
                        <a class="nav-link " href="<?php echo URL . 'managementCourses'; ?>">Gestioni corsi</a>
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
                            <h2 class="mb-5 text-center">Ricerca corsi</h2>
                            <?php if (count($courses) != 0): ?>
                                <table id="course_table" class="table table-striped table-bordered nowrap"
                                       style="width:100%">
                                    <thead class="text-uppercase bg-dark">
                                    <tr class="text-white">
                                        <td>
                                            Corso
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($courses as $c): ?>
                                        <tr>
                                            <td>
                                                <div style="word-break: break-word; white-space: pre-line; margin-top: -20px">
                                                    <h4 class="pt--10"><?php echo $c[DB_COURSE_TITLE]; ?></h4>
                                                    <p><strong>Tipologia: </strong><?php echo $c[DB_COURSE_TYPOLOGY]; ?>
                                                    </p>
                                                    <p style="margin-top: -40px">
                                                        <strong>Costo: </strong><?php echo $c[DB_COURSE_COURSE_PRICE]; ?>
                                                    </p>
                                                    <p style="margin-top: -40px">
                                                        <strong>Città: </strong><?php echo $c[DB_COURSE_CITY]; ?></p>
                                                    <p>
                                                        <strong>Descrizione: </strong><?php echo $c[DB_COURSE_DESCRIPTION]; ?>
                                                    </p>
                                                    <div style="margin-top: -20px">
                                                        <a style="width: 160px" type="button"
                                                           class="btn btn-info btn-fix-panel-control"
                                                           href="<?php echo URL . 'enrollmentCourse/getDataCourse/' . $c[DB_COURSE_ID] ?>">Iscriviti
                                                            <i class="fa fa-pencil-square-o"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <h4 class='text-center' style="padding-top: 30px;">Non esistono corsi</h4>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/researchCourses.js"></script>
