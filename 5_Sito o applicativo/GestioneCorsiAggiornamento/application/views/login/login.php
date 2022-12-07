<title>Login</title>
</head>

<body>
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
<!-- login area start -->
<div class="login-area">
    <div class="container">
        <div class="login-box ptb--100">
            <form>
                <div class="login-form-head">
                    <h4>Login</h4>
                    <p>Ciao, inserisci i tuoi dati per accedere al sito!</p>
                </div>
                <div class="login-form-body">
                    <div id="alert_validation_login" class="alert alert-danger mb-5" role="alert" style="display: none">
                        Email o password errati!
                    </div>
                    <div id="alert_validation_ok" class="alert alert-success mb-5" role="alert" style="display: none">
                        Accesso eseguito!
                    </div>
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" id="email" class="form-control">
                    <label for="exampleInputPassword1" class="pt--10">Password</label>
                    <input type="password" id="password" class="form-control">
                    <div class="form-gp pt--10">
                        <a href="<?php echo URL . 'forgotPassword'; ?>">Password dimenticata?</a>
                    </div>
                    <div class="text-center">
                        <input type="button" class="btn btn-info mb-3 w-100" style="font-family:'Poppins', sans-serif;"
                               onclick="login()" value="Accedi"/>
                    </div>
                    <div class="text-center">
                        <a type="button" class="btn btn-outline-info mb-3 w-100" href="<?php echo URL; ?>">Torna alla
                            home</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- login area end -->
<script src="js/login.js"></script>