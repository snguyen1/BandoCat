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
    <!--Search for Future Collections Implementations-->
    <meta charset="UTF-8">
    <title>Admin Training</title>
    <!--Master CSS-->
    <link rel="stylesheet" type="text/css" href="../../Master/master.css">
    <!--Admin CSS-->
    <link rel="stylesheet" type="text/css" href="admin.css">
    <!--Data Tables CSS-->
    <link rel="stylesheet" type="text/css" href="../../ExtLibrary/DataTables-1.10.12/css/jquery.dataTables.css">
    <!--JQuery-->
    <script type="text/javascript" src="../../ExtLibrary/jQuery-2.2.3/jquery-2.2.3.min.js"></script>
    <!--JQuery Redirect-->
    <script type="text/javascript" src="../../ExtLibrary/jQuery.redirect/jquery.redirect.js"></script>
    <!--Data Tables Jquery-->
    <script type="text/javascript" src="../../ExtLibrary/DataTables-1.10.12/js/jquery.dataTables.js"></script>


</head>

<body>
<div id="wrap">
    <div id="main">
        <div id="divleft">
            <?php include "../../Master/header.php";
            include "../../Master/sidemenu.php"; ?>
        </div>
        <div id="divright">
            <h2>Admin Training Review</h2>
            <!--Collections Container-->
            <label for="collections" class="lblTraining">Collections</label>
            <div id="collections">
                        <!--Loop that obtains all of the Training_Collections sub-folders-->
                        <!--Future Collection implementation (string replace)-->
                        <?php
                            for ($h = 0; $h < count($trainCol); $h++) {
                                if ($trainCol[$h] == 'jobfolder') {
                                    $splitJob = str_split($trainCol[$h],3);
                                    echo '<input type="radio" name="rdcollection" class="rdcollection" id='.$trainCol[$h].' value='.$trainCol[$h].'><label class="colLable" for='.$trainCol[$h].'>'.ucwords($splitJob[0]).' '.ucwords($splitJob[1].$splitJob[2]).'</label>';
                                    }
                                if ($trainCol[$h] == 'fieldbooks') {
                                    $splitField = str_split($trainCol[$h], 5);
                                    echo '<input type="radio" name="rdcollection" class="rdcollection" id='.$trainCol[$h].' value='.$trainCol[$h].'><label class="colLable" for='.$trainCol[$h].'>'.ucwords($splitField[0]).' '.ucwords($splitField[1]).'</label>';
                                }
                            }
                        ?>
                    </div>
            <!--Users' form options Container-->
            <label for="users" class="lblTraining" style="margin-top: 4%">Users</label>
            <div id="users">
                <form id="formUsers" action="jobfolder/Forms/list.php" method="post" >
                    <select name="user" id="selUsers" multiple="multiple" size="20">
                        <option id="selCol" value="none">Select Collection</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../../Master/footer.php'; ?>
</body>

<script>
    //On document ready function
    $(document).ready(function () {
    //Global Variables
        //Count how many times the radio button has been changed
        var changeCounter = 0;

        //On collections radio change trigger
        $('#collections').change(function() {
            //Collections radio elements
            var rdCollection = $(".rdcollection");
            //Removes the statement to select a collection
            $("#selUsers option[id='selCol']").remove();
            //Collections radio elements value
            ColValue = $(".rdcollection:checked").val();
            changeCounter++;

            //Iterates through the collections' names to identify which collection has been selected from the radio input
            for(var t = 0; t < rdCollection.length; t++) {
                /*If the condition is met the collection name will be posted to the userAbstraction page to retrieve the
                trainees' user names from the Training_Collections*/
                if(rdCollection[t].value == ColValue) {
                    //Collection JSON
                    var collection = JSON.parse('{"collection": "' + ColValue + '"}');
                    //Removes the previously appended select element if another collection radio has been checked
                    if(changeCounter > 1){
                        $("select > option").remove();
                        $("#submitUser").remove();
                    }

                    /*Collection JSON is exchanged with the server a successful function appends the user names to the
                    form select element for submission*/
                    $.ajax({
                        type: 'post',
                        url: 'userAbstraction.php',
                        data: collection,
                        success: function (result) {
                            users = JSON.parse(result);
                            for(var u = 0; u < users.length; u ++){
                                $("select").append('<option class="optUser" id="'+ users[u] +'" name="user">'+ users[u] +'</option>')
                            }
                            $("#formUsers").append('<td><input id="submitUser" class="bluebtn" type="submit"></td>');
                        }
                    });

                }
            }
        });

        //On form submit function
        $("#formUsers").submit(function (e) {
            e.preventDefault();
            //Submit object form
            var submitObj = $(this).serializeArray()[0];

            //Validates user input
            if(typeof submitObj == 'undefined'){
                alert("Select user from the multiple options");
                return false;
            }

            //Submit object string
            var user = '{"' + submitObj['name'] + '":"' + submitObj['value'] + '", "priv": "admin", "type": "Review", "col": "' + ColValue + '"}';
            //Submit object JSON
            var userJSON = JSON.parse(user);
            //Submit object JSON is posted to collection_name/Forms/list.php and redirected to that page
            $.redirect( "../"+ColValue+"/Forms/list.php", userJSON);
        });
    });
</script>
</html>