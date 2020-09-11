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
                console.log(data);
                data = JSON.parse(data);
                var aux=0;

                if (data["status"] == 1) {
                    var html="<div class='row'>";
                    data=data["aspirants"];
                    for (let x in data ){
                        aux=aux+1;
                        margin=(aux==1) ? 'margin-left:2%;' : 'margin-left:3%;';
                        aux=(aux==3) ? 0 : aux;
                        html+='<div class="card" style="'+margin+' margin-top:2%; background: linear-gradient(135deg, rgb(197, 108, 214) 0%, rgb(52, 37, 175) 100%);">\n'+
                                '<div class="card-body" style="color:#fff">\n'+
                                    '<center><label class="badge badge-dark">'+data[x]["estado"]+'</label></center>\n'+
                                    '<center><img src="assets/images/profile/users/'+data[x]['foto']+'" width="100px" height="100px"></center>\n'+
                                    '<h4 class="text-center">'+data[x]['nombre_completo']+'</h4><br>\n'+
                                    '<h6 class="card-subtitle mb-2 text-center" >'+data[x]["nom_programa"]+'</h6>\n'+
                                    '<h6 class="card-subtitle mb-2 text-center" >'+data[x]["correo_estudiante"]+'</h6><br>\n'+
                                    '<center><form method="post" target="_blank" action="pdf.php" id="formCV">\n'+
                                        '<input type="hidden" id="id" name="id" value="'+ data[x]["cod_estudiante"] +'"/>'+
                                        '<button class="btn btn-rounded social-btn btn-reddit">\n'+
                                        '<i class="mdi mdi-file-pdf"></i>Ver hoja de vida</button></form>\n'+
                                    '</button></center></div>\n'+
                            '</div>';   
                    }
                    html+='</div>';
                    console.log(html);
                    $('#contentPage').html(html);
                }else{
                    var h="<div style='margin-top:3%;margin-left:15%;'>\n"+
                        "<h1>Aun no has publicado ninguna vacante </h1><br>\n"+
                        "<img src='assets/images/comencemos.png' width='600px' height='500px'>\n"+
                        "<a class='btn btn-warning btn-lg' style='color:white;' href='javascript:void(0)' onclick='openModal();'>Comencemos!!</a>\n"+
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
</script>
<div class="viewport-header">
    <div class="row">
        <div>
        <h4>Aspirantes</h4>
        </div>
    </div>
    <hr>       
    </div>
    <div class="content-viewport">
    <div class="row"> 
        <div style="width:100%;">
            <select name="program" class="form-control" id="vacants" onchange="change(this);"></select>
            <div id="contentPage">
            </div>
        </div>             
        