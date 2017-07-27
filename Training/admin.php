<?php
include '../Library/SessionManager.php';
require('../Library/DBHelper.php');
$session = new SessionManager();
$dir = "Training_Collections";
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
    <link rel="stylesheet" type="text/css" href="../Master/master.css">
    <!--Admin CSS-->
    <link rel="stylesheet" type="text/css" href="admin.css">
    <!--Data Tables CSS-->
    <link rel="stylesheet" type="text/css" href="../ExtLibrary/DataTables-1.10.12/css/jquery.dataTables.css">
    <!--JQuery-->
    <script type="text/javascript" src="../ExtLibrary/jQuery-2.2.3/jquery-2.2.3.min.js"></script>
    <!--JQuery Redirect-->
    <script type="text/javascript" src="../ExtLibrary/jQuery.redirect/jquery.redirect.js"></script>
    <!--Data Tables Jquery-->
    <script type="text/javascript" src="../ExtLibrary/DataTables-1.10.12/js/jquery.dataTables.js"></script>


</head>

<body>
<div id="wrap">
    <div id="main">
        <div id="divleft">
            <!--Master header-->
            <img id="header_logo" width="260px" src="../Images/Logos/bando-logo-medium.png"/>
            <!--Master Sidemenu-->
            <nav>
                <div class="menu-item alpha">
                    <h4><a href="../">Main Menu</a></h4>
                </div>
                <!-- Add admin section to side menu -->
                <?php
                //create a new unique instance of DBheler so we can use it for tickets
                require_once '../Library/DBHelper.php';
                $DB1 = new DBHelper();
                //if user is admin, then add Admin section to the menu
                $userid = $session-> getUserID();
                $userticketCount = $DB1->GET_USER_CLOSEDTICKET_COUNT($userid);
                $ticketCount = 0;
                $admin = $session->isAdmin();
                if($session->isAdmin())
                {
                    //queries the database for the number of tickets currently active
                    $ticketCount = $DB1->GET_ADMIN_OPENTICKET_COUNT();
                    echo '<div class="menu-item menu-item_sub5">
            <!--class for the visuals, data-badge to pass the number of tickets to the text in the badge -->
            <h4><a class="notificationBadge" data-badge='.$ticketCount.' id="adminNotificationBadge" href="">Admin </a></h4>    
             <div></div>
            <ul>           
            <li><a href="../Forms/ActivityLog/index.php">Activity Log</a></li>
            <li><a class="notificationBadge" data-badge='.$ticketCount.' id="adminNotificationBadge2" href="../Forms/Ticket/">View Tickets </a></li>
            <li><a href="../Forms/ManageUser/">Manage User</a></li>
            <li><a href="../Forms/NewUser/">Create New User</a></li>
            <li><a href="../Training/admin.php">Training</a></li>
            </ul>
        </div>
        <div class="menu-item menu-item_sub2">
        <h4><a href="#">TDL Publishing</a></h4>
        <ul>
            <li><a href="../TDLPublish/Forms/index.php">Listing</a></li>
            <li><a href="../TDLPublish/Forms/queue.php">Queue</a></li>
        </ul>
    </div>';
                }
                ?>
                <script>

                </script>
                <!-- Collections Tab -->
                <div class="menu-item menu-item_sub5">
                    <h4><a href="#">Collections</a></h4>
                    <ul>
                        <li><a href="../Templates/Map/index.php?col=bluchermaps">Blucher Maps</a></li>
                        <li><a href="../Templates/FieldBook/index.php?col=blucherfieldbook">Field Book</a></li>
                        <li><a href="../Templates/Map/index.php?col=greenmaps">Green Maps</a></li>
                        <li><a href="../Templates/Indices/index.php?col=mapindices">Indices</a></li>
                        <li><a href="../Templates/Folder/index.php?col=jobfolder">Job Folder</a></li>
                    </ul>
                </div>
                <!-- Indices Transcription Tab -->
                <div class="menu-item">
                    <h4><a href="../Transcription/Indices/list.php?col=mapindices">Indices Transcription</a></h4>
                </div>
                <div class="menu-item menu-item_sub2">
                    <h4><a href="#">GeoRectification</a></h4>
                    <ul>
                        <li><a href="../GeoRec/Map/index.php?col=bluchermaps">Blucher Maps</a></li>
                        <li><a href="../GeoRec/Map/index.php?col=greenmaps">Green Maps</a></li>
                    </ul>
                </div>
                <!-- Queries Tab -->
                <div class="menu-item menu-item_sub4">
                    <h4><a href="#">Queries</a></h4>
                    <ul>
                        <li><a href="../Forms/Queries/hascoast.php">Coastal Maps</a></li>
                        <li><a href="../Forms/Queries/exportcollection.php">Export Document Index</a></li>
                        <li><a href="../Forms/Queries/mapswithouttitle.php">Maps Without Titles</a></li>
                        <li><a href="../Forms/Queries/manage_authorname.php">Manage TDL Author</a></li>
                        <li><a href="#">Supplied Title Procedure</a></li>
                    </ul>
                </div>
                <!-- Statistics Tab -->
                <div class="menu-item">
                    <h4><a href="../Forms/Statistics/">Statistics</a></h4>
                </div>
                <!-- My Account Tab -->
                <div class="menu-item">
                    <h4><a href="../Forms/AccountSettings/">My Account</a></h4>
                </div>

                <?php


                echo '<div class="menu-item menu-item_sub2">
        <h4><a class="notificationBadge" data-badge='.$userticketCount.' id="userNotificationBadge" href="#">Ticket </a></h4>
        <ul>
            <li><a class="notificationBadge" data-badge='.$userticketCount.' id="userNotificationBadge2" href="../Forms/UserTicket/">View Tickets </a></li>   
            <li><a href="../Forms/TicketsSubmission/" target="_blank">Submit Ticket</a></li>
        </ul>
    </div>';


                if($session->isSuperAdmin())
                {
                    echo '<div class="menu-item">
        <h4><a href="../Creator/">Create New Collection</a></h4>
    </div>';
                }
                ?>

                <!-- Help Tab -->
                <div class="menu-item menu-item_sub2">
                    <h4><a href="#">Help</a></h4>
                    <ul>
                        <li><a href="../Procedures/Documents">Procedures</a></li>
                        <li><a href="../Procedures/Utilities">Support Software</a></li>
                    </ul>
                </div>
                <!-- Logout Tab -->
                <div class="menu-item">
                    <h4><a href="../Forms/Logout/" id="sidemenu_logout">Logout as <?php echo $session->getUsername(); ?></a></h4>
                </div>

                <script>
                    //Admin
                    $( document ).ready(function()
                    {
                        var count = '<?php echo $ticketCount ?>';
                        if(count > 0) {
                            document.getElementById("adminNotificationBadge2").className = "notificationBadge";
                            document.getElementById("adminNotificationBadge").className = "notificationBadge";
                        }
                        if(count < 1)
                        {
                            var admin = 0;
                            try
                            {
                                admin = '<?php echo $admin ?>';
                            }catch(e)
                            {
                                console.log("Error: "+ e);
                            }
                            //Handle our admin notification
                            if(admin != '') {
                                document.getElementById("adminNotificationBadge2").className = "";
                                document.getElementById("adminNotificationBadge").className = "";
                            }
                            else {//Do nothing}
                            }
                        }

                        var count2 = '<?php echo $userticketCount; ?>';
                        if(count2 > 0)
                        {
                            document.getElementById("userNotificationBadge2").className = "notificationBadge";
                            document.getElementById("userNotificationBadge").className = "notificationBadge";
                        }
                        if(count2 < 1)
                        {
                            document.getElementById("userNotificationBadge2").className = "";
                            document.getElementById("userNotificationBadge").className = "";
                        }
                    });
                </script>
            </nav>
        </div>
        <div id="divright">
            <h2>Admin Training Review</h2>
            <!--Collections Container-->
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
            <div id="users">
                <form id="formUsers" action="jobfolder/Forms/list.php" method="post" >
                    <select name="user" id="selUsers" multiple="multiple" size="20">
                    </select>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../Master/footer.php'; ?>
</body>

<script>
    //On document ready function
    $(document).ready(function () {
    //Global Variables
        //Collection Name
        var rdValue = '';
        //Count how many times the radio button has been changed
        var changeCounter = 0;

        //On collections radio change trigger
        $('#collections').change(function() {
            //Collections radio elements
            var rdCollection = $(".rdcollection");
            //Collections radio elements value
            rdValue = $(".rdcollection:checked").val();
            changeCounter++;

            //Iterates through the collections' names to identify which collection has been selected from the radio input
            for(var t = 0; t < rdCollection.length; t++) {
                /*If the condition is met the collection name will be posted to the userAbstraction page to retrieve the
                trainees' user names from the Training_Collections*/
                if(rdCollection[t].value == rdValue) {
                    //Collection JSON
                    var collection = JSON.parse('{"collection": "' + rdValue + '"}');
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
            var user = '{"' + submitObj['name'] + '":"' + submitObj['value'] + '", "priv": "admin", "type": "Review", "col": "' + rdValue + '"}';
            //Submit object JSON
            var userJSON = JSON.parse(user);
            //Submit object JSON is posted to collection_name/Forms/list.php and redirected to that page
            $.redirect( rdValue+"/Forms/list.php", userJSON);
        });
    });
</script>
</html>