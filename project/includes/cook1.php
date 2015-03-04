<?php
include_once "../core/init.php";
$user = new user();
if(!$user->hasPermission("cook")){
	redirect::to('index.php');
}
include_once "head.php";
$db = db::getInstance();
$bdd = $db->getPDO();
?>

<div class="row">
    <h2 class="subheader text-center"> Entrée </h2>
    <div class="large-12 large-centered column">
        <table id="table" class="row-border hover table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Ingrédients</th>
                    <th>Prix</th>
                    <th>Disponible</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Ingrédients</th>
                    <th>Prix</th>
                    <th>Disponible</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>

            </tbody>
        </table>
        <button class="button success tiny" id="buttonentree" type=submit name=add1 ><i class='fa fa-plus fa-lg'></i></button>
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

    var table = $("#table").DataTable({
        "columnDefs": [
        { className: "dt-body-center", "targets": "_all" },
        { "name": "id",   "targets": 0 },
        { "name": "nom",   "targets": 1 },
        { "name": "ingredient",   "targets": 2 },
        { "name": "prix",   "targets": 3 },
        { "name": "disponible",   "targets": 4 }
        ],
        "oLanguage": {
            "sEmptyTable": "Aucune entrée enregistrer",
            "sInfo": "_TOTAL_ entrée(s) enregistrer (de _START_ à _END_)",
            "sLengthMenu": 'Afficher <select>'+
            '<option value="5">5</option>'+
            '<option value="10">10</option>'+
            '<option value="20">20</option>'+
            '<option value="-1">All</option>'+
            '</select> '
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
            "data": { action : "display_entree" }
        }
    });
function decodeHtml(html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}
$('#table tbody').on( 'click', 'td', function () {
    var id = table.row(table.cell(this).index().row).data()[0];
    var cellData = table.cell(this).data();
    var cell = table.cell(this).node();
    var headers = ["id", "nom", "ingredient", "prix", "disponible"];
    if($(cell).children().val()=='on'){
        $val = (($(cell).children().is(":checked")) ? 1 : 0); 
        var data = {
            "action": "update_entree",
            "id": id,
            "header": headers[$(cell).index()],
            "value": $val
        };
        data = $.param(data);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "response.php", 
            data: data,
            success: function(data) {
                if(data){
                    table.draw();
                }else{
                    alert("error");
                }
            }
        });
    }
    if(jQuery.inArray($(cell).index(), [0,4]) === -1){
        $(cell).html("<input type='text' value='' name='test'/>");
        $(cell).children().val(decodeHtml(cellData));
        var $input = $(cell).find('input');
        $input.focus();
        $input.on("change", function(){
            var data = {
                "action": "update_entree",
                "id": id,
                "header": headers[$(cell).index()],
                "value": $(this).val()
            };
            data = $.param(data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "response.php", 
                data: data,
                success: function(data) {
                    if(data){
                        table.draw();
                    }else{
                        alert("error");
                    }
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
        "action": "delete_entree",
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
                table.draw();
            }else{
                alert("error");
            }
        }
    });
    return false;
});

$('#buttonentree').on('click', function () {
    var data = {
        "action": "add_entree"
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
                table.draw();
            }else{
                alert("error");
            }
        }
    });
    return false;
});


</script>
</body>
</html> 
</footer>
