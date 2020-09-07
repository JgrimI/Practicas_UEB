<script>
    window.onload=function(){
        getData();
    };
    function getData(){
        $.ajax({
            type: "POST",
            url: "ws/getVacantsForStudent.php",
            success: function (data) {
                console.log(data);
                data = JSON.parse(data);
                if (data["status"] == 1) {
                    $("#contentPage").html(data['vacants']);
                    $('#myTable').DataTable({
                        "language": {
                            "sProcessing":    "Procesando...",
                            "sLengthMenu":    "Mostrar _MENU_ registros",
                            "sZeroRecords":   "No se encontraron resultados",
                            "sEmptyTable":    "Ningún dato disponible en esta tabla",
                            "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix":   "",
                            "sSearch":        "Buscar:",
                            "sUrl":           "",
                            "sInfoThousands":  ",",
                            "sLoadingRecords": "Cargando...",
                            "oPaginate": {
                                "sFirst":    "Primero",
                                "sLast":    "Último",
                                "sNext":    "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "oAria": {
                                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            }
                        }
                    });
                }
            },
            error: function (data) {
                console.log(data);
            },
        })
    }
    
</script>
<style>
.form-control {
    border:0.5px solid lightgrey;
    color: #000;
}
</style>
<div class="viewport-header">
    <div class="row">
        <div>
        <h4>Vacantes</h4>
        </div>
    </div>
    <hr>       
    </div>
    <div class="content-viewport">
    <div class="row">              
        <div id="contentPage" style="width:80%; margin-left:8%;">
        
            <!-- Aqui va todo el contenido de la pagina -->
        </div>
        
