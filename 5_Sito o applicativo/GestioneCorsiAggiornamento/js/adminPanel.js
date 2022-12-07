//Codice per caricare la prewie dell'immagine.
document.getElementById("files").onchange = function () {
    var reader = new FileReader();
    reader.onload = function (e) {
        document.getElementById("image").src = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);
};

//Carico editor html, datatables e tabelle
window.onload = function () {
    $('#user_table').DataTable({
        "language": {
            "lengthMenu": "Mostra _MENU_ utenti per pagina",
            "zeroRecords": "Nessun utente trovato!",
            "info": "Pagina _PAGE_ di _PAGES_",
            "infoEmpty": "Nessun utente trovato!",
            "infoFiltered": ""
        },
        responsive: true
    });
    $('#description_homepage').summernote({
        toolbar: [
            ['font', ['bold', 'italic', 'underline']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ["fontname", ["fontname"]],
            ['table', ['table']],
            ['color', ['color']],
            ['para', ['paragraph']],
            ['height', ['height']]
        ],
        lang: "it-IT",
        fontNames: ["Helvetica", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New", "Poppins"],
        height: 300
    });

    $('#contact').summernote({
        toolbar: [
            ['font', ['bold', 'italic', 'underline']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['table', ['table']],
            ['color', ['color']],
            ['para', ['paragraph']],
            ['height', ['height']]
        ],
        lang: "it-IT",
        fontNames: ["Helvetica", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New", "Lato", "Poppins"],
        height: 300
    });

    $('#newsletter_text').summernote({
        toolbar: [
            ['font', ['bold', 'italic', 'underline']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['table', ['table']],
            ['color', ['color']],
            ['para', ['paragraph']],
            ['height', ['height']]
        ],
        lang: "it-IT",
        fontNames: ["Helvetica", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New", "Lato", "Poppins"],
        height: 300
    });

    $.when(
        getTypologyRow()
    ).done(function (text) {
        if (text == "") {
            document.getElementById("table_typology").style.display = "none";
            document.getElementById("not_typology").style.display = "block";
        } else {
            document.getElementById("table_typology").style.display = "block";
            document.getElementById("not_typology").style.display = "none";
            document.getElementById("row_typology").innerHTML = text;
        }
    });
};

/**
 * Metodo che fa una richiesta al server per ricavare le righe della tabella tipologia.
 * @returns {*|{getAllResponseHeaders: function(): (*|null), abort: function(*=): *, setRequestHeader: function(*=, *): *, readyState: number, getResponseHeader: function(*): (null|*), overrideMimeType: function(*): *, statusCode: function(*=): this}}
 */
function getTypologyRow() {
    var response;
    return ($.ajax({
        url: (URL + "adminPanel/getTypologyRowTable"),
        type: "POST",
        success: function (text) {
            response = text;
        }
    }));
}

/**
 * Metodo per formattare la tabella datatables.
 */
function fixDatatable() {
    setTimeout(function () {
        $('#user_table').DataTable().responsive.recalc();
    }, 200);
}

/**
 * =============================GESTIONE FOTO=============================
 */

/**
 * Metodo per impostare la foto da emilinare
 * @param path La path della foto.
 */
function setInfoPhoto(path) {
    document.getElementById('modal_input_del_photo').value = path;
}

/**
 * Metodo per rimuovere un foto dalla pagina principale.
 */
function deletePhoto() {
    var mp = new ManagePhoto();
    var path = document.getElementById("modal_input_del_photo").value;
    $.when(
        mp.deletePhoto(path)
    ).done(function (json) {
        var checkE = json;
        if (checkE == 1) {
            document.getElementById("alert_photo_deleted").style.display = "block";
            window.setTimeout(function () {
                window.location.replace(URL + "adminPanel");
                location.reload();
            }, 1000);
        } else {
            window.location.replace(URL + "err");
        }
    });
}

/**
 * Metodo per pulire il modale dellle foto.
 */
function clearModalFoto() {
    clearAlert();
    document.getElementById("files").value = "";
    var input = document.getElementById("image");
    input.src = "img/nofoto.png";
}


/**
 * Metodo per agigungere una foto alla pagina principale.
 */
function addDataPhoto() {
    var mp = new ManagePhoto();
    var inFile = document.getElementById("files");
    var files = inFile.files;
    if (files.length > 0) {
        $.when(
            mp.addPhoto(files)
        ).done(function (json) {
            var checkE = json;
            if (checkE == 0) {
                document.getElementById("alert_validation_photo_add_os").style.display = "none";
                document.getElementById("alert_validation_photo_add_specific").style.display = "block";
                document.getElementById("alert_validation_photo_add_ok").style.display = "none";
                document.getElementById("alert_validation_photo_add_file").style.display = "none";
            } else if (checkE == 1) {
                document.getElementById("alert_validation_photo_add_os").style.display = "none";
                document.getElementById("alert_validation_photo_add_specific").style.display = "none";
                document.getElementById("alert_validation_photo_add_ok").style.display = "block";
                document.getElementById("alert_validation_photo_add_file").style.display = "none";
                window.setTimeout(function () {
                    window.location.replace(URL + "adminPanel#foto");
                    location.reload();
                }, 1000);
            } else if (checkE == 2) {
                document.getElementById("alert_validation_photo_add_os").style.display = "block";
                document.getElementById("alert_validation_photo_add_specific").style.display = "none";
                document.getElementById("alert_validation_photo_add_ok").style.display = "none";
                document.getElementById("alert_validation_photo_add_file").style.display = "none";
            } else {
                window.location.replace(URL + "err");
            }
        });
    } else {
        document.getElementById("alert_validation_photo_add_file").style.display = "block";
        document.getElementById("alert_validation_photo_add_specific").style.display = "none";
        document.getElementById("alert_validation_photo_add_os").style.display = "none";
        document.getElementById("alert_validation_photo_add_ok").style.display = "none";
    }
}

/**
 * Metodo per rimovere tutti gli alert.
 */
function clearAlert() {
    var alerts = document.getElementsByClassName("alert");
    for (i = 0; i < alert.length; i++) {
        alerts[i].style.display = "none";
    }
}

/**
 * =============================GESTIONE DESCRIZIONE PAGINA PRICNIPALE=============================
 */

/**
 * Metodo per salvare il testo di descrizione della pagina principale.
 */
function saveDescription() {
    var text = document.getElementById("description_homepage").value;
    document.getElementById("alert_text_ok").style.display = "block";
    window.setTimeout(function () {
        document.getElementById("alert_text_ok").style.display = "none";
    }, 5000);
    $.ajax({
        url: (URL + "adminPanel/saveDescription"),
        type: "POST",
        data: {text: text},
        success: function (response) {
            response = response;
        }
    });
}

/**
 * =============================GESTIONE DESCRIZIONE PAGINA CONTATTI=============================
 */

/**
 * Metodo per salvare il testo della pagina di contatti.
 */
function saveContact() {
    var text = document.getElementById("contact").value;
    document.getElementById("alert_contact_ok").style.display = "block";
    window.setTimeout(function () {
        document.getElementById("alert_contact_ok").style.display = "none";
    }, 5000);
    $.ajax({
        url: (URL + "adminPanel/saveContact"),
        type: "POST",
        data: {text: text},
        success: function (response) {
            response = response;
        }
    });
}

/**
 * =============================GESTIONE IMPOSTAZIONI SITO=============================
 */

/**
 * Metodo per preparare il modale di modifica dati pagamento.
 */
function modalPaymentPerpare() {
    var iban = document.getElementById("iban").textContent;
    var bank = document.getElementById("bank").textContent;
    var beneficiary = document.getElementById("beneficiary").textContent;
    document.getElementById("iban_modal_input").value = iban;
    document.getElementById("bank_modal_input").value = bank;
    document.getElementById("beneficiary_modal_input").value = beneficiary;
    document.getElementById("iban_modal_input").style.border = "1px solid rgba(170, 170, 170, .3)";
    document.getElementById("bank_modal_input").style.border = "1px solid rgba(170, 170, 170, .3)";
    document.getElementById("beneficiary_modal_input").style.border = "1px solid rgba(170, 170, 170, .3)";
    document.getElementById("alert_validation_payment_fail").style.display = "none";
    document.getElementById("alert_validation_payment_succ").style.display = "none";
}

/**
 * Metodo per salvare i dati di pagamento.
 */
function modifyPayment() {
    var inputs = document.getElementById("form_admin_panel_payment").getElementsByTagName("input");
    var formData = new FormData();
    formData.append('iban', inputs[0].value);
    formData.append('bank', inputs[1].value);
    formData.append('beneficiary', inputs[2].value);
    $.when(
        modifyPaymentRe(formData)
    ).done(function (json) {
        if (json[0].status == 1) {
            document.getElementById("alert_validation_payment_succ").style.display = "block";
            document.getElementById("alert_validation_payment_fail").style.display = "none";
            inputs[0].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[1].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[2].style.border = "1px solid rgba(170, 170, 170, .3)";
            document.getElementById("iban").innerText = inputs[0].value;
            document.getElementById("bank").innerText = inputs[1].value;
            document.getElementById("beneficiary").innerText = inputs[2].value;
            window.setTimeout(function () {
                $('#modifyPaymentModal').modal('hide');
            }, 1000);
        } else {
            document.getElementById("alert_validation_payment_succ").style.display = "none";
            document.getElementById("alert_validation_payment_fail").style.display = "block";
            if (json[0].c_iban == 0) {
                inputs[0].style.border = "1px solid red";
            } else {
                inputs[0].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_bank == 0) {
                inputs[1].style.border = "1px solid red";
            } else {
                inputs[1].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_beneficiary == 0) {
                inputs[2].style.border = "1px solid red";
            } else {
                inputs[2].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
        }
    });
}

/**
 * Metodo che fa una richiesta al server per modificare i dati di pagamento.
 * @param formData I dati di pagamento.
 * @returns {{getAllResponseHeaders: function(): (<T>(...items: *[]) => number|null), abort: function(*=): *, setRequestHeader: function(*=, *): *, readyState: number, getResponseHeader: function(*): (null|*), overrideMimeType: function(*): *, statusCode: function(*=): this}|*}
 */
function modifyPaymentRe(formData) {
    var response;
    return ($.ajax({
        url: (URL + "adminPanel/modifyPayment"),
        type: "POST",
        data: formData,
        dataType: "json",
        success: function (text) {
            response = text;
        },
        contentType: false,
        processData: false
    }));
}

/**
 * Metodo per preparare il modale di modifica giorni scadenza.
 */
function modalDeadlinePerpare() {
    var deadline = document.getElementById("deadline").textContent;
    document.getElementById("deadline_modal_input").value = deadline;
    document.getElementById("deadline_modal_input").style.border = "1px solid rgba(170, 170, 170, .3)";
    document.getElementById("alert_validation_deadline_fail").style.display = "none";
    document.getElementById("alert_validation_deadline_succ").style.display = "none";
}

/**
 * Metodo per salvare i dati di pagamento.
 */
function modifyDeadline() {
    var inputs = document.getElementById("form_admin_panel_deadline").getElementsByTagName("input");
    $.when(
        modifyDeadineRe(inputs[0].value)
    ).done(function (json) {
        if (json == 1) {
            document.getElementById("alert_validation_deadline_succ").style.display = "block";
            document.getElementById("alert_validation_deadline_fail").style.display = "none";
            inputs[0].style.border = "1px solid rgba(170, 170, 170, .3)";
            document.getElementById("deadline").innerText = inputs[0].value;
            window.setTimeout(function () {
                $('#modifyDeadlineModal').modal('hide');
            }, 1000);
        } else {
            document.getElementById("alert_validation_deadline_succ").style.display = "none";
            document.getElementById("alert_validation_deadline_fail").style.display = "block";
            inputs[0].style.border = "1px solid red";
        }
    });
}

/**
 * Metodo che fa una richiesta al server per modificare i giorni di scedenza.
 * @param deadline I giorni di scedenza.
 * @returns {{getAllResponseHeaders: function(): (<T>(...items: *[]) => number|null), abort: function(*=): *, setRequestHeader: function(*=, *): *, readyState: number, getResponseHeader: function(*): (null|*), overrideMimeType: function(*): *, statusCode: function(*=): this}|*}
 */
function modifyDeadineRe(deadline) {
    var response;
    return ($.ajax({
        url: (URL + "adminPanel/modifyDeadline"),
        type: "POST",
        data: {day_deadline: deadline},
        success: function (text) {
            response = text;
        }
    }));
}

/**
 * Metodo per preparare il modale di modifica anni minimi.
 */
function modalMinAgePrepare() {
    var minAge = document.getElementById("min_age").textContent;
    document.getElementById("min_age_modal_input").value = minAge;
    document.getElementById("min_age_modal_input").style.border = "1px solid rgba(170, 170, 170, .3)";
    document.getElementById("alert_validation_min_age_fail").style.display = "none";
    document.getElementById("alert_validation_min_age_succ").style.display = "none";
}

/**
 * Metodo per salvare gli anni minimi.
 */
function modifyMinAge() {
    var inputs = document.getElementById("form_admin_panel_min_age").getElementsByTagName("input");
    $.when(
        modifyMinAgeRe(inputs[0].value)
    ).done(function (json) {
        if (json == 1) {
            document.getElementById("alert_validation_min_age_succ").style.display = "block";
            document.getElementById("alert_validation_min_age_fail").style.display = "none";
            inputs[0].style.border = "1px solid rgba(170, 170, 170, .3)";
            document.getElementById("min_age").innerText = inputs[0].value;
            window.setTimeout(function () {
                $('#modifyMinAgeModal').modal('hide');
            }, 1000);
        } else {
            document.getElementById("alert_validation_min_age_succ").style.display = "none";
            document.getElementById("alert_validation_min_age_fail").style.display = "block";
            inputs[0].style.border = "1px solid red";
        }
    });
}

/**
 * Metodo che fa una richiesta al server per modificare gli anni minimi per iscriversi ad un corso.
 * @param minAge Gli anni minimi.
 * @returns {{getAllResponseHeaders: function(): (<T>(...items: *[]) => number|null), abort: function(*=): *, setRequestHeader: function(*=, *): *, readyState: number, getResponseHeader: function(*): (null|*), overrideMimeType: function(*): *, statusCode: function(*=): this}|*}
 */
function modifyMinAgeRe(minAge) {
    var response;
    return ($.ajax({
        url: (URL + "adminPanel/modifyMinAge"),
        type: "POST",
        data: {min_age: minAge},
        success: function (text) {
            response = text;
        }
    }));
}

/**
 * Metodo per pulire il modal di aggiunta tipologia.
 */
function clearModalTypology() {
    document.getElementById("alert_validation_typology_fail").style.display = "none";
    document.getElementById("alert_validation_typology_exist").style.display = "none";
    document.getElementById("alert_validation_typology_succ").style.display = "none";
    document.getElementById("typology_modal_input").style.border = "1px solid rgba(170, 170, 170, .3)";
    document.getElementById("typology_modal_input").value = "";
}

/**
 * Metodo per aggiungere una tipologia.
 */
function addTypology() {
    var input = document.getElementById("typology_modal_input");
    var mt = new ManageTypology();
    $.when(
        mt.addTypologyRe(input.value)
    ).done(function (json) {
        var checkE = json;
        if (checkE == 1) {
            document.getElementById("alert_validation_typology_fail").style.display = "none";
            document.getElementById("alert_validation_typology_exist").style.display = "none";
            document.getElementById("alert_validation_typology_succ").style.display = "block";
            document.getElementById("typology_modal_input").style.border = "1px solid rgba(170, 170, 170, .3)";
            $.when(
                getTypologyRow()
            ).done(function (text) {
                if (text == "") {
                    document.getElementById("table_typology").style.display = "none";
                    document.getElementById("not_typology").style.display = "block";
                } else {
                    document.getElementById("table_typology").style.display = "block";
                    document.getElementById("not_typology").style.display = "none";
                    document.getElementById("row_typology").innerHTML = text;
                }
            });
            window.setTimeout(function () {
                $('#addTypologyModal').modal('hide');
            }, 1000);
        } else if (checkE == 2) {
            document.getElementById("alert_validation_typology_fail").style.display = "none";
            document.getElementById("alert_validation_typology_exist").style.display = "block";
            document.getElementById("alert_validation_typology_succ").style.display = "none";
            document.getElementById("typology_modal_input").style.border = "1px solid red";
        } else {
            document.getElementById("alert_validation_typology_fail").style.display = "block";
            document.getElementById("alert_validation_typology_exist").style.display = "none";
            document.getElementById("alert_validation_typology_succ").style.display = "none";
            document.getElementById("typology_modal_input").style.border = "1px solid red";
        }
    });
}

/**
 * Metodo per impostare la tipologia da eliminare
 * @param name Il nome della tipologia da eliminare
 */
function setInfoTypology(name) {
    document.getElementById('alert_typology_deleted').style.display = "none";
    document.getElementById('modal_input_del_typology').value = name;
}

/**
 * Metodo per rimuovere una tipologia di corso.
 */
function deleteTypology() {
    var mt = new ManageTypology();
    var name = document.getElementById('modal_input_del_typology').value;
    $.when(
        mt.deleteTypology(name)
    ).done(function (json) {
        var checkE = json;
        if (checkE == 1) {
            document.getElementById("alert_typology_deleted").style.display = "block";
            $.when(
                getTypologyRow()
            ).done(function (text) {
                if (text == "") {
                    document.getElementById("table_typology").style.display = "none";
                    document.getElementById("not_typology").style.display = "block";
                } else {
                    document.getElementById("table_typology").style.display = "block";
                    document.getElementById("not_typology").style.display = "none";
                    document.getElementById("row_typology").innerHTML = text;
                }
            });
            window.setTimeout(function () {
                $('#deleteTypologyModal').modal('hide');
            }, 1000);
        } else {
            window.location.replace(URL + "err");
        }
    });
}

/**
 * Metodo per inviare una email della newsletter.
 */
function sendNews() {
    var text = document.getElementById("newsletter_text").value;
    if(text == ""){
        text = "Nessun contenuto";
    }
    var inFile = document.getElementById("files_news");
    var files = inFile.files;
    var c = 0;
    for(var i = 0; files.length > i; i++){
        c += files[i].size;
        if(files[i].name.split('.').pop().localeCompare("zip") != -1 || files[i].name.split('.').pop().localeCompare("rar") != -1 || files[i].name.split('.').pop().localeCompare("exe") != -1 ){
            c += 25000000;
        }
    }
    if(c > 25000000 || files.length > 20){
        document.getElementById("alert_newsletter_fail").style.display = "block";
        document.getElementById("alert_newsletter_ok").style.display = "none";
        window.setTimeout(function () {
            document.getElementById("alert_newsletter_fail").style.display = "none";
        }, 5000);
    }else{
        $.when(
            sendEmail(files, text)
        ).done(function (json) {
            var checkE = json;
            if (checkE == 1) {
                document.getElementById("alert_newsletter_fail").style.display = "none";
                document.getElementById("alert_newsletter_ok").style.display = "block";
                window.setTimeout(function () {
                    document.getElementById("alert_newsletter_ok").style.display = "none";
                }, 5000);
            } else {
                window.location.replace(URL + "err");
            }
        });
    }
}

/**
 * Metodo che fa la richiesta al server per inviare la email della newsletter.
 * @param files La lista di file da inviare.
 * @param text Il contenuto della email.
 * @returns {*|{getAllResponseHeaders: (function(): *), abort: (function(*=): *), setRequestHeader: (function(*=, *): *), readyState: number, getResponseHeader: (function(*): *), overrideMimeType: (function(*): *), statusCode: (function(*=): T)}}
 */
function sendEmail(files, text) {
    var formData = new FormData();
    for (var i = 0; i < files.length; i++) {
        formData.append('files' + i, files[i]);
    }
    formData.append('text', text);
    var response;
    return ($.ajax({
        url: (URL + "adminPanel/sendNewsMail"),
        type: "POST",
        data: formData,
        success: function (text) {
            response = text;
        },
        contentType: false,
        processData: false
    }));
}