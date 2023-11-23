$(document).ready(function () {
    function initializeDataTable(selector) {
        $(selector).DataTable({
            "ordering" : false,
            language: {
                processing: "Tratamiento en curso...",
                search: "Buscar&nbsp;:",
                lengthMenu: "Agrupar de _MENU_",
                info: "_START_ - _END_ de _TOTAL_ datos",
                infoEmpty: "No existen datos.",
                infoFiltered: "(filtrado de _MAX_ elementos en total)",
                infoPostFix: "",
                loadingRecords: "Cargando...",
                zeroRecords: "No se encontraron datos con tu busqueda",
                emptyTable: "No hay datos disponibles en la tabla.",
                paginate: {
                    first: "Primero",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Ultimo"
                },
                aria: {
                    sortAscending: ": active para ordenar la columna en orden ascendente",
                    sortDescending: ": active para ordenar la columna en orden descendente"
                }
                
            },
            lengthMenu: [ [5, 10, -1], [5, 10, "All"] ],
        });
    }

    initializeDataTable('#tabla__clientes__numeros');
    initializeDataTable('#tabla__clientes__nombres');
});