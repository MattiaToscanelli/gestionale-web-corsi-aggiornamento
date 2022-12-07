/**
 * Carico la libreria Datatables nella tabella con id enrollment_table.
 */
window.onload = function () {
    $('#enrollment_table').DataTable({
        "language": {
            "lengthMenu": "Mostra _MENU_ iscrizioni per pagina",
            "zeroRecords": "Nessuna iscrizione trovata!",
            "info": "Pagina _PAGE_ di _PAGES_",
            "infoEmpty": "Nessuna iscrizione trovata!",
            "infoFiltered": ""
        },
        responsive: "true"
    });
};

/**
 * Metodo per stabilire se un utente ha pagato oppure no.
 * @param x La checkbox.
 * @param id L'id dell'iscrizione.+
 */
function paid(x, id) {
    var formData = new FormData();
    formData.append('flag_paid', x.checked);
    formData.append('id', id);
    $.ajax({
        url: (URL + "managementExecution/enrollmentPaid"),
        type: "POST",
        data: formData,
        contentType: false,
        processData: false
    });
}

/**
 * Metodo per convalidare tutti i dati di un corso.
 */
function checkAll(idE) {
    var inputs = document.getElementsByClassName("enr");
    var incluFood = document.getElementsByClassName("incluFood");
    var food = (incluFood.length > 0) ? (document.querySelector('input[name="food"]:checked').value == "Y") ? true : false : false;

    var formData = new FormData();
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
    formData.append('email', inputs[10].value);
    formData.append('inclu_food', incluFood.length == 0);
    if (incluFood.length > 0) {
        formData.append('food', food);
        if (food) {
            formData.append('food_type', inputs[11].value);
            formData.append('intolerances', inputs[12].value);
        }
    }
    formData.append('id_execution', idE);

    $.when(
        enrollExecution(formData)
    ).done(function (json) {
        if (json[0].status == 1) {
            document.getElementById("alert_validation").style.display = "none";
            document.getElementById("alert_validation_overlap").style.display = "none";
            document.getElementById("alert_validation_email").style.display = "none";
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
            inputs[10].style.border = "1px solid rgba(170, 170, 170, .3)";
            if (incluFood.length > 0) {
                if (food) {
                    inputs[11].style.border = "1px solid rgba(170, 170, 170, .3)";
                    inputs[12].style.border = "1px solid rgba(170, 170, 170, .3)";
                }
            }
            document.getElementById("alert_validation_ok").style.display = "block";
            window.setTimeout(function () {
                window.location.replace(URL + "managementExecution");
                location.reload();
            }, 1000);
        } else {
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
            if (json[0].c_email == 0) {
                document.getElementById("alert_validation_email").style.display = "block";
                inputs[10].style.border = "1px solid red";
            } else {
                document.getElementById("alert_validation_email").style.display = "none";
                inputs[10].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_overlap == 0) {
                document.getElementById("alert_validation_overlap").style.display = "block";
            } else {
                document.getElementById("alert_validation_overlap").style.display = "none";
            }
            if (incluFood.length > 0) {
                if (food) {
                    if (json[0].c_food_type == 0) {
                        inputs[11].style.border = "1px solid red";
                    } else {
                        inputs[11].style.border = "1px solid rgba(170, 170, 170, .3)";
                    }
                    if (json[0].c_intolerances == 0) {
                        inputs[12].style.border = "1px solid red";
                    } else {
                        inputs[12].style.border = "1px solid rgba(170, 170, 170, .3)";
                    }
                }
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
        url: (URL + "managementExecution/addEnrollment"),
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
 * Metodo per impostare l'iscrizione da eliminare.
 * @param id L'id dell'iscrizione da eliminare.
 */
function setInfoEnrollment(id) {
    document.getElementById("alert_enrollment_deleted").style.display = "none";
    document.getElementById('alert_enrollment_date').style.display = "none";
    document.getElementById('modal_input_del_enrollment').value = id;
}

/**
 * Metodo per rimuovere un'iscrizione.
 */
function deleteEnrollment() {
    var id = document.getElementById("modal_input_del_enrollment").value;
    $.when(
        deleteEnrollmentRe(id)
    ).done(function (json) {
        var checkE = json;
        if (checkE == 1) {
            document.getElementById("alert_enrollment_deleted").style.display = "block";
            document.getElementById("alert_enrollment_date").style.display = "none";
            window.setTimeout(function () {
                window.location.replace(URL + "managementExecution");
                location.reload();
            }, 1000);
        } else if (checkE == 2) {
            document.getElementById("alert_enrollment_date").style.display = "block";
        } else {
            window.location.replace(URL + "err");
        }
    });
}

/**
 * Metodo per eliminare un'iscrizione.
 * @param id L'id dell'iscrzione da eliminare.
 * @returns {*} Una risposta di come è andata la modifica sul server.
 */
function deleteEnrollmentRe(id) {
    var response;
    return ($.ajax({
        url: (URL + "managementExecution/deleteEnrollment"),
        type: "POST",
        data: {id: id},
        success: function (text) {
            response = text;
        }
    }));
}