/**
 * Classe per gestire le tipologie dei corsi.
 */
class ManageTypology {

    /**
     * Metodo che fa una richiesta al server peraggiungere una tipologia.
     * @param typology La tipologia da aggiungere.
     * @returns {{getAllResponseHeaders: function(): (<T>(...items: *[]) => number|null), abort: function(*=): *, setRequestHeader: function(*=, *): *, readyState: number, getResponseHeader: function(*): (null|*), overrideMimeType: function(*): *, statusCode: function(*=): this}|*}
     */
    addTypologyRe(typology) {
        var response;
        return ($.ajax({
            url: (URL + "adminPanel/addTypology"),
            type: "POST",
            data: {typology: typology},
            success: function (text) {
                response = text;
            }
        }));
    }


    /**
     * Metodo per eliminare una tipologia.
     * @param path Il nome della tipologia da eliminare.
     * @returns {*} Una risposta di come è andata la modifica sul server.
     */
    deleteTypology(typology) {
        var response;
        return ($.ajax({
            url: (URL + "adminPanel/deleteTypology"),
            type: "POST",
            data: {typology: typology},
            success: function (text) {
                response = text;
            }
        }));
    }

}