<title>Pannello Admin</title>
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
                        <a class="nav-link active" href="<?php echo URL . 'adminPanel'; ?>">Pannello Admin<span
                                    class="sr-only">(current)</span></a>
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
                            <h2 class="mb-5 text-center">Pannello Admin</h2>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="homepage-management-tab" data-toggle="tab"
                                       href="#homepage_management" role="tab" aria-controls="homepage_management"
                                       aria-selected="true">Pagina Principale</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-management-tab" data-toggle="tab"
                                       href="#contact_management" role="tab" aria-controls="contact_management"
                                       aria-selected="false">Pagina contatti</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab"
                                       aria-controls="settings" aria-selected="false">Impostazioni</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="users-tab" data-toggle="tab" href="#users" role="tab"
                                       aria-controls="users" aria-selected="false" onclick="fixDatatable()">Utenti</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-3 pt--20 pb--20" id="myTabContent">
                                <div class="tab-pane fade show active" id="homepage_management" role="tabpanel"
                                     aria-labelledby="homepage-management-tab">
                                    <h5 id="photo">Foto</h5>
                                    <button type="button"
                                            class="btn btn-outline-info btn-fix-panel-control mt-4"
                                            data-toggle="modal"
                                            data-target="#addPhotoModal"
                                            onclick="clearModalFoto()">
                                        Aggiungi foto <i class="fa fa-plus"></i>
                                    </button>
                                    <?php if (count($photos) != 0): ?>
                                        <div class="table-responsive w-100 mt-4" style="max-height: 300px">
                                            <table class="table text-center">
                                                <thead class="text-uppercase bg-dark">
                                                <tr class="text-white">
                                                    <th scope="col">Foto</th>
                                                    <th scope="col">Azioni</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($photos as $p): ?>
                                                    <tr>
                                                        <td scope="row">
                                                            <img src="<?php echo $p[DB_PATH_PHOTO]; ?>" width=150px>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <button style="width: 130px" type="button"
                                                                        class="btn btn-danger btn-fix-panel-control mt-4"
                                                                        data-toggle="modal"
                                                                        data-target="#deletePhotoModal"
                                                                        onclick="setInfoPhoto('<?php echo $p[DB_PATH_PHOTO]; ?>')">
                                                                    Elimina <i class="fa fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <h4 class='text-center' style="padding-top: 30px;">Non esistono foto nella
                                            pagina principale</h4>
                                    <?php endif; ?>
                                    <!-- Add photo -->
                                    <div class="modal fade" id="addPhotoModal" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Aggiungi foto</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body font-18">
                                                    <div id="alert_validation_photo_add_file" class="alert alert-danger"
                                                         role="alert"
                                                         style="display: none">
                                                        Aggiungi una foto attraverso la voce "Scegli file"
                                                    </div>
                                                    <div id="alert_validation_photo_add_os" class="alert alert-danger"
                                                         role="alert"
                                                         style="display: none">
                                                        Il sistema operativo dove gira il servizio non supporta
                                                        l'aggiunta di foto!
                                                    </div>
                                                    <div id="alert_validation_photo_add_specific"
                                                         class="alert alert-danger" role="alert"
                                                         style="display: none">
                                                        L'immagine inserita non è valida!
                                                    </div>
                                                    <div id="alert_validation_photo_add_ok" class="alert alert-success"
                                                         role="alert"
                                                         style="display: none">
                                                        Foto aggiunta!
                                                    </div>
                                                    <form id="form_admin_panel_photo_add">
                                                        <hr class="mt-0 mb-10">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="pl-10" style="font-weight: 600">Seleziona
                                                                    foto <i class="fa fa-info-circle"
                                                                            data-container="body" data-toggle="popover"
                                                                            data-placement="bottom"
                                                                            data-content="Estensioni supportate: .png .jpg .jpeg .gif (Max 5MB) Formato consigliato 16:9"></i></label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input class="pl-10" type="file" id="files"
                                                                       accept=".png, .jpg, .jpeg .gif">
                                                            </div>
                                                        </div>
                                                        <hr class="mb-10" style="margin-top: 6px;">
                                                        <label class="mb-10 pl-10"
                                                               style="font-weight: 600">Preview</label>
                                                        <div class="w-100">
                                                            <div class="image-wrapper">
                                                                <img id="image"/>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                            onclick="addDataPhoto()">Aggiungi
                                                    </button>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Chiudi
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--deletephoto -->
                                    <div class="modal fade" id="deletePhotoModal" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Elimina foto</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body font-18">
                                                    <div id="alert_photo_deleted" class="alert alert-success"
                                                         role="alert"
                                                         style="display: none">
                                                        Foto eliminata!
                                                    </div>
                                                    <div class="text-center">
                                                        <i class="fa fa-warning" style="font-size:48px;"></i>
                                                        <p>Sei sicuro di voler eliminare questa Foto?</p>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="modal_input_del_photo" disabled>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                            onclick="deletePhoto()">Elimina
                                                    </button>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Chiudi
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end management photo -->
                                    <h5 class="mt-5 mb-4">Descrizione</h5>
                                    <div id="alert_text_ok" class="alert alert-success" role="alert"
                                         style="display: none">
                                        Descrizione salvata!
                                    </div>
                                    <form id="form_modify_description" class="mb-10">
                                        <div class="row">
                                            <div class="col-12 pb--20">
                                                <textarea id="description_homepage"
                                                          class="js--trumbowyg"><?php echo $text; ?></textarea>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-sm-6">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <button class="btn btn-primary btn-lg btn-block"
                                                        onclick="saveDescription()">Salva
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact_management" role="tabpanel"
                                     aria-labelledby="contact-management-tab">
                                    <h5 class="mb-4">Contatti</h5>
                                    <div id="alert_contact_ok" class="alert alert-success" role="alert"
                                         style="display: none">
                                        Contatti salvati!
                                    </div>
                                    <form id="form_modify_contact" class="mb-10">
                                        <div class="row">
                                            <div class="col-12 pb--20">
                                                <textarea id="contact"><?php echo $contact; ?></textarea>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-sm-6">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <button class="btn btn-primary btn-lg btn-block"
                                                        onclick="saveContact()">Salva
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                                    <h5 class="mb-2">Pagamento</h5>
                                    <p>Configurazione dei dati di pagamento dei corsi</p>
                                    <button type="button"
                                            class="btn btn-outline-info btn-fix-panel-control mt-4"
                                            data-toggle="modal"
                                            data-target="#modifyPaymentModal"
                                            onclick="modalPaymentPerpare()">
                                        Modifica pagamento <i class="fa fa-edit"></i>
                                    </button>
                                    <div class="table-responsive w-100 mt-4" style="max-height: 300px">
                                        <table class="table text-center">
                                            <thead class="text-uppercase bg-dark">
                                            <tr class="text-white">
                                                <th scope="col">Tipo</th>
                                                <th scope="col">Valore</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <strong>IBAN</strong>
                                                </td>
                                                <td>
                                                    <span id="iban"><?php echo $settings[0][DB_IBAN]; ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>Banca</strong>
                                                </td>
                                                <td>
                                                    <span id="bank"><?php echo $settings[0][DB_BANK]; ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>Beneficiario</strong>
                                                </td>
                                                <td>
                                                    <span id="beneficiary"><?php echo $settings[0][DB_BENEFICIARY]; ?></span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- modify payment -->
                                    <div class="modal fade" id="modifyPaymentModal" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifica
                                                        pagamento</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body font-18">
                                                    <div id="alert_validation_payment_fail" class="alert alert-danger"
                                                         role="alert"
                                                         style="display: none">
                                                        Uno o più campi della non sono validi!
                                                    </div>
                                                    <div id="alert_validation_payment_succ" class="alert alert-success"
                                                         role="alert"
                                                         style="display: none">
                                                        Dati modificati!
                                                    </div>
                                                    <form id="form_admin_panel_payment">
                                                        <table class="table">
                                                            <tbody>
                                                            <tr>
                                                                <th>IBAN <i class="fa fa-info-circle"
                                                                            data-container="body" data-toggle="popover"
                                                                            data-placement="top"
                                                                            data-content="Inserire un numero IBAN veritiero"></i>
                                                                </th>
                                                                <td>
                                                                    <input type="text" id="iban_modal_input"
                                                                           class="form-control">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Banca <i class="fa fa-info-circle"
                                                                             data-container="body" data-toggle="popover"
                                                                             data-placement="top"
                                                                             data-content="3-50 Lettere e numeri"></i>
                                                                </th>
                                                                <td>
                                                                    <input type="text" id="bank_modal_input"
                                                                           class="form-control">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Nome Beneficiario <i class="fa fa-info-circle"
                                                                                         data-container="body"
                                                                                         data-toggle="popover"
                                                                                         data-placement="top"
                                                                                         data-content="3-50 Lettere"></i>
                                                                </th>
                                                                <td>
                                                                    <input type="text" id="beneficiary_modal_input"
                                                                           class="form-control">
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                            onclick="modifyPayment()">Salva
                                                    </button>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Chiudi
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5 class="mt-5 mb-2">Giorni scadenza corso</h5>
                                    <p>Giorni prima dell'inizio dei corsi per stabilire la data di chiusure delle
                                        iscrizioni. </p>
                                    <button type="button"
                                            class="btn btn-outline-info btn-fix-panel-control mt-4"
                                            data-toggle="modal"
                                            data-target="#modifyDeadlineModal"
                                            onclick="modalDeadlinePerpare()">
                                        Modifica giorni <i class="fa fa-edit"></i></i>
                                    </button>
                                    <div class="table-responsive w-100 mt-4" style="max-height: 300px">
                                        <table class="table text-center">
                                            <thead class="text-uppercase bg-dark">
                                            <tr class="text-white">
                                                <th scope="col">Tipo</th>
                                                <th scope="col">Valore</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <strong>Giorni scadenza</strong>
                                                </td>
                                                <td>
                                                    <span id="deadline"><?php echo $settings[0][DB_DEADLINE]; ?></span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal fade" id="modifyDeadlineModal" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifica giorni</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body font-18">
                                                    <div id="alert_validation_deadline_fail" class="alert alert-danger"
                                                         role="alert"
                                                         style="display: none">
                                                        Campo non valido!
                                                    </div>
                                                    <div id="alert_validation_deadline_succ" class="alert alert-success"
                                                         role="alert"
                                                         style="display: none">
                                                        Dati modificato!
                                                    </div>
                                                    <form id="form_admin_panel_deadline">
                                                        <table class="table">
                                                            <tbody>
                                                            <tr>
                                                                <th>Giorni scadenza <i class="fa fa-info-circle"
                                                                                       data-container="body"
                                                                                       data-toggle="popover"
                                                                                       data-placement="top"
                                                                                       data-content="Inserire un numero maggiore o uguale a 0"></i>
                                                                </th>
                                                                <td>
                                                                    <input type="number" id="deadline_modal_input"
                                                                           class="form-control">
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                            onclick="modifyDeadline()">Salva
                                                    </button>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Chiudi
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5 class="mt-5 mb-2">Età minima iscrizione</h5>
                                    <p>Grazie a questa tabella può specificare l'età minima per iscriversi ad un
                                        corso.</p>
                                    <button type="button"
                                            class="btn btn-outline-info btn-fix-panel-control mt-4"
                                            data-toggle="modal"
                                            data-target="#modifyMinAgeModal"
                                            onclick="modalMinAgePrepare()">
                                        Modifica giorni <i class="fa fa-edit"></i></i>
                                    </button>
                                    <div class="table-responsive w-100 mt-4" style="max-height: 300px">
                                        <table class="table text-center">
                                            <thead class="text-uppercase bg-dark">
                                            <tr class="text-white">
                                                <th scope="col">Tipo</th>
                                                <th scope="col">Valore</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <strong>Età minima</strong>
                                                </td>
                                                <td>
                                                    <span id="min_age"><?php echo $settings[0][DB_MIN_AGE]; ?></span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal fade" id="modifyMinAgeModal" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifica età
                                                        minima</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body font-18">
                                                    <div id="alert_validation_min_age_fail" class="alert alert-danger"
                                                         role="alert"
                                                         style="display: none">
                                                        Campo non valido!
                                                    </div>
                                                    <div id="alert_validation_min_age_succ" class="alert alert-success"
                                                         role="alert"
                                                         style="display: none">
                                                        Dati modificato!
                                                    </div>
                                                    <form id="form_admin_panel_min_age">
                                                        <table class="table">
                                                            <tbody>
                                                            <tr>
                                                                <th>Età minima <i class="fa fa-info-circle"
                                                                                  data-container="body"
                                                                                  data-toggle="popover"
                                                                                  data-placement="top"
                                                                                  data-content="Inserire un numero maggiore o uguale a 0"></i>
                                                                </th>
                                                                <td>
                                                                    <input type="number" id="min_age_modal_input"
                                                                           class="form-control">
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                            onclick="modifyMinAge()">Salva
                                                    </button>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Chiudi
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5 class="mt-5 mb-2">Tipologie</h5>
                                    <p>Gestione delle tipologie di corsi</p>
                                    <button type="button"
                                            class="btn btn-outline-info btn-fix-panel-control mt-4"
                                            data-toggle="modal"
                                            data-target="#addTypologyModal"
                                            onclick="clearModalTypology()">
                                        Aggiungi tipologia <i class="fa fa-plus"></i></i>
                                    </button>
                                    <h2 class="pt--20 pb--20" id='not_typology' style='text-align: center'>Nessuna
                                        tipologia disponibile</h2>
                                    <div id="table_typology" class="table-responsive w-100 mt-4"
                                         style="max-height: 300px">
                                        <table class="table text-center">
                                            <thead class="text-uppercase bg-dark">
                                            <tr class="text-white">
                                                <th scope="col">Tipologia</th>
                                                <th scope="col">Azioni</th>
                                            </tr>
                                            </thead>
                                            <tbody id="row_typology">
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- add typology -->
                                    <div class="modal fade" id="addTypologyModal" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Aggiungi
                                                        tipologia</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body font-18">
                                                    <div id="alert_validation_typology_fail" class="alert alert-danger"
                                                         role="alert"
                                                         style="display: none">
                                                        Campo non valido!
                                                    </div>
                                                    <div id="alert_validation_typology_exist" class="alert alert-danger"
                                                         role="alert"
                                                         style="display: none">
                                                        Tipologia già aggiunta!
                                                    </div>
                                                    <div id="alert_validation_typology_succ" class="alert alert-success"
                                                         role="alert"
                                                         style="display: none">
                                                        Tipologia aggiunta!
                                                    </div>
                                                    <form id="form_admin_panel_typology">
                                                        <table class="table">
                                                            <tbody>
                                                            <tr>
                                                                <th>Tipologia <i class="fa fa-info-circle"
                                                                                 data-container="body"
                                                                                 data-toggle="popover"
                                                                                 data-placement="top"
                                                                                 data-content="3-50 Lettere e numeri"></i>
                                                                </th>
                                                                <td>
                                                                    <input type="text" id="typology_modal_input"
                                                                           class="form-control">
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                            onclick="addTypology()">Aggiungi
                                                    </button>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Chiudi
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- delete typology -->
                                    <div class="modal fade" id="deleteTypologyModal" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Elimina
                                                        tipologia</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body font-18">
                                                    <div id="alert_typology_deleted" class="alert alert-success"
                                                         role="alert"
                                                         style="display: none">
                                                        Tipologia eliminata!
                                                    </div>
                                                    <div class="text-center">
                                                        <i class="fa fa-warning" style="font-size:48px;"></i>
                                                        <p>Sei sicuro di voler eliminare questa Tipologia? Eliminerai
                                                            anche tutti i corsi di questa tipologia (e gli utenti iscritti non verranno avvisati).</p>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="modal_input_del_typology" disabled>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                            onclick="deleteTypology()">Elimina
                                                    </button>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Chiudi
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
                                    <h5 class="mb-4">Utenti registrati</h5>
                                    <?php if (count($users) != 0): ?>
                                        <table id="user_table"
                                               class="table table-striped table-bordered nowrap text-center"
                                               style="width:100%">
                                            <thead class="text-uppercase bg-dark">
                                            <tr class="text-white">
                                                <th scope="col">Newsletter</th>
                                                <th scope="col">Nome</th>
                                                <th scope="col">Cognome</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Data di nascita</th>
                                                <th scope="col">Via</th>
                                                <th scope="col">Città</th>
                                                <th scope="col">CAP</th>
                                                <th scope="col">Numero telefono mobile</th>
                                                <th scope="col">Numero telefono fisso</th>
                                                <th scope="col">Tipo</th>
                                                <th scope="col">NIP</th>
                                                <th scope="col">Numero di licenza</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($users as $u): ?>
                                                <tr>
                                                    <td>
                                                        <?php echo ($u[DB_USER_NEWSLETTER] == 1) ? "&#10004" : "&#10006"; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $u[DB_USER_FIRSTNAME]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $u[DB_USER_LASTNAME]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $u[DB_USER_EMAIL]; ?>
                                                    </td>
                                                    <td>
                                                        <span style="display:none;"><?php echo $u[DB_USER_BIRTHDAY]; ?></span><?php echo date("d.m.Y", strtotime($u[DB_USER_BIRTHDAY])); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $u[DB_USER_STREET]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $u[DB_USER_CITY]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $u[DB_USER_ZIP]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $u[DB_USER_MOBILE_NUMBER]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo ($u[DB_USER_LANDLINE_NUMBER] == null) ? " -" : $u[DB_USER_LANDLINE_NUMBER]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo ($u[DB_USER_TYPE] == "1") ? "Utente" : "Admin"; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo ($u[DB_USER_NIP] == null) ? " -" : $u[DB_USER_NIP]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo ($u[DB_USER_LICENSE_NUMBER] == null) ? " -" : $u[DB_USER_LICENSE_NUMBER]; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <h4 class='text-center' style="padding-top: 30px;">Non esistono utenti</h4>
                                    <?php endif; ?>
                                    <h5 class="mt-5 mb-4">Newsletter</h5>
                                    <div id="alert_newsletter_ok" class="alert alert-success" role="alert"
                                         style="display: none">
                                        Email inviata!
                                    </div>
                                    <div id="alert_newsletter_fail" class="alert alert-danger" role="alert"
                                         style="display: none">
                                        File contenuti occupano troppa memoria (Max 25MB), file singolo troppo grande (Max 25MB per file) oppure estensione non supportata.
                                    </div>
                                    <form id="form_newsletter" class="mb-10">
                                        <div class="row">
                                            <div class="col-12 pb--20">
                                                <label>Carica file <i class="fa fa-info-circle"
                                                                      data-container="body"
                                                                      data-toggle="popover"
                                                                      data-placement="top"
                                                                      data-content="Max 25MB totali e max 20 files (Estensioni non supportate: .exe, .zip, .rar)"></i></label>
                                                <input type="file" id="files_news" class="mb-4" multiple>
                                                <textarea id="newsletter_text" class="js--trumbowyg"></textarea>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-sm-6">
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <button class="btn btn-primary btn-lg btn-block" onclick="sendNews()">
                                                    Invia <i class="fa fa-refresh fa-spin" id="relo" style="display: none"></i>
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
</div>
<script src="js/adminPanel.js"></script>
<script src="js/managePhoto.js"></script>
<script src="js/manageTypology.js"></script>