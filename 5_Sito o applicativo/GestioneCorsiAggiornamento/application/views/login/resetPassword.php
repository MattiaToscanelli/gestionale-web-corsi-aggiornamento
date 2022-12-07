<title>Cambia Password</title>
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
                    <h4>Cambia Password</h4>
                </div>
                <div class="login-form-body">
                    <div id="alert_validation" class="alert alert-danger" style="display:none;" role="alert">
                        Password non valide o non corrispondenti.
                    </div>
                    <p class="text-center mb-5">Inserisci una nuova password, ripetila e poi premi Cambia. Dopodiché
                        potrai utilizzare la nuova
                        password per accedere. La password deve avere almeno 8 caratteri e numero/carattere
                        speciale.</p>
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" id="password1" class="form-control">
                    <label for="exampleInputPassword2" class="pt--20"">Ripeti password</label>
                    <input type="password" id="password2" class="form-control">
                    <div class="submit-btn-area pt--20">
                        <input type="button" class="btn btn-info mb-3 w-100" onclick="checkAll()" role="button"
                               style="font-family:'Poppins', sans-serif;" value="Cambia"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="js/resetPassword.js"></script>
