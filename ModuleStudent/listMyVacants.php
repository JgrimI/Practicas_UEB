<script>
    window.onload = getData();

    function getData() {
        console.log('entra1?');
        $.ajax({
            type: "POST",
            url: "ws/getVacantsForCurrentStudent.php",
            success: function(data) {
                console.log(data);
                data = JSON.parse(data);
                var aux = 0;

                if (data["status"] == 1) {

                    console.log(data['vacants']);
                    var html = "<div class='row' >";
                    data = data["vacants"];
                    for (let x in data) {
                        aux = aux + 1;
                        margin = (aux == 1) ? '' : 'margin-left:4%;';
                        aux = (aux == 3) ? 0 : aux;
                        html += '<div class="card" style="width: 30%; ' + margin + ' margin-top:2%; background-image: linear-gradient(120deg,#00e795 0,#0095e2 100%);">\n' +
                            '<div class="card-body" style="color:#fff">\n' +
                            '<h4 class="text-center">' + data[x]['nombre_cargo'] + '</h4><br>\n' +
                            '<h6 class="card-subtitle mb-2 text-center" >Cantidad Vacantes: ' + data[x]["cantidad_vacantes"] + '</h6>\n' +
                            '<center><label class="badge badge-dark">' + data[x]["estado_detalle"] + '</label></center>\n' +
                            '<p class="card-text">\n' +
                            '<strong>Rango salarial:</strong> ' + data[x]["rango_salarial"] + '<br>\n' +
                            '<strong>Horario:</strong> ' + data[x]["horario_disponibilidad"] + '<br>\n' +
                            '<strong>Fecha:</strong> ' + data[x]["fecha_vacante"] + '<br>\n' +
                            '<strong>Descripción:</strong> ' + data[x]["descripcion_vacante"] + '<br>\n' +
                            '<strong>Educación base:</strong> ' + data[x]["educacion_base"] + '<br>\n' +
                            '</p>\n' +
                            '</div>\n' +
                            '</div>';
                    }
                    html += '</div>';
                    $('#contentPage').html(html);
                } else {
                    console.log('entra?');
                    var h = "<div style='margin-top:3%;margin-left:15%;'>\n" +
                        "<h1>Aun no te has postulado a ninguna vacante </h1><br>\n" +
                        "<img src='assets/images/HOJAV.png' height='600px'>\n" +
                        "<a class='btn btn-warning btn-lg' style='color:white;' href='?menu=vacants' >Comencemos!!</a>\n" +
                        "</div>";
                    $('#contentPage').html(h);

                }
            },
            error: function(data) {
                console.log(data);
            },
        })
    }

    function openModal() {
        $('#addVacant').modal('show');
    }

    function addVacant() {
        $.ajax({
            type: "POST",
            url: "ws/addVacant.php",
            data: $("#form_vac").serialize(),
            success: function(data) {
                console.log(data);
                data = JSON.parse(data);
                if (data["status"] == 1) {
                    Swal.fire(
                        'Bien hecho!',
                        'Se ha publicado de manera exitosa!',
                        'success'
                    );
                    getData();
                } else {
                    Swal.fire(
                        'Bien hecho!',
                        data['error'],
                        'error'
                    );
                }
                $('#addVacant').modal('hide');
                $("#form_vac")[0].reset();
            },
            error: function(data) {
                console.log(data);
            },
        })
    }
    $(document).ready(function() {
        $(".modal").on("hidden.bs.modal", function() {
            $("#form_vac")[0].reset();
        });
    });

    function rangMin() {
        var x = document.getElementById('rang-min').value;
        $("#rang-max").attr('min', x);
    }
</script>

<style>
    .form-control {
        border: 0.5px solid lightgrey;
        color: #000;
    }
</style>

<div class="viewport-header" style="margin-left: -2%;">
    <div class="row">
        <div>
            <h4 style="margin-left: 15%; width: 100%;">Mis vacantes</h4>
        </div>
    </div>
    <hr>
</div>
<div class="content-viewport">
    <div class="row">
        <div id="contentPage" style="width:100%;">
            <!-- Aqui va todo el contenido de la pagina -->
        </div>
    </div>
</div>