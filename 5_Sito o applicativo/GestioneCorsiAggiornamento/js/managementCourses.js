/**
 * Carico la libreria Datatables nella tabella con id course_table e execution_table.
 */
window.onload = function () {
    $('#course_table').DataTable({
        "language": {
            "lengthMenu": "Mostra _MENU_ corsi per pagina",
            "zeroRecords": "Nessun corso trovato!",
            "info": "Pagina _PAGE_ di _PAGES_",
            "infoEmpty": "Nessun corso trovato!",
            "infoFiltered": ""
        },
        responsive: "true"
    });

    $('#execution_table').DataTable({
        "language": {
            "lengthMenu": "Mostra _MENU_ svolgimenti per pagina",
            "zeroRecords": "Nessun svolgimento trovato!",
            "info": "Pagina _PAGE_ di _PAGES_",
            "infoEmpty": "Nessun svolgimento trovato!",
            "infoFiltered": ""
        },
        responsive: "true"
    });
};

/**
 * Metodo per impostare il corso da eliminare.
 * @param id L'id del corso da eliminare.
 */
function setInfoCourse(id) {
    document.getElementById('alert_course_deleted').style.display = "none";
    document.getElementById('modal_input_del_course').value = id;
}

/**
 * Metodo per rimuovere un corso.
 */
function deleteCourse() {
    var id = document.getElementById("modal_input_del_course").value;
    $.when(
        deleteCourseRe(id)
    ).done(function (json) {
        var checkE = json;
        if (checkE == 1) {
            document.getElementById("alert_course_deleted").style.display = "block";
            window.setTimeout(function () {
                window.location.replace(URL + "managementCourses");
                location.reload();
            }, 1000);
        } else {
            window.location.replace(URL + "err");
        }
    });
}

/**
 * Metodo per eliminare un corso.
 * @param id L'id del corso da eliminare.
 * @returns {*} Una risposta di come è andata la modifica sul server.
 */
function deleteCourseRe(id) {
    var response;
    return ($.ajax({
        url: (URL + "managementCourses/deleteCourse"),
        type: "POST",
        data: {id: id},
        success: function (text) {
            response = text;
        }
    }));
}

/**
 * Metodo per impostare lo svolgimento da eliminare.
 * @param id L'id dello svolgimento da eliminare.
 */
function setInfoExecution(id) {
    document.getElementById('alert_execution_deleted').style.display = "none";
    document.getElementById('modal_input_del_execution').value = id;
}

/**
 * Metodo per rimuovere uno svolgimento.
 */
function deleteExecution() {
    var id = document.getElementById("modal_input_del_execution").value;
    $.when(
        deleteExecutionRe(id)
    ).done(function (json) {
        var checkE = json;
        if (checkE == 1) {
            document.getElementById("alert_execution_deleted").style.display = "block";
            window.setTimeout(function () {
                window.location.replace(URL + "managementCourses");
                location.reload();
            }, 1000);
        } else {
            window.location.replace(URL + "err");
        }
    });
}

/**
 * Metodo per eliminare uno svoglimetno.
 * @param id L'id dello svolgimento da eliminare.
 * @returns {*} Una risposta di come è andata la modifica sul server.
 */
function deleteExecutionRe(id) {
    var response;
    return ($.ajax({
        url: (URL + "managementCourses/deleteExecution"),
        type: "POST",
        data: {id: id},
        success: function (text) {
            response = text;
        }
    }));
}

/**
 * Metodo per formattare una data.
 * @param date La data da formattare.
 * @returns {string} La data formattata.
 */
function getDateFormat(date) {
    var d = new Date(date);
    var dd = d.getDate();
    var mm = d.getMonth() + 1;
    var yyyy = d.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    return dd + '.' + mm + '.' + yyyy;
}

/**
 * Metodo per preparare il modale di creazione di uno svolgimento.
 * @param id L'id del corso di riferimento
 */
function prepareExecution(id) {
    document.getElementById("alert_validation_date_fail").style.display = "none";
    document.getElementById("alert_validation_execution_succ").style.display = "none";
    document.getElementById("alert_validation_hours_fail").style.display = "none";
    document.getElementById("alert_validation_overlap").style.display = "none";
    var form = document.getElementById("form_add_execution");
    var inputs = form.getElementsByTagName("input");
    var selects = form.getElementsByTagName("select");
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].style.border = "1px solid rgba(170, 170, 170, .3)";
    }
    for (var i = 0; i < selects.length; i++) {
        selects[i].style.border = "1px solid rgba(170, 170, 170, .3)";
    }
    $.when(
        getDeadline()
    ).done(function (result) {
        var min = new Date();
        min.setDate(min.getDate() + Number(result) + 1);
        var dd = min.getDate();
        var mm = min.getMonth() + 1;
        var yyyy = min.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        min = yyyy + '-' + mm + '-' + dd;
        var day1 = dd + '.' + mm + '.' + yyyy;
        var deadline = new Date(min);
        deadline.setDate(deadline.getDate() - Number(result));
        document.getElementById("deadline_date").innerText = getDateFormat(deadline);
        document.getElementById("in_date").value = min;
        document.getElementById("day1").innerText = day1;
        document.getElementById("in_date").setAttribute("min", min);
        document.getElementsByTagName("modal_input_add_exe").value = id;
    });
}

/**
 * Metodo per ricavare i giorni per calcolare la data di scafenza.
 * @returns {*|{getAllResponseHeaders: function(): (*|null), abort: function(*=): *, setRequestHeader: function(*=, *): *, readyState: number, getResponseHeader: function(*): (null|*), overrideMimeType: function(*): *, statusCode: function(*=): this}}
 */
function getDeadline() {
    var response;
    return ($.ajax({
        url: (URL + "managementCourses/getDeadline"),
        type: "POST",
        success: function (text) {
            response = text;
        }
    }));
}

/**
 * Metodo per ricavare tutti i docenti che possono insegnare un corso.
 * @returns {*|{getAllResponseHeaders: function(): (*|null), abort: function(*=): *, setRequestHeader: function(*=, *): *, readyState: number, getResponseHeader: function(*): (null|*), overrideMimeType: function(*): *, statusCode: function(*=): this}}
 */
function getTeachers() {
    var response;
    return ($.ajax({
        url: (URL + "managementCourses/getTeachers"),
        type: "POST",
        success: function (text) {
            response = text;
        }
    }));
}

/**
 * Metodo per aggiornare la data di scadenza di uno svolgimento.
 */
function updateDedalineExecution() {
    $.when(
        getDeadline()
    ).done(function (result) {
        var date = document.getElementById("in_date").value;
        document.getElementById("day1").innerText = getDateFormat(date);
        var deadline = new Date(date);
        deadline.setDate(deadline.getDate() - Number(result));
        document.getElementById("deadline_date").innerText = getDateFormat(deadline);
        var dateLessons = document.getElementsByClassName("dL");
        for (var i = 0; i < dateLessons.length; i++) {
            var d = new Date(date);
            d.setDate(d.getDate() + i + 1)
            dateLessons[i].innerHTML = getDateFormat(d);
        }
    });
}

/**
 * Vartiabile per contenere l'ultimo conteggio di input time.
 */
var last_count = 1;

/**
 * Metodo per aggiungere o rimuovere input time.
 * @param x L'input select.
 */
function changeDay(x) {
    var count = Number(x.value);
    if (last_count < count) {
        var date = document.getElementById("in_date").value;
        var newData = new Date(date);
        for (var i = last_count + 1; i <= count; i++) {
            $('#exe_body').append('<tr id="raw_exe' + i + '">' +
                '<td>' +
                '<strong class="dL">' + getDateFormat(newData.setDate(newData.getDate() + 1)) + '</strong><br>' +
                'Inizio: <input id="start_time' + i + '" type="time" class="form-control mb-1" min="06:00" max="22:00" value="14:00">' +
                'Fine: <input id="end_time' + i + '" type="time" class="form-control mb-1" min="06:00" max="22:00" value="15:00" required>' +
                '</td>' +
                '</tr>');
        }
        last_count = count;
    } else {
        for (var i = last_count; i > count; i--) {
            $('#raw_exe' + i + '').remove();
        }
        last_count = count;
    }
}

/**
 * Funzione per convalidare i dati di aggiunta svolgimento.
 */
function checkExecution() {
    var form = document.getElementById("form_add_execution");
    var inputs = form.getElementsByTagName("input");
    var selects = form.getElementsByTagName("select");
    var times = [];
    var id_course = document.getElementsByTagName("modal_input_add_exe");

    for (var i = 1; i < inputs.length; i += 2) {
        times.push([inputs[i].value, inputs[i + 1].value]);
    }

    var formData = new FormData();
    formData.append('start_day_lesson', inputs[0].value);
    formData.append('duration_day', selects[0].value);
    formData.append('teacher', selects[1].value);
    formData.append('times', times);
    formData.append('id', id_course.value);

    $.when(
        addExecution(formData)
    ).done(function (json) {
        if (json[0].status == 1) {
            document.getElementById("alert_validation_date_fail").style.display = "none";
            document.getElementById("alert_validation_execution_succ").style.display = "block";
            document.getElementById("alert_validation_hours_fail").style.display = "none";
            document.getElementById("alert_validation_overlap").style.display = "none";
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            for (var i = 0; i < selects.length; i++) {
                selects[i].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            window.setTimeout(function () {
                window.location.replace(URL + "managementCourses");
                location.reload();
            }, 1000);
        } else {
            document.getElementById("alert_validation_date_fail").style.display = "block";
            if (json[0].c_times == 0) {
                document.getElementById("alert_validation_hours_fail").style.display = "block";
                for (var i = 1; i < inputs.length; i++) {
                    inputs[i].style.border = "1px solid red";
                }
            } else {
                document.getElementById("alert_validation_hours_fail").style.display = "none";
                for (var i = 1; i < inputs.length; i++) {
                    inputs[i].style.border = "1px solid rgba(170, 170, 170, .3)";
                }
            }
            if (json[0].c_start_day == 0) {
                inputs[0].style.border = "1px solid red";
            } else {
                inputs[0].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_duration == 0) {
                selects[0].style.border = "1px solid red";
            } else {
                selects[0].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].teacher == 0) {
                selects[1].style.border = "1px solid red";
            } else {
                if (json[0].c_overlap == 0) {
                    document.getElementById("alert_validation_overlap").style.display = "block";
                    selects[1].style.border = "1px solid red";
                } else {
                    document.getElementById("alert_validation_overlap").style.display = "none";
                    selects[1].style.border = "1px solid rgba(170, 170, 170, .3)";
                }
            }
        }
    });
}

/**
 * Metodo che fa una richiesta al server per aggiungere uno svolgimento.
 * @param formData Lo svolgimento da aggiungere.
 * @returns {{getAllResponseHeaders: function(): (<T>(...items: *[]) => number|null), abort: function(*=): *, setRequestHeader: function(*=, *): *, readyState: number, getResponseHeader: function(*): (null|*), overrideMimeType: function(*): *, statusCode: function(*=): this}|*}
 */
function addExecution(formData) {
    var response;
    return ($.ajax({
        url: (URL + "managementCourses/addExecution"),
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