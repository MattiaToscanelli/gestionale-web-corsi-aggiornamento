/**
 * Funzione per effettuare il login
 */
function login() {
    var inputs = document.getElementsByTagName("input");
    $.when(
        access(inputs[0].value, inputs[1].value)
    ).done(function (json) {
        var response = json;
        if (response == 1) {
            document.getElementById("alert_validation_login").style.display = "none";
            document.getElementById("alert_validation_ok").style.display = "block";
            document.getElementById("email").style.border = "1px solid #e6e6e6";
            document.getElementById("password").style.border = "1px solid #e6e6e6";
            window.setTimeout(function () {
                window.location.href = URL;
            }, 1000);
        } else {
            document.getElementById("alert_validation_login").style.display = "block";
            document.getElementById("email").style.border = "1px solid red"
            document.getElementById("password").style.border = "1px solid red";
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