bootbox.confirm({
    title: "Eliminar Datos",
    message: "Seguro de eliminar el dato?.",
    buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> Cancelar'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> Confirmar'
        }
    },
    callback: function (result) {
        bootbox.alert({
            message: 'Resultado: ' + result
        })
    }
});