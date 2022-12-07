/**
 * Metodo per convalidare tutti i dati di un corso.
 */
function checkAll() {
    var inputs = document.getElementsByTagName("input");
    var textAreas = document.getElementsByTagName("textArea");
    var selects = document.getElementsByTagName("select");
    var formData = new FormData();
    formData.append('title', inputs[0].value);
    formData.append('street', inputs[1].value);
    formData.append('zip', inputs[2].value);
    formData.append('city', inputs[3].value);
    formData.append('max_partecipants', inputs[4].value);
    formData.append('typology', selects[0].value);
    formData.append('course_price', inputs[5].value);
    formData.append('meal_price', inputs[6].value);
    formData.append('description', textAreas[0].value);
    formData.append('materials', textAreas[1].value);
    $.when(
        modifyCourse(formData)
    ).done(function (json) {
        if (json[0].status == 1) {
            document.getElementById("alert_validation").style.display = "none";
            inputs[0].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[1].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[2].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[3].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[4].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[5].style.border = "1px solid rgba(170, 170, 170, .3)";
            inputs[6].style.border = "1px solid rgba(170, 170, 170, .3)";
            selects[0].style.border = "1px solid rgba(170, 170, 170, .3)";
            textAreas[0].style.border = "1px solid rgba(170, 170, 170, .3)";
            textAreas[1].style.border = "1px solid rgba(170, 170, 170, .3)";
            window.location.replace(URL + "courseModified");
        } else {
            document.getElementById("alert_validation").style.display = "block";
            if (json[0].c_title == 0) {
                inputs[0].style.border = "1px solid red";
            } else {
                inputs[0].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_street == 0) {
                inputs[1].style.border = "1px solid red";
            } else {
                inputs[1].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_zip == 0) {
                inputs[2].style.border = "1px solid red";
            } else {
                inputs[2].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_city == 0) {
                inputs[3].style.border = "1px solid red";
            } else {
                inputs[3].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_max_partecipants == 0) {
                inputs[4].style.border = "1px solid red";
            } else {
                inputs[4].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_typology == 0) {
                selects[0].style.border = "1px solid red";
            } else {
                selects[0].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_course_price == 0) {
                inputs[5].style.border = "1px solid red";
            } else {
                inputs[5].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_meal_price == 0) {
                inputs[6].style.border = "1px solid red";
            } else {
                inputs[6].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_description == 0) {
                textAreas[0].style.border = "1px solid red";
            } else {
                textAreas[0].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
            if (json[0].c_materials == 0) {
                textAreas[1].style.border = "1px solid red";
            } else {
                textAreas[1].style.border = "1px solid rgba(170, 170, 170, .3)";
            }
        }
    });
}

/**
 * Metodo che fa una richiesta al server per modificare un corso.
 * @param formData Il corso da modificare.
 * @returns {{getAllResponseHeaders: function(): (<T>(...items: *[]) => number|null), abort: function(*=): *, setRequestHeader: function(*=, *): *, readyState: number, getResponseHeader: function(*): (null|*), overrideMimeType: function(*): *, statusCode: function(*=): this}|*}
 */
function modifyCourse(formData) {
    var response;
    return ($.ajax({
        url: (URL + "modifyCourse/modifyCor"),
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