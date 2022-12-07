/**
 * Metodo per preparare le due password da inviare al server e a dipendeza della risposta
 * del server mostra delle notifiche all'utente.
 */
function checkAll() {
    var inputs = document.getElementsByTagName("input");
    var formData = new FormData();
    formData.append('password', inputs[0].value);
    formData.append('re_password', inputs[1].value);
    $.when(
        modifyPassword(formData)
    ).done(function (json) {
        var res = json;
        if (res == 1) {
            document.getElementById("alert_validation").style.display = "none";
            inputs[0].style.border = "1px solid #e6e6e6";
            inputs[1].style.border = "1px solid #e6e6e6";
            window.location.replace(URL + "passwordChanged");
        } else {
            document.getElementById("alert_validation").style.display = "block";
            inputs[0].style.border = "1px solid red";
            inputs[1].style.border = "1px solid red";
        }
    });
}

/**
 * Metodo che fa una richiesta al server per modificare la password
 * @param formData Le due password da cambiare
 * @returns {{getAllResponseHeaders: function(): (<T>(...items: *[]) => number|null), abort: function(*=): *, setRequestHeader: function(*=, *): *, readyState: number, getResponseHeader: function(*): (null|*), overrideMimeType: function(*): *, statusCode: function(*=): this}|*}
 */
function modifyPassword(formData) {
    var response;
    return ($.ajax({
        url: (URL + "resetPassword/modifyPassword"),
        type: "POST",
        data: formData,
        success: function (text) {
            response = text;
        },
        contentType: false,
        processData: false
    }));
}