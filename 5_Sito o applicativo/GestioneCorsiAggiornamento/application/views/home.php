<title>Home</title>
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
                <a class="nav-link active" href="<?php echo URL; ?>">Home<span class="sr-only">(current)</span></a>
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
                            <h2 class="mb-5 text-center">Home</h2>
                            <div id="carouselExampleIndicators" class="carousel slide m-auto" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?php for ($i = 0; $i < count($pictures); $i++): ?>
                                        <?php if ($i == 0): ?>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="0"
                                                class="active"></li>
                                        <?php else: ?>
                                            <li data-target="#carouselExampleIndicators"
                                                data-slide-to="<?php echo $i; ?>"></li>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </ol>
                                <div class="carousel-inner">
                                    <?php for ($i = 0; $i < count($pictures); $i++): ?>
                                        <?php if ($i == 0): ?>
                                            <div class="carousel-item active"
                                                 style="background-image: url(<?php echo $pictures[$i][DB_PATH_PHOTO]; ?>); background-color: grey"></div>
                                        <?php else: ?>
                                            <div class="carousel-item"
                                                 style="background-image: url(<?php echo $pictures[$i][DB_PATH_PHOTO]; ?>);background-color: grey"></div>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                   data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                   data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <?php if ($text != ""): ?>
                                <div class="pt--40 text-justify m-auto">
                                    <?php echo $text; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div/>