<title>Aggiungi corso</title>
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
                            <h2 class="mb-5 text-center">Aggiunta corso</h2>
                            <form>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Titolo<span class="obligatory">*</span> <i class="fa fa-info-circle"
                                                                                              data-container="body"
                                                                                              data-toggle="popover"
                                                                                              data-placement="top"
                                                                                              data-content="3-100 caratteri, lettere, numeri e caratteri da scrittura"></i></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Via<span class="obligatory">*</span> <i class="fa fa-info-circle"
                                                                                           data-container="body"
                                                                                           data-toggle="popover"
                                                                                           data-placement="top"
                                                                                           data-content="3-50 caratteri, lettere, numeri e caratteri da scrittura"></i></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>CAP<span class="obligatory">*</span> <i class="fa fa-info-circle"
                                                                                           data-container="body"
                                                                                           data-toggle="popover"
                                                                                           data-placement="top"
                                                                                           data-content="4 numeri"></i></label>
                                            <input type="number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Città<span class="obligatory">*</span> <i class="fa fa-info-circle"
                                                                                             data-container="body"
                                                                                             data-toggle="popover"
                                                                                             data-placement="top"
                                                                                             data-content="3-50 caratteri, lettere e caratteri da scrittura"></i></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Numero max. partecipanti<span class="obligatory">*</span> <i
                                                        class="fa fa-info-circle"
                                                        data-container="body"
                                                        data-toggle="popover"
                                                        data-placement="top"
                                                        data-content="Numero massimo di partecipaneti al corso (min 1 e max 999 partecipanti)"></i></label>
                                            <input type="number" min="0" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Tipologia<span class="obligatory">*</span> <i
                                                        class="fa fa-info-circle"
                                                        data-container="body"
                                                        data-toggle="popover"
                                                        data-placement="top"
                                                        data-content="Tipologia del corso (Per aggiungere una tipologia andare nelle impostazioni del pannello admin)"></i></label>
                                            <select id="typ" class="form-control" style="height: 45px">
                                                <?php foreach ($typologies as $t): ?>
                                                    <option value="<?php echo $t[NAME_TYPOLOGY]; ?>"><?php echo $t[NAME_TYPOLOGY]; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Prezzo corso<span class="obligatory">*</span> <i
                                                        class="fa fa-info-circle"
                                                        data-container="body"
                                                        data-toggle="popover"
                                                        data-placement="top"
                                                        data-content="Cifra in CHF da pagare per l'iscrizione al corso (Numero positivo e max 9999 CHF)"></i></label>
                                            <input type="number" min="0" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Prezzo pasto<span class="obligatory">*</span> <i
                                                        class="fa fa-info-circle"
                                                        data-container="body"
                                                        data-toggle="popover"
                                                        data-placement="top"
                                                        data-content="Cifra in CHF da pagare per l'iscrizione al corso (Numero positivo e max 999 CHF). Se si imposta '0' significa che non è presente un pasto"></i></label>
                                            <input type="number" min="0" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label>Descrizione<span class="obligatory">*</span> <i class="fa fa-info-circle"
                                                                                               data-container="body"
                                                                                               data-toggle="popover"
                                                                                               data-placement="top"
                                                                                               data-content="Solo lettere, numeri e caratteri da scrittura (almeno 3 caratteri)"
                                                                                               data-toggle="tooltip"></i></label>
                                        <div class="form-group">
                                            <textarea type="text" id="text_modal_input"
                                                      class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label>Materiale <i class="fa fa-info-circle"
                                                            data-container="body"
                                                            data-toggle="popover"
                                                            data-placement="top"
                                                            data-content="Solo lettere, numeri e caratteri da scrittura (almeno 3 caratteri)"
                                                            data-toggle="tooltip"></i></label>
                                        <div class="form-group">
                                            <textarea type="text" id="text_modal_input"
                                                      class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <span><span class="obligatory">*</span> campi da compilare</span>
                            <div id="alert_validation" class="alert alert-danger mt-2" style="display:none;"
                                 role="alert">
                                Uno o più valori non sono coretti!
                            </div>
                            <div class="row pt--30">
                                <div class="col-md-6 col-sm-12 pb--10">
                                    <div class="input-group">
                                        <a class="btn btn-info btn-lg btn-block" onclick="checkAll()"
                                           style="color: white">Aggiungi
                                            corso</a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/addCourse.js"></script>