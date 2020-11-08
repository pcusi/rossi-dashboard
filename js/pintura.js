var tabla;

function init() {
    listar();

    $("#pintura-form").on("submit", function (e) {
        guardaryeditar(e);
    })

    //cambia el titulo de la ventana modal cuando se da click al boton
    $("#add-pintura").click(function () {

        $(".modal-title").text("Agregar Pintura");

    });
}

function limpiar() {
    $('#titulo').val('');
    $('#descripcion').val('');
    $('#precio').val('');
    $('#foto').val('');
}

function listar() {
    tabla = $('#tabla').dataTable(
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
                url: '../controller/pinturaController.php?op=listar',
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

function mostrar(idPin) {
    $.post("../controller/pinturaController.php?op=mostrar", { idPin: idPin }, function (data, status) {
        data = JSON.parse(data);
        $('#pinturaModal').modal('show');
        $('#titulo').val(data.titulo);
        $('#precio').val(data.precio);
        $('#descripcion').val(data.descripcion);
        $('#foto_muestra').html(data.foto);
        $('.modal-title').text("Editar Categoría");
        $('#idPin').val(data.idPin);
        $('#submit').val("Editar");
    });
}

function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#pintura-form")[0]);


    $.ajax({
        url: "../controller/pinturaController.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            $('#pintura-form')[0].reset();
            $('#pinturaModal').modal('hide');

            $('#resultado').html(datos);
            $('#tabla').DataTable().ajax.reload();

            limpiar();

        }

    });

}

function estado(idPin, est) {
    bootbox.confirm("¿Está seguro de cambiar estado?", function(result){
        if (result) {
            $.ajax({
                url: '../controller/pinturaController.php?op=estado',
                method: 'POST',
                data: {idPin: idPin, est: est},
                cache: false,
                success: function(data) {
                    $('#resultado').html(data);
                    $('#tabla').DataTable().ajax.reload();
                }
            });
        }
    });
}

function eliminar(idPin) {

    $.ajax({
        url: '../controller/pinturaController.php?op=eliminar',
        method: 'DELETE',
        data: {idPin: idPin},
        success: function(data) {
            $('#resultado').html(data);
        }
    })

}

$('#close').click(function(){
    limpiar();
    $('#foto_muestra').html('No hay imagen');
});


init();