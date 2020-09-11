<?php ;
if (!isset($_SESSION['redirect'])) {
    header('Location: index.php');
}
$cod=$_SESSION["id"];
?>

<style>
    .t-header .t-header-brand-wrapper a .logo {
        width: 150px;
        height: 50px;
    }
    
    .display-avatar.animated-avatar:before {
        background-color: orange;
        background-image: linear-gradient(19deg, orange 0%, red 100%)
    }
    
    .navbar-dropdown .dropdown-body .dropdown-grid {
        width: 40%;
        margin-left: 8%;
    }
    
    .action-button {
        background: #eda86a !important;
    }
</style>

<script>
    window.onload = function() {
        getCV(<?php echo $cod;?>);
    };

    function modCompany() {
        if (verifyPass()) {
            $.ajax({
                type: "POST",
                url: "ws/modifyCV.php",
                data: new FormData($('#mod')[0]),
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    data = JSON.parse(data);
                    if (data["status"] == 1) {
                        $('.dropify-clear').click();
                        Swal.fire(
                            'Bien hecho!',
                            'Se ha modificado tu hija de vida de forma exitosa!!!',
                            'success'
                        ).then(function() {
                            window.location = 'adminCompany.php';
                        })
                    } else {
                        if (data['error'] == 1062) {
                            Swal.fire(
                                'Error!',
                                data['error'],
                                'error'
                            )
                        }
                    }
                },
                error: function(data) {
                    console.log(data);
                },
            });
        }
    }

    function getCV(id) {
        $.ajax({
            type: "POST",
            url: "ws/getStudentCV.php",
            data: {
                'id': id
            },
            success: function(data) {
                data = JSON.parse(data);
                if (data["status"] == 1) {
                    data = data["cv"];

                    var html = ' <div class="row justify-content-center">' +
                        '                <div class="card w-75 black-text" style="margin-top:2%;padding-bottom: 2%;">' +
                        '                   <div class="card-body" id="body_form" name="body_form">' +
                        '                       <!-- MultiStep Form -->' +
                        '                       <div class="row justify-content-center mt-0">' +
                        '                           <div class="col-11 col-sm-9 col-md-7 col-lg-11 text-center p-0 mt-3 mb-2">' +
                        '                               <div class="card px-0 pt-4 pb-0 mt-3 mb-3">' +
                        '                                   <h2><strong></strong></h2>' +
                        '                                   <p>Llena todos los campos para pasar al siguiente paso</p><br>' +
                        '                                   <div class="row">' +
                        '                                       <div class="col-md-12 mx-0" enctype="multipart/form-data">' +
                        '                                           <form id="msform" action="javascript:void(0);"  onsubmit="regCV();">' +
                        '                                               <!-- progressbar -->' +
                        '                                               <ul id="progressbar">' +
                        '                                                   <li style="width:14.2%;" class="active" id="account"><strong>Información Personal</strong></li>' +
                        '                                                   <li style="width:14.2%;" id="personal"><strong>Perfil Profesional</strong></li>' +
                        '                                                   <li style="width:14.2%;" id="payment"><strong>Formación Academica</strong></li>' +
                        '                                                   <li style="width:14.2%;" id="payment"><strong>Formación Complementaria</strong></li>' +
                        '                                                   <li style="width:14.2%;" id="payment"><strong>Experiencia Academica</strong></li>' +
                        '                                                   <li style="width:14.2%;" id="payment"><strong>Experiencia Laboral</strong></li>' +
                        '                                                   <li style="width:14.2%;" id="payment"><strong>Referencias</strong></li>' +
                        '                                               </ul>' +
                        '                                               <!-- fieldsets -->' +
                        '                                               <!-- fieldset 1 -->' +
                        '                                             <fieldset>' +
                        '                                                   <div class="form-card">' +
                        '                                                        <h2 class="fs-title">Información Personal</h2> <br>' +
                        '                                                      <input type="text" style="background-color: #f4f4f4;" value="' + data[0]["nom_estu"] + '" disabled />' +
                        '                                                       <input type="hidden" id="name" name="name" value=""/>' +
                        '                                                       <input type="hidden" id="cod_estu" name="cod_estu" value="">' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_document" style="display:none;"></div>' +
                        '                                                       <label for="document">Tipo de documento*</label>' +
                        '                                                       <div class="input-group input-group-sm mb-3">' +
                        '                                                           <select name="document" class="form-control" id="document" required  >' +
                        '                                                               <option value="">Seleccione el tipo de documento</option>' +
                        '                                                               <option value="cc">(CC) Cédula de Ciudadania</option>' +
                        '                                                             <option value="ce">(CE) Cédula de Extranjeria</option>' +
                        '                                                             </select>' +
                        '                                                       </div>' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_document_id" style="display:none;"></div>' +
                        '                                                       <input type="text" id="document_id" name="document_id"  value="' + data[0]["numDocu"] + '" placeholder="Número de documento" value="" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" required min="1" max="100000000" class="form-control"' +
                        '                                                           onkeypress="solonumeros(event);">' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_telephone" style="display:none;"></div>' +
                        '                                                       <input type="text" id="telephone" name="telephone" placeholder="Número Telefónico" value="' + data[0]["telephone"] + '" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" required min="1" max="100000000" class="form-control"' +
                        '                                                           onkeypress="solonumeros(event);">' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_residence" style="display:none;"></div>' +
                        '                                                       <input type="text" name="residence" id="residence" value="' + data[0]["residence"] + '" placeholder="Lugar de residencia*" />' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_address" style="display:none;"></div>' +
                        '                                                       <input type="text" name="address" id="address" value="' + data[0]["direccion"] + '" placeholder="Dirección*" />                                                    ' +
                        '                                                       <input type="text" style="background-color: #f4f4f4;" name="umail" value="' + data[0]["mail"] + '" disabled />' +
                        '                                                        <div class="form-group">' +
                        '                                                           <div class="alert alert-danger mb-0" role="alert" id="alert_photo" style="display:none;"></div>' +
                        '                                                          <label for="photo">Foto personal(Opcional)</label>' +
                        '                                                          <input type="file" class="form-control-file dropify" name="photo"  data-default-file="assets/images/profile/users/'+data[0]["photo"]+'" id="photo" accept=".png,.jpeg,.jpg" data-allowed-file-extensions="png jpeg jpg">' +
                        '                                                       </div> ' +
                        '                                                   </div>' +
                        '                                                   <input type="button" name="next" id="next" class="nextInfPer action-button"  value="Siguiente" />' +
                        '                                               </fieldset>' +
                        '                                               <!-- fieldset 2 -->' +
                        '                                               <fieldset>' +
                        '                                                   <div class="form-card">' +
                        '                                                       <h2 class="fs-title">Perfil Profesional</h2>' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_ppro" style="display:none;"></div>' +
                        '                                                       <textarea id="ppro" name="ppro" rows="4" cols="1200"  placeholder="Escriba aqui su perfil profesional">' + data[0]["ppro"] + '</textarea>' +
                        '                                                       <p>Nota: Tenga en cuenta los siguientes conceptos básicos al momento de llenar su perfil profesional: capacitación, conocimiento, experiencia, competencias, habilidades, gustos o áreas disciplinarias que quiere' +
                        '                                                           ejercer.</p>' +
                        '                                                   </div>' +
                        '                                                   <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />' +
                        '                                                   <input type="button" name="next" class="nextPerfilPro action-button" value="Siguiente" />' +
                        '                                              </fieldset>' +
                        '                                               <!-- fieldset 3 -->' +
                        '                                               <fieldset>' +
                        '                                                   <div class="form-card">' +
                        '                                                       <h2 class="fs-title">Formación Academica</h2>' +
                        '                                                       <input type="text" style="background-color: #f4f4f4;" name="carrera" id="carrera" value="' + data[0]["program"] + '" disabled/>' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_semester" style="display:none;"></div>' +
                        '                                                      <input type="text" id="semester" name="semester" placeholder="Semestre" value="' + data[0]["semester"] + '" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="2" required min="1" max="20" class="form-control" onkeypress="solonumeros(event);">' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_startDate" style="display:none;"></div>' +
                        '                                                       <label for="startDate">Fecha de inicio*</label>' +
                        '                                                       <input type="date" id="startDateAca" name="startDateAca" value="' + data[0]["fechaIni"] + '" placeholder="Fecha de inicio" />' +
                        '                                                   </div> <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />' +
                        '                                                   <input type="button" name="next" class="nextFormAca action-button" value="Siguiente" />' +
                        '                                               </fieldset>' +
                        '                                               <!-- fieldset 4 -->' +
                        '                                               <fieldset>' +
                        '                                                   <div class="form-card">' +
                        '                                                       <h2 class="fs-title">Formación Complementaria</h2> ' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_languages" style="display:none;"></div>' +
                        '                                                       <input type="text" name="languages" id="languages" value="' + data[0]["idiomas"] + '" placeholder="Idiomas*" />' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_courses" style="display:none;"></div>' +
                        '                                                       <input type="text" name="courses" id="courses" value="' + data[0]["cursos"] + '" placeholder="Cursos, seminarios o talleres con certificado"/>' +
                        '                                                   </div>' +
                        '                                                   <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />' +
                        '                                                    <input type="button" name="next" class="nextFormCom action-button" value="Siguiente" />' +
                        '                                               </fieldset>' +
                        '                                               <!-- fieldset 5 -->' +
                        '                                              <fieldset>' +
                        '                                                   <div class="form-card">' +
                        '                                                       <h2 class="fs-title">Experiencia Academica</h2>' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_titulo" style="display:none;"></div>' +
                        '                                                       <input type="text" name="tituloP" id="tituloP" value="' + data[0]["tituloP"] + '" placeholder="Titulo del proyecto*" />' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_materia" style="display:none;"></div>' +
                        '                                                       <input type="text" name="materia" id="materia"  value="' + data[0]["materia"] + '" placeholder="Marco de materia*" />' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_perido" style="display:none;"></div>' +
                        '                                                       <input type="text" name="periodo" id="periodo"  value="' + data[0]["periodo"] + '" placeholder="Periodo Academico*" />' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_expAca" style="display:none;"></div>' +
                        '                                                       <textarea id="expAca" name="expAca" rows="10" cols="12" placeholder="Escriba aqui su experiencia academica">' + data[0]["desAca"] + '</textarea>' +
                        '                                                       <p>Nota: Los trabajos o proyectos realizados durante las diferentes materias son la experiencia academica.</p>' +
                        '                                                   </div>' +
                        '                                                <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />' +
                        '                                                   <input type="button" name="next" class="nextExpAca action-button" value="Siguiente" />' +
                        '                                                </fieldset>' +
                        '                                               <fieldset>' +
                        '                                                   <div class="form-card">' +
                        '                                                       <h2 class="fs-title">Experiencia Laboral</h2> ' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_cargo" style="display:none;"></div>' +
                        '                                                       <input type="text" name="cargo" id="cargo"  value="' + data[0]["cargo"] + '" placeholder="Cargo*" />' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_company" style="display:none;"></div>' +
                        '                                                       <input type="text" name="company" id="company"  value="' + data[0]["company"] + '" placeholder="Empresa*" />' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_startDate" style="display:none;"></div>' +
                        '                                                       <label for="startDate">Fecha de inicio*</label>' +
                        '                                                       <input type="date" id="startDate"  value="' + data[0]["startDate"] + '" name="startDate" />' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_endDate" style="display:none;"></div>' +
                        '                                                       <label for="endtDate">Fecha de finalización*</label>' +
                        '                                                      <input type="date" id="endDate"  value="' + data[0]["endDate"] + '" name="endDate"  />' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_functions" style="display:none;"></div>' +
                        '                                                       <textarea id="functions" name="functions" rows="10" cols="12" placeholder="Describa aqui sus funciones segun su cargo"> ' + data[0]["functions"] + '</textarea>' +
                        '                                                       <p>Nota: Si no cuenta con experiencia laboral puede omitir este paso.</p>' +
                        '                                                   </div>' +
                        '                                                   <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />' +
                        '                                                   <input type="button" name="next" class="nextExpLab action-button" value="Siguiente" />' +
                        '                                                   <input type="button" name="skip" style="margin-left: 80%; background: #008375!important;" class="skip action-button" value="Saltar" />' +
                        '                                               </fieldset>' +
                        '                                               <!-- fieldset 7 -->' +
                        '                                              <fieldset>' +
                        '                                                   <div class="form-card" style="text-align: center;">' +
                        '                                                       <h2 class="fs-title">Referencias</h2> ' +
                        '                                                       <label for="startDate">Referencia 1</label>' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_cargo" style="display:none;"></div>' +
                        '                                                       <input type="text" name="nombreRef1" id="nombreRef1"  value="' + data[0]["nomR1"] + '" placeholder="Nombre*" />' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_cargo" style="display:none;"></div>' +
                        '                                                       <input type="text" name="cargoRef1" id="cargoRef1"  value="' + data[0]["carR1"] + '" placeholder="Cargo*" />' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_languages" style="display:none;"></div>' +
                        '                                                       <input type="text" name="numeroRef1" id="numeroRef1"  value="' + data[0]["numR1"] + '" placeholder="Numero*" />' +
                        '                                                       <label for="startDate">Referencia 2</label>' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_cargo" style="display:none;"></div>' +
                        '                                                       <input type="text" name="nombreRef2" id="nombreRef2"  value="' + data[0]["nomR2"] + '" placeholder="Nombre*" />' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_cargo" style="display:none;"></div>' +
                        '                                                       <input type="text" name="cargoRef2" id="cargoRef2" value="' + data[0]["carR2"] + '" placeholder="Cargo*" />' +
                        '                                                       <div class="alert alert-danger mb-0" role="alert" id="alert_languages" style="display:none;"></div>' +
                        '                                                       <input type="text" name="numeroRef2" id="numeroRef2" value="' + data[0]["numR2"] + '" placeholder="Numero*" />' +
                        '                                                   </div>' +
                        '                                                  <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />' +
                        '                                               </fieldset>' +
                        '                                               <button type="submit" style="display: none; margin: 5px 85%;" id="confirm" name="confirm" class="action-button">Confirmar</button>' +
                        '                                           </form>' +
                        '                                       </div>' +
                        '                                   </div>' +
                        '                               </div>' +
                        '                           </div>' +
                        '                       </div>' +
                        '                   </div>' +
                        '               </div>' +
                        '           </div>';

                    $('#contentPage').html(html);
                    $("#document option[value='"+data[0]["tDocu"]+"']").attr("selected", true);
                    $(document).ready(function() {

                        var current_fs, next_fs, previous_fs; //fieldsets
                        var opacity;

                        $(".nextInfPer").click(function() {
                            if (true) {
                                siguiente($(this));
                            }
                        });

                        $(".nextPerfilPro").click(function() {
                            if (true) {
                                siguiente($(this));
                            }
                        });
                        $(".nextFormAca").click(function() {
                            if (true) {
                                siguiente($(this));
                            }
                        });
                        $(".nextFormCom").click(function() {
                            if (true) {
                                siguiente($(this));
                            }
                        });
                        $(".nextExpAca").click(function() {
                            if (true) {
                                siguiente($(this));
                            }
                        });
                        $(".nextExpLab").click(function() {
                            if (true) {
                                siguiente($(this));
                                $('#confirm').css('display', 'block');

                            }
                        });

                        function siguiente(val) {
                            current_fs = val.parent();
                            next_fs = val.parent().next();
                            //Add Class Active
                            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                            //show the next fieldset
                            next_fs.show();
                            //hide the current fieldset with style
                            current_fs.animate({
                                opacity: 0
                            }, {
                                step: function(now) {
                                    // for making fielset appear animation
                                    opacity = 1 - now;
                                    current_fs.css({
                                        'display': 'none',
                                        'position': 'relative'
                                    });
                                    next_fs.css({
                                        'opacity': opacity
                                    });
                                },
                                duration: 600
                            });
                        }

                        $(".skip").click(function() {
                            $('#confirm').css('display', 'block');
                            current_fs = $(this).parent();
                            next_fs = $(this).parent().next();
                            //Add Class Active
                            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                            //show the next fieldset
                            next_fs.show();
                            //hide the current fieldset with style
                            current_fs.animate({
                                opacity: 0
                            }, {
                                step: function(now) {
                                    // for making fielset appear animation
                                    opacity = 1 - now;
                                    current_fs.css({
                                        'display': 'none',
                                        'position': 'relative'
                                    });
                                    next_fs.css({
                                        'opacity': opacity
                                    });
                                },
                                duration: 600
                            });

                        });

                        $(".previous").click(function() {
                            $('#confirm').css('display', 'none');

                            current_fs = $(this).parent();
                            previous_fs = $(this).parent().prev();

                            //Remove class active
                            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                            //show the previous fieldset
                            previous_fs.show();

                            //hide the current fieldset with style
                            current_fs.animate({
                                opacity: 0
                            }, {
                                step: function(now) {
                                    // for making fielset appear animation
                                    opacity = 1 - now;

                                    current_fs.css({
                                        'display': 'none',
                                        'position': 'relative'
                                    });
                                    previous_fs.css({
                                        'opacity': opacity
                                    });
                                },
                                duration: 600
                            });
                        });

                        $('.radio-group .radio').click(function() {
                            $(this).parent().find('.radio').removeClass('selected');
                            $(this).addClass('selected');
                        });

                        $(".submit").click(function() {
                            return false;
                        })

                    });
                    dropify = $('#photo').dropify({
                          messages: {
                            'default': 'Arrastra el archivo o haz click aqui',
                            'replace': 'Arrastra o clikea para remplazar',
                            'remove':  'Quitar',
                            'error':   'Ooops, algo a salido mal.'
                        }
                        });

                }
            },
            error: function(data) {
                console.log(data);
            },
        })
    }
</script>

<div class="viewport-header" style="margin-left: -2%;">
    <div class="row">
        <div>
            <h4 style="margin-left: 15%; width: 100%;">Mi Hoja de Vida</h4>
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