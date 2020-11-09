$('#logout').on('click', function () {
    $.ajax({
        url: '../controller/usuarioController.php?op=logout',
        method: 'POST',
        success: function (data) {
            if (data) {
                location.href = '../index.php';
            }
        }
    })
})