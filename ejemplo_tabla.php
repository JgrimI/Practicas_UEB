<?php
include_once('header.php');
include('tenders/persistencia/util/Conexion.php');

$obj=new Conexion();
$conexion=$obj->conectarBD();
 
$sentencia="SELECT DISTINCT pais FROM licitacion";
if(!$result = mysqli_query($conexion, $sentencia)) die();
     
?>
<body>
<div class="container-fluid" style="margin-top: 10%;">
<a href="indexTenders.php" class="btn btn-primary pull-left">Regresar</a>
<h1 class="text-center">Portal Licitaciones</h1> 

<br>
<br>
<style>
mark {
  padding: 0;
}
#tablal_wrapper{
  width: 100%!important;
}
</style>

<script src="https://cdn.jsdelivr.net/mark.js/8.6.0/jquery.mark.min.js"></script>
<script src="https://cdn.jsdelivr.net/datatables.mark.js/2.0.0/datatables.mark.min.js"></script>

<div class="row">
  <div class="col-lg-12">
        <div class="row" id="row_error"></div>
        <form  action="javascript:void(0);" method="post"  onsubmit="return validateform()">
            <div class="row">
                <div class="col-lg-12">
                    <div class="input-group mt-2">
                        <input type="text" style="width: 60%;" id="input_search" name="input_search" placeholder="Search" class="form-control">&nbsp;&nbsp;
                        <select class="form-control" id="pais" name="pais">
                          <option value="">Seleccione el pais</option>
                          <?php 
                          echo '<option value="Todos">Todos</option>';
                            while ($row = mysqli_fetch_array($result)) {
                              echo ' <option value="'.$row['pais'].'">'.$row['pais'].'</option>';
                          }
                          ?>
                        </select>&nbsp;&nbsp;
                     
                      <input class="btn btn-primary" type="submit" value="Buscar">
                     
              </div>
            </div>
        </div>
        <!-- CRITERIOS DE BÚSQUEDAS -->

        <div class="row" id="row_criteria"></div>
    </form>
  </div>
</div>
<br>
<div class="row" id="row_searches" style="display: none">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="header-title pb-3 mt-0">Resultado</h5>
                <table id="tablal" class="table table-striped table-bordered " style="border-collapse: collapse !important; border-spacing: 0; width: 101%!important; font-size: 12px" >
                  
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row" id="row_0" style="display: none">
  <div class="col-12">
    <div class="card-body text-center">
        <div class="col-sm-12">
          <div class="page-title-box">
          No se han encontrado resultados para tu búsqueda.<br><hr width="50%">
          </div>
        </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog modal-lg">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" ></h4>
        <button type="button" class="close close2" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        Cargando...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default modalClose" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
    
  </div>
</div>

<script>

var array_criteria = [];
var row_error = false;
window.onload = function(){
			
			queryString = window.location.search;
			urlParams = new URLSearchParams(queryString);
			var text =urlParams.get('buscar')
      var n = urlParams.get('categoria')
			var pais = urlParams.get('pais')
			
			if(text != null || pais != null){
        console.log(text);
				$('#input_search').val(text);
				$('#pais').val(pais);
				getDataSearch();
			}	
      if(n != null ){
        console.log(n);
        var str1 = "#Cat";
        var res = str1.concat(n);
				$('#input_search').val(res);
				getDataSearch();
			}

        };
function showCriteria(){
    let criteria = '';
    for(let i in array_criteria){
      console.log(decodeURIComponent(escape(array_criteria[i])));
      if(decodeURIComponent(escape(array_criteria[i])).startsWith("#Cat")){
        criteria += '<div class="col-lg-2 mt-2"><div class="alert alert-primary alert-dismissible fade show"  style="opacity: 1!important;" role="alert"><strong>'+decodeURIComponent(escape(array_criteria[i])).substring(4)+'</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="deleteCriteria(\''+decodeURIComponent(escape(array_criteria[i])).substring(4)+'\')"><span aria-hidden="true">&times;</span></button></div></div>';
      }else{
        criteria += '<div class="col-lg-2 mt-2"><div class="alert alert-primary alert-dismissible fade show"  style="opacity: 1!important;" role="alert"><strong>'+decodeURIComponent(escape(array_criteria[i]))+'</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="deleteCriteria(\''+decodeURIComponent(escape(array_criteria[i]))+'\')"><span aria-hidden="true">&times;</span></button></div></div>';
      }
    }
    $('#row_criteria').html(criteria);
}

function deleteCriteria(data){
    $('#input_search').val('');
    $('#pais').val('');
    let pos = array_criteria.indexOf(data);
    array_criteria.splice(pos, 1);
    getDataSearch();
}
function validateform(){  
  var name=$('#input_search').val();  
  var pais=$('#pais').val();  
  console.log(name);
  console.log(pais);
  if ( pais=="" && name==""){  
    criteria = '<div class="col-lg-12 mt-12"><div class="alert alert-danger alert-dismissible fade show"  style="opacity: 1!important;" role="alert"><strong>Por favor complete uno de los dos campos en la parte inferior</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div>';
    
    $('#row_error').html(criteria);
    return false;  
  }else{
    getDataSearch();
    return false;
  }  
} 
function getDataSearch(){
            if($('#input_search').val() != '' || array_criteria.length != 0 ) {
              var l=unescape(encodeURIComponent($('#input_search').val()))
              console.log( $('#input_search').val());
              console.log( $('#pais').val());
                if($('#input_search').val() != '' ){
                    array_criteria.push(l);
                    $('#input_search').val('');
                    
                }
                if ($.fn.DataTable.isDataTable( '#tablal' ) ) {
                    $('#tablal').DataTable().destroy();
                }
                $.ajax({
                    type: "POST",
                    url: "datos.php",
                    data: {
                        search: array_criteria,
                        pais: $('#pais').val()
                    },
                    beforeSend: function(){
                        checkSpinner();
                    },
                    complete: function(){
                        checkSpinner();
                    },
                    
                    success: function (data) {
                        console.log(data);
                        data = JSON.parse(data);
                        
                        if(data["response"] == 1){

                            data = data["json"];
                            $('#tablal').on('init.dt', function () {
                                console.log('Table initialisation complete: ' + new Date().getTime());
                               }).DataTable({  
                                mark: true, 
                                data: data,
                                order: [],
                                 columns: [
                                    {title: "Código Licitación"},
                                    {title: "Detalle"},
                                    {title: "Estado"},
                                    {title: "País"},
                                    {title: "Categoria"},
                                    {title: "Responsable"},
                                    {title: "Correo"},
                                    {title: "Teléfono"},
                                    {title: "Acciones"},
                                ],
                                 autoWidth: false,
                                 columnDefs: [
                                    {width: "10%!important" , "targets": 0},
                                    {width: "20%!important", "targets": 1},
                                    {width: "10%!important", "targets": 2},
                                    {width: "10%!important", "targets": 3},
                                    {width: "10%!important", "targets": 4},
                                    {width: "10%!important", "targets": 5},
                                    {width: "10%!important", "targets": 6},
                                    {width: "10%!important", "targets": 7},
                                    {width: "10%!important", "targets": 8}
                                ],
                                 language: idioma_espanol
                            });
                           
                            $('#row_error').css('display', 'none');
                            $('#row_searches').removeAttr('style');
                            showCriteria();
                            row_error = false;
                        }
                        else{
                            array_criteria.pop();
                            row_error = true;
                            getDataSearch();
                        }
                    },
                    error: function (data) {
                        checkSpinner();
                        console.log(data);
                    },
                })
            }else{
                if(row_error){
                    $('#row_0').removeAttr('style');
                    row_error = false;
                }
                $('#row_searches').css('display', 'none');

            }
        }



function openModal(cod,pais){
    $.ajax({
				type: "POST",
				url: "tenders/presentacion/detalle.php",
				data: {'cod':cod,'pais':pais
				},
				success: function (data) {
          var mymodal = $('#myModal');
    			$('.modal-body').html(data);
          mymodal.find('.modal-title').text('Detalles de la licitación');
          mymodal.modal('show');
				},
				error: function (data) {
					console.log(data);
				},
			})
    
}
$(function(){
  $('.modalClose').click(function(e){
    e.preventDefault();
    var mymodal = $('#myModal');
    mymodal.find('.modal-title').text('Detalles de la licitación');
    mymodal.find('.modal-body').text("Cargando...");
    mymodal.modal('show');

  });
})
$(function(){
  $('.close2').click(function(e){
    e.preventDefault();
    var mymodal = $('#myModal');
    mymodal.find('.modal-title').text('Detalles de la licitación');
    mymodal.find('.modal-body').text("Cargando...");
    mymodal.modal('show');

  });
})

var idioma_espanol = {
    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Filtrar:",
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
    },
    "buttons": {
        "copy": "Copiar",
        "colvis": "Visibilidad"
    }
};
</script>
    <!-- Start Footer -->
    <?php include_once('footer.php') ?>