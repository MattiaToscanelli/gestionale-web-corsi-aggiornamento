/**
 * Carico gli orari e i posti disponibili di uno svolgimento.
 */
changeData();

/**
 * Funzione per effettuare il login
 */
function login() {
    var inputs = document.getElementsByClassName("login");
    $.when(
        access(inputs[0].value, inputs[1].value)
    ).done(function (json) {
        var response = json;
        if (response == 1) {
            document.getElementById("alert_validation_login").style.display = "none";
            inputs[0].style.border = "1px solid #e6e6e6";
            inputs[1].style.border = "1px solid #e6e6e6";
            window.location.replace(URL + "enerollmentCourse");
            location.reload();
        } else {
            document.getElementById("alert_validation_login").style.display = "block";
            inputs[0].style.border = "1px solid red"
            inputs[1].style.border = "1px solid red";
        }
    });
}

/**
 * Metodo per effettuare l'accesso al sito.
 * @param email_val L'email dell'utente.
 * @param password_val La password dell'utente.
 * @returns {{getAllResponseHeaders: function(): (<T>(...items: *[]) => number|null), abort: function(*=): *, setRequestHeader: function(*=, *): *, readyState: number, getResponseHeader: function(*): (null|*), overrideMimeType: function(*): *, statusCode: function(*=): this}|*}
 */
function access(email_val, password_val) {
    var email = email_val;
    var password = password_val;
    var response;
    return ($.ajax({
        url: (URL + "login/access"),
        type: "POST",
        data: {email: email, password: password},
        success: function (text) {
            response = text;
        }
    }));
}

/**
 * Variabile per eseguire il toggle delle password.
 */
var d = 0;

/**
 * Metodo per mostrare/rimovere gli input password nella pagina di iscrizione.
 */
function togglePassword() {
    var divPass = document.getElementsByClassName("pass");
    if (d % 2 == 0) {
        for (var i = 0; i < divPass.length; i++) {
            divPass[i].style.display = "block";
        }
    } else {
        for (var i = 0; i < divPass.length; i++) {
            divPass[i].style.display = "none";
        }
    }
    d++;
}

/**
 * Variabile per eseguire il toggle del pranzo.
 */
var f = 0;

/**
 * Metodo per eseguire il toggle del pranzo nella pagina di iscrizione.
 */
function toggleFood() {
    var inputFood = document.getElementsByClassName("fod");
    if (f % 2 == 0) {
        for (var i = 0; i < inputFood.length; i++) {
            inputFood[i].disabled = false;
        }
    } else {
        for (var i = 0; i < inputFood.length; i++) {
            inputFood[i].disabled = true;
        }
    }
    f++;
}

/**
 * Metodo per mostrare gli orari e i posti disponibili di un determinato svolgimento.
 */
function changeData() {
    var val = document.getElementById("date").value;
    var dataHours = document.getElementsByClassName("hours");
    for (var i = 0; i < dataHours.length; i++) {
        dataHours[i].style.display = "none";
    }
    document.getElementById("hours" + val).style.display = "block";
}

/**
 * Metodo per convalidare tutti i dati di un corso.
 */
function checkAll() {
    var inputs = document.getElementsByClassName("enr");
    var password = document.getElementsByClassName("ps");
    var email = document.getElementsByClassName("em");
    var logged = document.getElementsByClassName("logged");
    var incluFood = document.getElementsByClassName("incluFood");
    var save = (logged.length > 0) ? ((document.querySelector('input[name="save"]:checked').value == "Y") ? true : false) : false;
    var food = (incluFood.length > 0) ? (document.querySelector('input[name="food"]:checked').value == "Y") ? true : false : false;
    var date = document.getElementById("date").value;

    var formData = new FormData();
    formData.append('g-recaptcha', grecaptcha.getResponse());
    formData.append('firstname', inputs[0].value);
    formData.append('lastname', inputs[1].value);
    formData.append('birthday', inputs[2].value);
    formData.append('street', inputs[3].value);
    formData.append('city', inputs[4].value);
    formData.append('zip', inputs[5].value);
    formData.append('mobile_number', inputs[6].value);
    formData.append('landline_number', inputs[7].value);
    formData.append('license_number', inputs[8].value);
    formData.append('nip', inputs[9].value);
    formData.append('save', save);
    formData.append('logged', logged.length == 0);
    formData.append('inclu_food', incluFood.length == 0);
    if (save) {
        formData.append('password', password[0].value);
        formData.append('re_password', password[1].value);
        var newsletter = (document.querySelector('input[name="newsletter"]:checked').value == "Y") ? true : false;
        formData.append('newsletter', newsletter);
    }
    if (email.length > 0) {
        formData.append('email', email[0].value);
    }
    if (incluFood.length > 0) {
        formData.append('food', food);
        if (food) {
            formData.append('food_type', inputs[10].value);
            formData.append('intolerances', inputs[11].value);
        }
    }
    formData.append('id_execution', date);

    $.when(
        enrollExecution(formData)
    ).done(function (json) {
        if (json[0].status == 1) {
            document.getElementById("alert_validation").style.display = "none";
            document.getElementById("alert_validation_data_full").style.display = "none";
            document.getElementById("alert_validation_overlap").style.display = "none";
            document.getElementById("alert_validation_email").style.display = "none";
            document.getElementById("alert_validation_captcha").style.display = "none";
            inputs[0].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[1].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[2].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[3].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[4].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[5].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[6].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[7].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[8].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[9].style.border = "1px solid rgba(170, 170, 170, .3)";
            if (incluFood.length > 0) {
                if (food) {
                    inputs[10].style.border = "1px solid rgba(170, 170, 170, .3)";
                    inputs[11].style.border = "1px solid rgba(170, 170, 170, .3)";
                }
            }
            if (save) {
                password[0].style.border = "1px solid rgba(170, 170, 170, .3)";
                password[1].style.border = "1px solid rgba(170, 170, 170, .3)"
            }
            if (email.length > 0) {
                email[0].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            window.location.replace(URL + "enrollAdded");
        } else {
            grecaptcha.reset();
            document.getElementById("alert_validation").style.display = "block";
            if (json[0].c_firstname == 0) {
                inputs[0].style.border = "1px solid red";
            } else {
                inputs[0].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_lastname == 0) {
                inputs[1].style.border = "1px solid red";
            } else {
                inputs[1].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_birthday == 0) {
                inputs[2].style.border = "1px solid red";
            } else {
                inputs[2].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_street == 0) {
                inputs[3].style.border = "1px solid red";
            } else {
                inputs[3].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_city == 0) {
                inputs[4].style.border = "1px solid red";
            } else {
                inputs[4].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_zip == 0) {
                inputs[5].style.border = "1px solid red";
            } else {
                inputs[5].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_mobile_number == 0) {
                inputs[6].style.border = "1px solid red";
            } else {
                inputs[6].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_landline_number == 0) {
                inputs[7].style.border = "1px solid red";
            } else {
                inputs[7].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_license_number == 0) {
                inputs[8].style.border = "1px solid red";
            } else {
                inputs[8].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_nip == 0) {
                inputs[9].style.border = "1px solid red";
            } else {
                inputs[9].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_overlap == 0) {
                document.getElementById("alert_validation_overlap").style.display = "block";
            } else {
                document.getElementById("alert_validation_overlap").style.display = "none";
            }
            if (json[0].c_execution_full == 0) {
                document.getElementById("date").style.border = "1px solid red";
                document.getElementById("alert_validation_data_full").style.display = "block";
            } else {
                document.getElementById("date").style.border = "1px solid rgba(170, 170, 170, .3)";
                document.getElementById("alert_validation_data_full").style.display = "none";
            }
            if (incluFood.length > 0) {
                if (food) {
                    if (json[0].c_food_type == 0) {
                        inputs[10].style.border = "1px solid red";
                    } else {
                        inputs[10].style.border = "1px solid rgba(170, 170, 170, .3)";
                    }
                    if (json[0].c_intolerances == 0) {
                        inputs[11].style.border = "1px solid red";
                    } else {
                        inputs[11].style.border = "1px solid rgba(170, 170, 170, .3)";
                    }
                }
            }
            if (save) {
                if (json[0].c_password == 0) {
                    password[0].style.border = "1px solid red";
                } else {
                    password[0].style.border = "1px solid rgba(170, 170, 170, .3)";
                }
                if (json[0].c_password == 0) {
                    password[1].style.border = "1px solid red";
                } else {
                    password[1].style.border = "1px solid rgba(170, 170, 170, .3)";
                }
            }
            if (email.length > 0) {
                if (json[0].c_email == 0) {
                    document.getElementById("alert_validation_email").style.display = "block";
                    email[0].style.border = "1px solid red";
                } else {
                    document.getElementById("alert_validation_email").style.display = "none";
                    email[0].style.border = "1px solid rgba(170, 170, 170, .3)";
                }
            } else {
                document.getElementById("alert_validation_email").style.display = "none";
            }
            if (json[0].c_captcha == 1) {
                document.getElementById("alert_validation_captcha").style.display = "none";
            } else {
                document.getElementById("alert_validation_captcha").style.display = "block";
            }
        }
    });
}

/**
 * Metodo che fa una richiesta al server per aggiungere un iscrizione.
 * @param formData L'iscrizione da aggiungere.
 * @returns {{getAllResponseHeaders: function(): (<T>(...items: *[]) => number|null), abort: function(*=): *, setRequestHeader: function(*=, *): *, readyState: number, getResponseHeader: function(*): (null|*), overrideMimeType: function(*): *, statusCode: function(*=): this}|*}
 */
function enrollExecution(formData) {
    var response;
    return ($.ajax({
        url: (URL + "enrollmentCourse/addEnrollment"),
        type: "POST",
        dataType: "json",
        data: formData,
        success: function (text) {
            response = text;
        },
        contentType: false,
        processData: false
    }));
}

/**
 * Metodo per scaricare il corso.
 */
function printCourse() {
    window.print();
}