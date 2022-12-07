<title>Passwod dimenticata?</title>
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
            <form action="<?php echo URL; ?>forgotPassword/sendEmail" id="send_link_psw" method="POST">
                <div class="login-form-head">
                    <h4>Password dimenticata?</h4>
                    <p>Inserisci la tua email e ti invieremo un link di recupero password!</p>
                </div>
                <div class="login-form-body">
                    <label for="exampleInputEmail1">Email</label>
                    <input name="email" type="email" id="email" class="form-control">
                    <div class="submit-btn-area pt--20">
                        <input type="submit" class="btn btn-info mb-3 w-100" role="button"
                               style="font-family:'Poppins', sans-serif;" value="Invia"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- login area end -->