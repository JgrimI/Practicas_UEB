<script>
    window.onload=getData();
    function getData(){
        $.ajax({
            type: "POST",
            url: "ws/getVacants.php",
            success: function (data) {
                console.log('dat');
                data = JSON.parse(data);
                if (data["status"] == 1) {
                    $('#contentPage').html(data['html']);
                }
            },
            error: function (data) {
                console.log(data);
            },
        })
    }
</script>
<div class="viewport-header">
    <div class="row">
        <div>
        <h4>Mis vacantes</h4>
        </div>
    </div>
    <hr>       
    </div>
    <div class="content-viewport">
    <div class="row">              
        <div id="contentPage" style="width:100%;">
            <!-- Aqui va todo el contenido de la pagina -->
        </div>