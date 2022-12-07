/**
 * Carico la libreria Datatables nella tabella con id course_table e execution_table.
 */
window.onload = function () {
    $('#todo_table').DataTable({
        "language": {
            "lengthMenu": "Mostra _MENU_ corsi per pagina",
            "zeroRecords": "Nessun corso trovato!",
            "info": "Pagina _PAGE_ di _PAGES_",
            "infoEmpty": "Nessun corso trovato!",
            "infoFiltered": ""
        },
        responsive: "true"
    });

    $('#done_table').DataTable({
        "language": {
            "lengthMenu": "Mostra _MENU_ corsi per pagina",
            "zeroRecords": "Nessun corso trovato!",
            "info": "Pagina _PAGE_ di _PAGES_",
            "infoEmpty": "Nessun corso trovato!",
            "infoFiltered": ""
        },
        responsive: "true"
    });
};

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
                window.location.replace(URL + "profile");
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