/**
 * Classe per gestire le foto per la pagina principale.
 */
class ManagePhoto {

    /**
     * Metodo per aggiungere una foro.
     * @param file La foto da aggiungere.
     * @returns {*} Una risposta di come è andata la modifica sul server.
     */
    addPhoto(file) {
        var file = file[0];
        var formData = new FormData();
        formData.append('file', file);
        var response;
        return ($.ajax({
            url: (URL + "adminPanel/addPhoto"),
            type: "POST",
            data: formData,
            success: function (text) {
                response = text;
            },
            contentType: false,
            processData: false
        }));
    }


    /**
     * Metodo per eliminare una foto.
     * @param path Il percorso della foto da eliminare.
     * @returns {*} Una risposta di come è andata la modifica sul server.
     */
    deletePhoto(path) {
        var path = path;
        var response;
        return ($.ajax({
            url: (URL + "adminPanel/deletePhoto"),
            type: "POST",
            data: {path: path},
            success: function (text) {
                response = text;
            }
        }));
    }

}