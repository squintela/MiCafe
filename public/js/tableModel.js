$(document).ready(function () {
  $('#table-model').DataTable({
    "columnDefs": [
      {
        "render": function (data, type, row) {
          let urls = data.split(",")
          if (urls.length === 2) {
            return `<a href="${urls[0]}" class="btn btn-default"><i class="fa fa-search"></i></a>`+
              `<a href="${urls[1]}" class="btn btn-default"><i class="fa fa-trash-alt"></i></a>`;
          } else {
            return "";
          }
        },
        "targets": 0
      }
    ],
    "scrollX": true,
    "bAutoWidth": true,
    "language": {
      "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    }
  });
});
