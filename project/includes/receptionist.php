<?php
include_once "../core/init.php";
$user = new user();
if(!$user->hasPermission("receptionist")){
    redirect::to('index.php');
}
include_once "head.php";
$db = db::getInstance();
$bdd = $db->getPDO();
$result = $db->get("reservation");
?>

<html>
<div id="mainAlert4" data-alert class="alert-box success hide large-7 medium-6 small-5 large-centred medium-centered small-centered column text-center" tabindex="0" aria-live="assertive" role="dialogalert">
    <p class="flash"></p>
    <button href="#" tabindex="0" class="close" aria-label="Close Alert">&times;</button>
</div>
<head>
	<title>Chef de salles</title>
</head>
<body>
    <div class="row">
        <h2 class="subheader text-center titletable"> Gestion des réservations </h2>
        <div class="large-12 large-centered column">
            <table id="table" class="row-border hover table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th> ID </th>
                        <th> Nom de la réservation </th>
                        <th> Nombre de personnes </th>
                        <th> Date </th>
                        <th> Heure </th>
                        <th> Action </th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th> ID </th>
                        <th> Nom de la réservation </th>
                        <th> Nombre de personnes </th>
                        <th> Date </th>
                        <th> Heure </th>
                        <th> Action </th>
                    </tr>
                </tfoot>

                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <footer>
        <div class="row">
            <div class="small-12 columns">
                <p class="text-center"> ©Le Restaurant 2014 </p>
            </div><!-- class small-12 columns -->
        </div><!-- class row -->
        <!-- BACK TO TOP BUTTON -->
        <div class="small-1 columns" id="back-top">
            <a href="#top" class="button info"><i class="fa fa-arrow-up fa-2x"></i></a>
        </div><!-- class small-2 columns -->
        <script src="js/index.js"></script>
        <script src="js/vendor/fastclick.js"></script>
        <script src="js/foundation.min.js"></script>
        <script>
        $(document).foundation();
        var toId;
        var table = $("#table").DataTable({
            "columnDefs": [
            { className: "dt-body-center", "targets": "_all" },
            { "name": "id",   "targets": 0 },
            { "name": "name",   "targets": 1 },
            { "name": "nbPerson",   "targets": 2 },
            { "name": "dateResa",   "targets": 3 },
            { "name": "id_creneaux",   "targets": 4 }
            ],
            "language": {
                "url": "assets/lang/french.json"
            },
            "bFilter": true,
            "iDisplayLength": 5,
            "bLengthChange": true,
            "bPaginate": true,
            "serverSide": true,
            "processing": true,
            "ajax" : {
                "type": "POST",
                "dataType": "json",
                "url": "response.php",
                "data": { action : "display", table : "reservation" }
            }
        });

        $('#table tbody').on( 'click', 'td', function () {
            var id = table.row(table.cell(this).index().row).data()[0];
            var cellData = table.cell( this ).data();
            var cell = table.cell(this).node();
            var headers = ["id", "client_id", "nbPerson", "dateResa", "schedule"];
            if(jQuery.inArray($(cell).index(), [0]) === -1){
                $(cell).html("<input type='text' value='' name='test'/>");
                $(cell).children().val(cellData);
                var $input = $(cell).find('input');
                $input.focus();
                $input.on("change", function(){
                    var data = {
                        "action": "update",
                        "table": "reservation",
                        "id": id,
                        "header": headers[$(cell).index()],
                        "value": $(this).val()
                    };
                    data = $.param(data);
                    console.log(data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "response.php", 
                        data: data,
                        success: function(data) {
                            if(data){
                                $(".flash").html("Modification réussie !");
                                type = "success"
                                table.draw();
                            }else{
                                $(".flash").html("Erreur lors de la modification");
                                type = "alert"
                            }
                            $("#mainAlert4").toggleClass("hide success alert", false);
                                $("#mainAlert4").toggleClass(type, true)
                                clearTimeout(toId);
                                toId = setTimeout(function() {
                                    $("#mainAlert4").toggleClass("hide", true)
                                }, 2000);
                        }
                    });
                    return false;
                });
                $input.on("focusout", function(){
                    $(this).parent().html($(this).val());
                });
            }
        });

$('#table tbody').on('click', '.remove', function () {
    var data = {
        "action": "delete",
        "table": "reservation",
        "id": $(this).val()
    };
    data = $.param(data);
    console.log(data);
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "response.php", 
        data: data,
        success: function(data) {
            if(data){
                $(".flash").html("Reservation supprimée !");
                    type = "success"
                table.draw();
            }else{
                $(".flash").html("Erreur lors de la supression");
                type = "alert"
            }
            $("#mainAlert4").toggleClass("hide success alert", false);
                $("#mainAlert4").toggleClass(type, true)
                clearTimeout(toId);
                toId = setTimeout(function() {
                    $("#mainAlert4").toggleClass("hide", true)
                }, 2000);
        }
    });
    return false;
});
        </script>
    </section><!-- class main-section -->
    <a class="exit-off-canvas"></a>
</div><!-- class inner-wrap -->
</div><!-- class off-canvas-wrap -->
</body>
</html>