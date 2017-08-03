<?php
include '../../../Library/SessionManager.php';
require('../../../Library/DBHelper.php');
$session = new SessionManager();
//Get collection name and action

/*Posted data from the admin.php page
* Collection, Username
* Type, Privilege
*/
if ( !empty($_POST) ) {
    $collection = $_POST["col"];
    $username = $_POST["user"];
    $type = $_POST["type"];
    $priv = $_POST["priv"];
    $userfile = $_POST["user"];
}

//If no Posted data, the privilege will be stored as none, and the user name will be defined from the session user name
else{
    if (isset($_GET['user'])){
        $username = $_GET['user'];
        $priv = $_GET['priv'];
    }

    else{
        $username = $_SESSION["username"];
        $priv = 'none';
    }

    $collection = $_GET["col"];
    $type = $_GET["type"];
    $userfile = $username;
}

	include 'config.php';
$file_arr = array();

//list of files in the directory
if($_SESSION["role"] == 1) {
    $pos = -1;
    $listfile = scandir(getcwd());

    //Conditions to save only xml files to the file_arr array
    foreach ($listfile as $row) {
        $pos = -1;
        $pos = strpos($row, ".xml");
        if ($pos != 0) {
            array_push($file_arr, $row);
        }
    }
}
?>


<!DOCTYPE html>
<head>
	<title>Edit Map Information</title>
	<!-- <meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" /> -->
	<meta http-equiv = "Content-Type" content = "text/html; charset = utf-8" />
    <!--JQuery UI CSS-->
		<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">
    <!--JQuery UI CSS-->
        <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!--JQuery Datatables-->
		<link rel="stylesheet" type="text/css" href="../../../ExtLibrary/DataTables-1.10.12/css/jquery.dataTables_themeroller.css">
    <!--Master CSS-->
        <link rel = "stylesheet" type = "text/css" href = "../../../Master/master.css" >
    <link rel="stylesheet" type="text/css" href="../styles.css"/>
    <!--Script-->
    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="../../../ExtLibrary/jQuery-2.2.3/jquery-2.2.3.js"></script>
    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="../../../ExtLibrary/DataTables-1.10.12/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
    <div id="wrap">
        <div id="main">
            <div id="divleft">
                <?php include "../../trainingMaster.php"?>
            </div>
            <div id="divright">
                <h2 id="page_title">Training <?php if($priv == 'admin') echo $username; elseif($type == 'intermediate' || $type == 'newbie') echo ucfirst($type); elseif ($type == 'none') echo 'Homepage' ?></h2>

                <!--Training Progress/Progress Bar-->
                <div id="trainingProgress">
                    <div id="progressBar"></div>
                </div>

                <!--Document table list-->
                <div id="divscroller" style="display: none;">
                    <table id="dtable" class="display compact cell-border hover stripe" cellspacing="0" width="100%" data-page-length='14'>
                        <thead>
                        <tr>
                            <th>Document Link</th>
                            <th>Library Index</th>
                            <th>Document Title</th>
                            <th>Classification</th>
                            <th>Needs Review</th>
                        </tr>

                        </thead>

                        <tbody>
                        <!--Block of code that loads the information from the xml file to the table-->
                            <?php
                            //Main directory
                            $training_parent = "../../Training_Collections";
                            //Collection directory
                            $training_collection_dir = $training_parent.'/'.$collection;
                            //User directory
                            $training_user_dir = $training_collection_dir.'/'.$userfile;
                            $document = new DOMDocument();
                            /*Conditions the training type to load the XML file pertaining to its training level and
                            clear any document cache*/
                            if ($type  == 'newbie') {
                                if (file_exists($training_user_dir . '/' . $userfile . '_newbie.xml')) {
                                    clearstatcache();
                                    $document->load($training_user_dir.'/'.$userfile.'_newbie.xml');
                                }
                            }
                            elseif ($type  == 'inter') {
                                if (file_exists($training_user_dir . '/' . $userfile . '_inter.xml')) {
                                    clearstatcache();
                                    $document->load($training_user_dir.'/'.$userfile.'_inter.xml');
                                }
                            }

                            //Reads all the document elements from the loaded document
                            $nodes = $document->getElementsByTagName('document');
                            $count = 0;
                            //For each document as node
                            foreach ($nodes as $node) {
                                //Block of conditional statements that obtains the childnode values from every document
                                //to be displayed in the data table
                                foreach ($node->childNodes as $child) {
                                    if ($child->nodeName == 'libraryindex') {
                                        $libraryindex = $child->nodeValue;
                                    }
                                    elseif ($child->nodeName == 'title') {
                                        $title = $child->nodeValue;
                                    }
                                    elseif ($child->nodeName == 'classification') {
                                        $classification = $child->nodeValue;
                                    }
                                    elseif ($child->nodeName == 'needsreview') {
                                        $needsreview = $child->nodeValue;
                                    }
                                    elseif ($child->nodeName == 'id')
                                    {
                                        $id = $child->nodeValue;
                                    }
                                }

                                //Outputs into the table a document childnode by row and its attributes by table data
                                echo '<tr>';
                                echo "<td align = 'center'><a href=\"index.php?id=$id&user=$userfile&col=$collection&type=$type&priv=$priv\">$libraryindex</a></td>";
                                echo "<td align = 'center'>$libraryindex</td>";
                                echo "<td align = 'center'>$title</td>";
                                echo "<td align = 'center'>$classification</td>";
                                echo "<td align = 'center'>".(($needsreview == 0) ? 'No' : 'Yes')."</td>";
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!--Slideshow Container-->
                <div class="slideshow-container" style="display: none">
                    <div class="mySlides">
                        <div class="numbertext">1 / 3</div>
                        <img class="slideImg" src="../images/slide000.PNG" style="width:80%">
                        </div>
                    <div class="mySlides">
                        <div class="numbertext">2 / 3</div>
                        <img class="slideImg" src="../images/slide00.PNG" style="width:80%">
                        <div class="text"><!--<h2>This is the Document Table List. <ul><li>Library Index</li></ul></h2>--></div>
                    </div>
                    <div class="mySlides">
                        <div class="numbertext">2 / 3</div>
                        <img class="slideImg" src="../images/slide01.PNG" style="width:100%">
                        <div class="text">Welcome to your training. Through this sideshow you will have a quick glimpse about the cataloging process of Jobfolders</div>
                    </div>
                    <div class="mySlides">
                        <div class="numbertext">4 / 3</div>
                        <div id="continue" style="padding: 15%;"><input type="button" class="bluebtn" name="linkLists" style="display: block; margin: auto" value="Click to Continue To your Training"></div>
                    </div>

                    <a class="prevSlide" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="nextSlide" onclick="plusSlides(1)">&#10095;</a>
                    <div style="text-align:center">
                        <span class="dot" onclick="currentSlide(1)"></span>
                        <span class="dot" onclick="currentSlide(2)"></span>
                        <span class="dot" onclick="currentSlide(3)"></span>
                        <span class="dot" onclick="currentSlide(4)"></span>
                    </div>
                </div>
                <!--Continue Bandocat Image Buttons-->
                <div id="continueTraining">
                    <span id="continueNewbi" class="continueSpan"><img src="../Images/Training/BandoCatScan.PNG" id="bandocatNewbie"  class="bandocatImage"></a></span>
                    <span id="continueInter" class="continueSpan"><img src="../Images/Training/BandoCatScan.PNG" id="bandocatInter" class="bandocatImage" style="opacity: 0.5;"></a></span>
                    <!--Training Tabs-->
                    <div id="trainingTabs">
                        <ul>
                            <li><a href="#tabs-1">Training Tips</a></li>
                            <li><a href="#tabs-2">Help</a></li>
                            <?php if($priv == 'admin') echo '<li><a href="#tabs-3">Admin</a></li>'?>
                        </ul>
                        <div id="tabs-1">
                            <ul>
                                <li>Always leave the Needs Review field as yes</li>
                            </ul>
                        </div>
                        <div id="tabs-2">
                            <p>Anna's contact Info</p>
                            <p>Link to procedures</p>
                        </div>
                        <!--Training Admin Tab-->
                        <?php if($priv == 'admin') echo '<div id="tabs-3"><input type="button" id="resetTraining" value="Reset Training"></div>'?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script type="text/javascript">

        //Slideshow Functions
        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
        }

        $( document ).ready(function() {
            /*JQuery Functions
            * dataTables
            * trainingTabs*/

            //Function that initiates the data table
            $('#dtable').dataTable({
                "bJQueryUI": true,
                "order": [[3, "desc"]],
                "lengthMenu": [10, 25, 50],
                "iDisplayLength":10
            });

            //Function that initiates the training tabs
            $( function() {
                $( "#trainingTabs" ).tabs();
            } );

            //Conditional statement that displays the training links, tabs, and progress bar
            if("<?php echo $type ?>" == 'newbie' || "<?php echo $type ?>" == 'inter'){
                $('#newbie').css('display', 'none');
                $('#intermediate').css('display', 'none');
                $('div').remove('#continueTraining');
                $('#divscroller').css('display', 'block');
                $('div').remove('.slideshow-container');
                $( "#divscroller" ).after( "<div id='buttonList' style='padding: 5%;'><input type='button' onclick='backList()' id='backList' class='bluebtn' id='trainingButton' value='Back to Training Home'></div>" );
            }
            trainingProgress();
        });

        /**********************************************
         * Function: trainingProgress
         * Description: Reads the number of document elements that have been tag as completed and sets an interval to
         * set the width of the progress bar accordingly to the number of completed documents.
         * Parameter(s): None
         * Return value(s): None
         ***********************************************/
        function trainingProgress() {
            //Stores the progress of the training
            var progress = 0;
            //Stores the progress of the newbie training
            var newbieCompletedTags = 0;
            var xhttp_newbie = new XMLHttpRequest();
            var xhttp_inter = new XMLHttpRequest();

            //Event that is triggered every time that the readyState changes of the newbie XMLHttpRequest
            xhttp_newbie.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    //Number of completed Tags in the user_newbie.xml
                    completeTagsLenght = xmlGetLenght(this);
                    //Number of completed Tags that have a 1 value
                    completedTags = xmlGetComplete(this);
                    //Progress in Percentage decimal value for the newbie training
                    newbieCompletedTags = completedTags/completeTagsLenght;

                    xhttp_inter.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            //Number of completed Tags in the user_inter.xml
                            completeTagsLenght = xmlGetLenght(this);
                            //Number of completed Tags that have a 1 value
                            completedTags = xmlGetComplete(this);
                            //Training Progress for the training program
                            progress = progressComplete(completedTags, completeTagsLenght);
                        }

                    };
                    xhttp_inter.open("GET", "<?php echo $training_user_dir . '/' . $userfile . '_inter.xml' ?>", true);
                    xhttp_inter.send();
                }
            };
            xhttp_newbie.open("GET", "<?php echo $training_user_dir.'/'.$userfile.'_newbie.xml' ?>", true);
            xhttp_newbie.send();

            /**********************************************
             * Function: trainingProgress
             * Description: Function that is called when all the completed elements have been counted and positively
             * identified as completed, and sets the width of the progress bar accordingly to the number of tag and completed
             * tags ratio.
             * Parameter(s): completedTags (int) Number of positively updated completed tags
             * completedTagsLength (int) Number of completed tags in the XML file
             * Return value(s): None
             ***********************************************/
            function progressComplete(completedTags, completeTagsLength ) {
                var width = 1;
                //Progress Level of the training (float)
                progressLevel = (completedTags/completeTagsLength)*100;
                //Progress Level of the trining (int)
                sequence = parseInt(progressLevel);

                //Conditional statement that displays the slideshow if the progress level is zero
                if(progressLevel == 0) {
                    //Makes the default width of the progress bar 3%
                    progressLevel = 3;
                    $('.slideshow-container').css('display', 'block');
                    $("#continueTraining").css('display', 'none');
                    $('#trainingButton').css('display', 'none');
                    if("<?php echo $type ?>" == 'newbie')
                        $('.slideshow-container').css('display', 'none');
                }

                else{
                    $('.slideshow-container').css('display', 'none')
                }

                //The window evaluates the frame function at a specified interval of 18 milliseconds
                var id = setInterval(frame, 12);

                /**********************************************
                 * Function: frame
                 * Description: Sets the width of the training progress bar accordingly to the progress level
                 * Parameter(s): None
                 * Return value(s): None
                 ***********************************************/
                function frame() {
                    if (width >= progressLevel){
                        //Terminates the setInterval method
                        clearInterval(id);

                        //newbieCompletedTags == 1 (Newbie training has been completed)
                        //frameDisplay == 2 (Times the frame function is called)

                        /*Conditions the completion of the newbie training, the newbie training type, and last frame
                        display call to continue to the intermediate level*/
                        if(newbieCompletedTags == 1 && '<?php echo $type ?>' == 'newbie'){
                            $("#buttonList").append("<input type='button' id='linkInter' onclick='linkInter()' class='bluebtn' style='margin-left: 60%; background: orange' id='trainingButton' value='Continue to Next Level'>")
                        }

                        //Styles Bandocat Intermediate Image link
                        if(newbieCompletedTags == 1) {
                            $("#bandocatInter").css('opacity', '1');
                            $("#bandocatInter").hover(function(){
                                $(this).css("cursor", "pointer");
                            });
                        }

                        //Styles Bandocat Newbie Image link
                        if (newbieCompletedTags <= 1) {
                            $("#bandocatNewbie").hover(function(){
                                $(this).css("cursor", "pointer");
                            });
                        }
                    }

                    //Increments the width of the progress bar
                    else {
                        width++;
                        $('#progressBar').width(width+'%').height(20).css("background-color", "green").css("height", "").css("text-align", "center").text(sequence + ' %');

                    }
                }
            }
       }


var elemCompletedLenght = 0;
        /**********************************************
         * Function: xmlGetLenght
         * Description: Gets the number of completed tags from the XML files
         * Parameter(s): xml (XML object)
         * Return value(s): elemCompletedLenght (int) number of completed tags
         ***********************************************/
        function xmlGetLenght(xml) {
            var xmlDoc = xml.responseXML;
            elemCompleted = xmlDoc.getElementsByTagName('completed');
            elemCompletedLenght += elemCompleted.length;
            return elemCompletedLenght
        }

var sumCompletedTags = 0;
        /**********************************************
         * Function: xmlGetComplete
         * Description: Gets the number of positevely updated completed tags from the XML files
         * Parameter(s): xml (XML object)
         * Return value(s): sumCompletedTags (int) number of completed tags with a 1 value
         ***********************************************/
        function xmlGetComplete(xml) {
            var xmlDoc = xml.responseXML;
            elemCompleted = xmlDoc.getElementsByTagName('completed');
            elemLenght = elemCompleted.length;
            for (i = 0; i < elemLenght; i++) {
                if (elemCompleted[i].childNodes[0].nodeValue == 1)
                    sumCompletedTags++
            }
            return sumCompletedTags;
        }

        /**********************************************
         *Function: winLocation
         *Description: Declares the location on which the window will be replaced
         * Parameter(string): Training Type
         * Return value(string): URL that will replace the window
         ***********************************************/
        function winLocation(type) {
            var trainLoc = "";
            if("<?php echo $priv?>" == 'admin'){
                trainLoc = 'http://localhost/BandoCat/Training/'+ "<?php echo $collection ?>" +'/Forms/list.php?col='+ "<?php echo $collection ?>" +'&action=training&type='+ type +'&user=<?php echo $username?>&priv=admin';
                console.log(trainLoc);
            }

            else
                trainLoc = 'http://localhost/BandoCat/Training/'+ "<?php echo $collection ?>" +'/Forms/list.php?col='+ "<?php echo $collection ?>" +'&action=training&type='+ type;
            return trainLoc;
        }

        /*On click events
        * 1. Link to the intermediate training
        * 2. Link to the newbie training
        * 3. While on the slideshow continue to the newbie training page
        * 4. While on any of the trainings it link to the training homepage
        * 5. While on the newbie training it links to the intermediate page
        * 6. Resets training, Admin only*/

        //1
        $('#bandocatInter').click(function () {
            var progressText = parseInt($('#progressBar').text());

            if(progressText < 38) {
                return false;
            }

            if(progressText >= 38){
                $("#bandocatInter").css('opacity', '1');
                trainLoc = winLocation('inter');
                window.location.href = trainLoc
            }
        });

        //2
        $("#bandocatNewbie").click(function () {
            trainLoc = winLocation('newbie');
            window.location.href = trainLoc
        });

        //3
        $("#continue").click(function () {
            trainLoc = winLocation('newbie');
            window.location.href = trainLoc
        });

        //4
        function backList() {
            trainLoc = winLocation('none');
            window.location.href = trainLoc
        }

       //5
        function linkInter() {
           trainLoc = winLocation('inter');
            window.location.href = trainLoc
        }

        //6
        $("#resetTraining").click(function () {
        $.ajax({
            type: 'post',
            url: "resetTraining.php",
            data: JSON.parse('{"filename": "' + "<?php echo $training_user_dir ?>" + '", "user": "' + "<?php echo $username?>" + '"}'),
            success: function (result) {
                if(result) {
                    console.log(result)
                    window.location.href = '../../admin/admin.php'
                }
            }
        });
    });
    </script>
	</body>
	</html>