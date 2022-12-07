/**
 * Carico la libreria Datatables nella tabella con id course_table.
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
};