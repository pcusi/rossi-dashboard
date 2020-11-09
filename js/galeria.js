var tabla;



function init() {
    listar();
    $("#galeria-form").on("submit", function (e) {
        guardar(e);
    });
}

function mostrarGaleria(idFoto) {
    $.post("../controller/galeriaController.php?op=mostrar", { idFoto: idFoto }, function (data, status) {
        data = JSON.parse(data);
        $('#galeriaModal').modal('show');
        $('#foto_muestra').html(data.foto);
        $('#pintura').val(data.titulo);
        $('.modal-title').text("Editar Foto");
        $('#idFoto').val(data.idFoto);
        $('#resultado').html(data);
        $('#submit').text("Editar Foto");
    });
}

function listar() {
    tabla = $('#tabla-galeria').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
            "ajax":
            {
                url: '../controller/galeriaController.php?op=listar',
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "responsive": true,
            "bInfo": true,
            "iDisplayLength": 10,//Por cada 10 registros hace una paginación
            "order": [[0, "desc"]],//Ordenar (columna,orden)

            "language": {

                "sProcessing": "Procesando...",

                "sLengthMenu": "Mostrar _MENU_ registros",

                "sZeroRecords": "No se encontraron resultados",

                "sEmptyTable": "Ningún dato disponible en esta tabla",

                "sInfo": "Mostrando un total de _TOTAL_ registros",

                "sInfoEmpty": "Mostrando un total de 0 registros",

                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",

                "sInfoPostFix": "",

                "sSearch": "Buscar:",

                "sUrl": "",

                "sInfoThousands": ",",

                "sLoadingRecords": "Cargando...",

                "oPaginate": {

                    "sFirst": "Primero",

                    "sLast": "Último",

                    "sNext": "Siguiente",

                    "sPrevious": "Anterior"

                },

                "oAria": {

                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",

                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"

                }

            }//cerrando language

        }).DataTable();
}

function guardar(e) {
    e.preventDefault();
    var formData = new FormData($("#galeria-form")[0]);


    $.ajax({
        url: "../controller/galeriaController.php?op=guardar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            $('#galeria-form')[0].reset();
            $('#galeriaModal').modal('hide');

            $('#resultado').html(datos);
            $('#tabla-galeria').DataTable().ajax.reload();

            limpiar();

        }

    });

}

function estadoGaleria(idFoto, est) {
    bootbox.confirm("¿Está seguro de cambiar estado?", function (result) {
        if (result) {
            $.ajax({
                url: '../controller/galeriaController.php?op=estado',
                method: 'POST',
                data: { idFoto: idFoto, est: est },
                cache: false,
                success: function (data) {
                    $('#resultado').html(data);
                    $('#tabla-galeria').DataTable().ajax.reload();
                }
            });
        }
    });
}

init();