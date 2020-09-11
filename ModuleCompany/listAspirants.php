<script>
    window.onload = function(){
        getVacants();
    }
    function getVacants(){
        $.ajax({
            type: "POST",
            url: "ws/getVacantsSelect.php",
            success: function (data) {
                data = JSON.parse(data);
                if (data["status"] == 1) {
                    data = data["vacants"];
                    let options = '<option value="">Seleccione una vacante</option>';
                    for(let i in data){
                        options += '<option value="'+data[i]["cod_programa"]+'">'+data[i]["nom_programa"]+'</option>'
                    }
                    $('#vacants').select2({ width: '90%' });
                    $('#vacants').html(options);
                }
            },
            error: function (data) {
                console.log(data);
            },
        })
    }
    function getData(id){
        $.ajax({
            type: "POST",
            url: "ws/getAspirantsOfCompany.php",
            data:{
                'cod':id
            },
            success: function (data) {
                data = JSON.parse(data);
                var aux=0;

                if (data["status"] == 1) {
                    var html="<div class='row'>";
                    data=data["aspirants"];
                    for (let x in data ){
                        aux=aux+1;
                        margin=(aux==1) ? 'margin-left:2%;' : 'margin-left:3%;';
                        aux=(aux==3) ? 0 : aux;
                        img=(data[x]['foto']=='') ? 'default-user-image.png': data[x]['foto'];
                        onsb=(data[x]["estado"]=='ENVIADA') ? 'onsubmit="changeStatus('+ data[x]["cod_estudiante"] +','+id+',\'EN PROCESO\');"' : '';
                        btn=(data[x]["estado"]=='EN PROCESO') ? '<center><a href="javascript:void(0);" onclick="changeStatus('+ data[x]["cod_estudiante"] +','+id+',\'RECHAZADA\');" class="btn btn-warning" style="border-right: inherit; border-top-right-radius: inherit; border-bottom-right-radius: inherit;">Rechazar</a>'+
                                    '<button class="btn btn-primary" style="border-left: inherit; border-top-left-radius: inherit; border-bottom-left-radius: inherit;">Contratar</button></center>' : '';
                        html+='<div class="card" style="'+margin+' margin-top:2%; background: linear-gradient(135deg, rgb(197, 108, 214) 0%, rgb(52, 37, 175) 100%);">\n'+
                                '<div class="card-body" style="color:#fff">\n'+
                                    '<center><label class="badge badge-dark">'+data[x]["estado"]+'</label></center>\n'+
                                    '<center><img src="assets/images/profile/users/'+img+'" width="100px" height="100px"></center>\n'+
                                    '<h4 class="text-center">'+data[x]['nombre_completo']+'</h4><br>\n'+
                                    '<h6 class="card-subtitle mb-2 text-center" >'+data[x]["nom_programa"]+'</h6>\n'+
                                    '<h6 class="card-subtitle mb-2 text-center" >'+data[x]["correo_estudiante"]+'</h6><br>\n'+
                                    '<center><form method="post" target="_blank" action="pdf.php" id="formCV" '+onsb+'">\n'+
                                        '<input type="hidden" id="id" name="id" value="'+ data[x]["cod_estudiante"] +'"/>'+
                                        '<button class="btn btn-rounded social-btn btn-reddit">\n'+
                                        '<i class="mdi mdi-file-pdf"></i>Ver hoja de vida</button></form>\n'+
                                    '</button></center><br>\n'+
                                    btn+
                                '</div>'+
                            '</div>';   
                    }
                    html+='</div>';
                    $('#contentPage').html(html);
                }else{
                    var h="<div style='margin-top:3%;margin-left:15%;'>\n"+
                        "<h1 style='margin-left:5%;'>Aun nadie ha aplicado para esta vacante </h1><br>\n"+
                        "<img src='assets/images/vac.png' width='400px' height='400px' style='margin-left:15%;'>\n"+
                   "</div>";
                   $('#contentPage').html(h);

                }
            },
            error: function (data) {
                console.log(data);
            },
        })
    }
    function change(x){
        getData(x.value);
    }
    function changeStatus(id,dta,estado){
        $.ajax({
            type: "POST",
            url: "ws/updateStatusVacant.php",
            data:{
                'cod_estudiante':id,
                'cod_vacante':dta,
                'estado':estado
            },
            success: function (data) {
                if(estado=='RECHAZADA'){
                    getData(dta);
                    Swal.fire(
                            'Proceso terminado!',
                            'Se le ha notificado al estudiante que no ha sido seleccionado para el puesto',
                            'success'
                        );
                }else{
                    getData(dta);
                }
            },
            error: function (data) {
                console.log(data);
            },
        })
    }
</script>
<div class="viewport-header" style="margin-left: -2%;">
    <div class="row">
        <div>
        <h4 style="margin-left: 15%; width: 100%;">Aspirantes</h4>
        </div>
    </div>
    <hr>       
    </div>
    <div class="content-viewport">
    <div class="row"> 
        <div style="width:100%;">
            <h3 style='margin-left:0%;'>Selecciona una vacante</h3><br>
            <select name="program" class="form-control" id="vacants" onchange="change(this);"></select>
            <div id="contentPage">
                <br>
                <img src='assets/images/sel2.png' width='600px' height='562px' style='margin-left:15%;'>
            </div>
        </div>             
        