<?php
include '../../Library/SessionManager.php';
require('../../Library/DBHelper.php');
$session = new SessionManager();
$dir = "../Training_Collections";
$files = scandir($dir);
$colLength = count($files);
$trainCol = array();
for ($x = 2; $x < $colLength; $x++) {
    array_push($trainCol, $files[$x]);
}



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Training</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="../../Master/master.css">
    <!--JQuery-->
    <script type="text/javascript" src="../../ExtLibrary/jQuery-2.2.3/jquery-2.2.3.min.js"></script>
    <!--JQuery Redirect-->
    <script type="text/javascript" src="../../ExtLibrary/jQuery.redirect/jquery.redirect.js"></script>
    <!--JqueryUI-->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!--Master javascript-->
    <script type="text/javascript" src="../../Master/master.js"></script>
</head>

<body>
<div id="wrap">
    <div id="main">
        <div id="divleft">
            <?php include '../../Master/header.php';
            include '../../Master/sidemenu.php' ?>
        </div>
        <div id="divright">
            <div class="widget">
                <h1>Controlgroup</h1>
                <fieldset>
                    <legend>Collections</legend>
                    <div id="collections" class="controlgroup">
                        <?php
                            for ($h = 0; $h < count($trainCol); $h++) {
                                if ($trainCol[$h] == 'jobfolder') {
                                    $splitJob = str_split($trainCol[$h],3);
                                    echo '<label for='.$trainCol[$h].'>'.ucwords($splitJob[0]).' '.ucwords($splitJob[1].$splitJob[2]).'</label><input type="radio" name="rdcollection" class="rdcollection" id='.$trainCol[$h].' value='.$trainCol[$h].'>';
                                    }
                                if ($trainCol[$h] == 'fieldbooks') {
                                    $splitField = str_split($trainCol[$h], 5);
                                    echo '<label for='.$trainCol[$h].'>'.ucwords($splitField[0]).' '.ucwords($splitField[1]).'</label><input type="radio" name="rdcollection" class="rdcollection" id='.$trainCol[$h].' value='.$trainCol[$h].'>';
                                }
                            }
                        ?>
                    </div>
                </fieldset>
                <br>
                <fieldset>
                    <legend>Users</legend>
                    <div class="controlgroup-vertical" id="divUsers">
                        <form id="rdUsers" action="list.php" method="post" >
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>



<?php include '../../Master/footer.php'; ?>
</body>

<script>
    $(document).ready(function () {


    $( function() {
        $( ".controlgroup" ).controlgroup();
        $( ".controlgroup-vertical" ).controlgroup({
            "direction": "vertical"
        });
    } );

        var rdValue = '';
        var changeCounter = 0;
    $('#collections').change(function() {
        var rdCollection = $(".rdcollection");
        rdValue = $(".rdcollection:checked").val();
        changeCounter++;
        console.log(changeCounter);
        for(var t = 0; t < rdCollection.length; t++) {
            if(rdCollection[t].value == rdValue) {
                var collection = JSON.parse('{"collection": "' + rdValue + '"}');
                if(changeCounter > 1){
                    console.log($('#rdUsers'));
                    $("#usersDiv"+String(changeCounter-1)).remove();
                }

                $.ajax({
                    type: 'post',
                    url: 'userAbstraction.php',
                    data: collection,
                    success: function (result) {
                        users = JSON.parse(result);
                        $("#rdUsers").append('<div id="usersDiv' + String(changeCounter) + '"></div>');
                        for(var x = 0; x < users.length; x++) {
                            $("#usersDiv"+String(changeCounter)).append('<label for="' + users[x] + '">' + users[x] + '</label> <input type="radio" name="user" value="' + users[x] + '"></br>');
                        }
                        $("#usersDiv"+String(changeCounter)).append('<input type="submit">');
                    }
                });

            }
        }
    });

        $("#rdUsers").submit(function (e) {
            e.preventDefault();
            var submitObj = $(this).serializeArray()[0];
            var user = '{"' + submitObj['name'] + '":"' + submitObj['value'] + '", "priv": "admin", "type": "Review", "col": "' + rdValue + '"}';
            var userJSON = JSON.parse(user);
//            console.log(userJSON);
            $.redirect("./list.php", userJSON);
        });
    });
</script>
</html>