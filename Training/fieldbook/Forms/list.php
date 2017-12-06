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
	<title><?php echo ucfirst($collection); ?> Training <?php if($priv == 'admin') echo $username; elseif($type == 'inter') echo 'Intermediate Level'; elseif($type == 'newbie') echo 'Beginner Level'; elseif ($type == 'none') echo 'Homepage' ?></title>
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
                <h2 id="page_title"><?php echo ucfirst($collection); ?> Training <?php if($priv == 'admin') echo $username; elseif($type == 'inter') echo 'Intermediate Level'; elseif($type == 'newbie') echo 'Beginner Level'; elseif ($type == 'none') echo 'Homepage' ?></h2>

                <!--Training Progress/Progress Bar-->
                <div id="trainingProgress">
                    <div id="progressBar"></div>
                </div>

                <!--New Collection Information-->
                <!--Document table list-->
                <div id="divscroller" style="display: none;">
                    <table id="dtable" class="display compact cell-border hover stripe" cellspacing="0" width="100%" data-page-length='14'>
                        <thead>
                        <tr>
                            <th>Document Link</th>
                            <th>Library Index</th>
                            <th>Job Title</th>
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
                            $docArray = array();
                            //For each document as node
                            foreach ($nodes as $node) {
                                //Block of conditional statements that obtains the childnode values from every document
                                //to be displayed in the data table
                                foreach ($node->childNodes as $child) {
                                    if ($child->nodeName == 'libraryindex') {
                                        $libraryindex = $child->nodeValue;
                                    }
                                    elseif ($child->nodeName == 'jobtitle') {
                                        $jobtitle = $child->nodeValue;
                                    }
                                    elseif ($child->nodeName == 'customername') {
                                        $customername = $child->nodeValue;
                                    }
                                    elseif ($child->nodeName == 'author') {
                                        $author = $child->nodeValue;
                                    }
                                    elseif ($child->nodeName == 'needsreview') {
                                        $needsreview = $child->nodeValue;
                                    }
                                    elseif ($child->nodeName == 'endmonth') {
                                        if($child->nodeValue == '')
                                            $endmonth = '00';
                                        else
                                        $endmonth = $child->nodeValue;
                                    }
                                    elseif ($child->nodeName == 'endday') {
                                        if($child->nodeValue == '')
                                            $endday = '00';
                                        else
                                        $endday = $child->nodeValue;
                                    }
                                    elseif ($child->nodeName == 'endyear') {
                                        if($child->nodeValue == '')
                                            $endyear = '0000';
                                        else
                                        $endyear = $child->nodeValue;
                                    }
                                    elseif ($child->nodeName == 'coast') {
                                        $coast = $child->nodeValue;
                                    } elseif ($child->nodeName == 'needsreview') {
                                        $needsreview = $child->nodeValue;
                                    }
                                    elseif ($child->nodeName == 'id')
                                    {
                                        $id = $child->nodeValue;
                                    }
                                }
                                $docArray[] = array("libraryIndex" =>[$libraryindex], "id" => $id);

                                //Outputs into the table a document childnode by row and its attributes by table data
                                echo '<tr>';
                                echo "<td align = 'center'><a target='_blank' href=\"index.php?id=$id&user=$userfile&col=$collection&type=$type&priv=$priv\">Edit</a></td>";
                                echo "<td align = 'center'>$libraryindex</td>";
                                echo "<td align = 'center'>$jobtitle</td>";
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
                        <img id="slideImg0" class="slideImg" src="" style="width:100%">
                        <input type="button" id="nextSlide0" class="nextPresentation" onclick="currentSlide(1, 5)" value="next" style="display: none">
                        </div>
                    <div class="mySlides">
                        <img id="slideImg1" class="slideImg" src="" style="width:100%">
                        <input type="button" id="nextSlide1" class="nextPresentation" value="next" onclick="currentSlide(2, 4)" style="display: none">
                    </div>
                    <div class="mySlides">
                        <img id="slideImg2" class="slideImg" src="" style="width:100%">
                        <input type="button" id="nextSlide2" class="nextPresentation" value="next" onclick="currentSlide(3, 7)" style="display: none">
                    </div><div class="mySlides">
                        <img id="slideImg3" class="slideImg" src="" style="width:100%">
                        <img id="slideImg3" class="slideImg" src="" style="width:100%">
                        <input type="button" id="nextSlide3" class="nextPresentation" value="next" onclick="currentSlide(4, 0)" style="display: none">
                    </div>
                    <div class="mySlides">
                        <div id="continue" style="padding: 30%;"><input type="button" class="bluebtn" name="linkLists" style="display: block; margin: auto; position: relative; z-index: 2; padding: 10% 75% 10% 10% !important;" value="Click to Continue To your Training"></div>
                        <img id="slideImg4" class="slideImg" src="" style="width:100%; margin: -70.4% 0% 0% 0%">
                    </div>

                    <a class="prevSlide" name="slider" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="nextSlide" name="slider" onclick="plusSlides(1)">&#10095;</a>
                    <div style="text-align:center; margin-top: -1.3%; z-index: 1; position: relative">
                        <span id="pt0" class="dot" onclick="currentSlide(0, 0)">Welcome</span>
                        <span id="pt1" class="dot" onclick="currentSlide(1, 5)">List Page</span>
                        <span id="pt2" class="dot" >Homepage</span>
                        <span id="pt3" class="dot" >Input Page</span>
                        <span id="pt4" class="dot" >Training</span>
                    </div>
                </div>
                <!--Continue Bandocat Image Buttons-->
                <div id="homepage" style="display: none">
                    <span id="continueNewbi" class="continueSpan"><img src="../../images/cat_scanner_white_bg.png" id="bandocatNewbie"  class="bandocatImage"></a></span>
                    <span id="continueInter" class="continueSpan"><img src="../../images/bandocat_explorer.png" id="bandocatInter" class="bandocatImage" style="opacity: 0.5;"></a></span>
                    <!--Training Tabs-->
                    <div id="trainingTabs">
                        <ul>
                            <li><a href="#tabs-1">Training Tips</a></li>
                            <li><a href="#tabs-2">Help</a></li>
                            <?php if($priv == 'admin') echo '<li><a href="#tabs-3">Admin</a></li>'?>
                        </ul>
                        <div id="tabs-1">
                            <ul>
                                <li>Always leave the Needs Review field as yes.</li>
                                <li>Always ask questions.</li>
                                <li>Remember to use the Classification Description to understand a classification.</li>
                                <li>If stuck while cataloging, refer to previously cataloged input documents.</li>
                            </ul>
                        </div>
                        <div id="tabs-2">
                            <p>Trainer's contact Info</p>
                            <p>Link to procedures</p>
                            <p id="slideshowLink" style="text-decoration: underline">Slideshow Presentation</p>
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
        //Window Height
        var windowHeight = window.innerHeight;
        var divleftWidth = $("#divleft").width();
        $('#divscroller').height(windowHeight - (windowHeight * 0.20));
        $('#homepage').height(windowHeight - (windowHeight * 0.20));
        $('.slideshow-container').height(windowHeight - (windowHeight * 0.10));
        if(divleftWidth <= 256) {
            $('#divscroller').css('margin-left', '1.5%')
        }

        $(window).resize(function (event) {
            divleftWidth = $("#divleft").width();
            windowHeight = event.target.innerHeight;
            $('#divscroller').height(windowHeight - (windowHeight * 0.20));
            $('#homepage').height(windowHeight - (windowHeight * 0.20));
            $('.slideshow-container').height(windowHeight - (windowHeight * 0.10));
            if(divleftWidth <= 256)
                $('#divscroller').css('margin-left', '1.5%');
            else
                $('#divscroller').css('margin-left', '0%')
        });





//Presentation progress
var ptprg = 0;
//Slide progress
var sldprg = 0;
//Presentation Page Index
var ptdx = 0;
//Slide Presentation Index
var slddx = 0;
//Number of Slides in a presentation
var nslddx = 1;


//First Slide
showSlides(ptdx, slddx, nslddx);

//Slider click event
/**********************************************
 * Function: plusSlides
 * Description: Increments or decrements the slide index integer
 * Parameter(s): n (integer) a 1 to increment or -1 to decrease the presentation slide index display
 * Return value(s): None
 ***********************************************/
function plusSlides(n) {
    showSlides(ptdx, slddx += n, nslddx);
}

//Page presentation click event
/**********************************************
 * Function: currentSlide
 * Description: Function that calls and resets the showSlides function back to the initial slide. Also, sets flags to
 * determine if the user has completed a presentation so to continue to the next presentation.
 * Parameter(s): pt (integer) Presentation number
 * nslddx (integer) Number of slides in the presentation
 * Return value(s): None
 ***********************************************/
function currentSlide(pt, nslddx) {
    //Resets slide show to the first slide
    showSlides(pt, 0, nslddx);
    //Flag that determines if a new presentation has been selected
    if(ptprg != pt)
        //Resets the presentation progress
        sldprg = 0;
    //Stores the presentation index
    ptprg = pt;


    //Event that is triggered if the next contiguous presentation button is clicked
    $("#pt"+String(pt+1)).click(function (event) {
        //If all of the presentation slides have been observed the event will call the currentSlide to display the
        // oncoming presentation
        if(sldprg == nslddx-1){
            if(pt == 1){
                currentSlide(pt+1, 4);
                $("#pt"+String(pt+1)).attr('onClick', 'currentSlide(2, 4)')
            }
            else if (pt == 2){
                currentSlide(pt+1, 7);
                $("#pt"+String(pt+1)).attr('onClick', 'currentSlide(3, 8)')
            }
            else if (pt == 3) {
                currentSlide(pt+1, 1)
                $("#pt"+String(pt+1)).attr('onClick', 'currentSlide(4, 1)')
            }
        }

        //Otherwise it prevents the event from propagating
        else
            event.stopPropagation()
    });
}

/**********************************************
 * Function: showSlides
 * Description: Function that displays the image slides
 * Parameter(s): pt (integer) Presentation number
 * sld (integer) Slide index
 * nsld (integer) Number of slides in the presentation
 * Return value(s): None
 ***********************************************/
//Tabs are presentations
        function showSlides(pt, sld, nsld) {
            var i;
            ptdx = pt;
            nslddx = nsld;
            slddx = sld;
            //Slide Elements
            var slides = document.getElementsByClassName("mySlides");
            //Presentation Elements
            var dots = document.getElementsByClassName("dot");
            //If on last slide proceed to first slide
            if (sld > nsld-1) { slddx = 0}

            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[ptdx].style.display = "block";

    if(pt == 2){
        $("#pt"+String(pt)).attr('onClick', 'currentSlide(2, 4)')
    }
    else if (pt == 3){
        $("#pt"+String(pt)).attr('onClick', 'currentSlide(3, 7)')
    }
    else if (pt == 4) {
        $("#pt"+String(pt)).attr('onClick', 'currentSlide(4, 1)')
    }

            imgSource(ptdx, slddx, nslddx);

    /**********************************************
     * Function: imgSource
     * Description: Function that obtains the path of the slide image for display. Also, manipulates the slider style to
     * match the slideshow requirement.
     * Parameter(s): pt (integer) Presentation number
     * sld (integer) Slide index
     * nsld (integer) Number of slides in the presentation
     * Return value(s): None
     ***********************************************/
            function imgSource(presentation, slide, nSlide) {
                //Image Element
                var image = $("#slideImg" + String(presentation));
                //If the presentation contains only one slide no slider will be displayed
                if(nSlide < 2){
                    $("[name='slider']").css("display", "none");
                    $("#nextSlide"+String(presentation)).css("display", "block")
                }
                else
                    $("[name='slider']").css("display", "block");
                //If the presentation is on its first slide the user won't be able to go to the last slide
                if(slide == 0)
                    $(".prevSlide").css("display", "none");
                else if(slide == nSlide-1){
                    $(".nextSlide").css("display", "none");
                    $("#nextSlide"+String(presentation)).css("display", "block")
                }


                image.attr("src", "../../fieldbook/Images/slideshow/slides/Slide0" + String(presentation) + "/slide0" + String(presentation) + "-0" + String(slide) + ".png");

                //Stores the index of the highest slide that has been seen by the user
                if (slide > nSlide-2)
                    sldprg = slide;
            }
            dots[ptdx].className += " active";
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
                $('div').remove('#homepage');
                $('#divscroller').css('display', 'block');
                $('div').remove('.slideshow-container');
                $("<div id='buttonList' style='padding: 2%;'><input type='button' onclick='backList()' id='backList' class='bluebtn' id='trainingButton' value='Back to Training Home'></div>").appendTo("#divscroller")
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
        var newbieCompletedTags = 0;
        function trainingProgress() {
            //Stores the progress of the training
            var progress = 0;
            //Stores the progress of the newbie training

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
                    xhttp_inter.open("GET", "<?php echo $training_user_dir . '/' . $userfile . '_inter.xml?p='.rand(1,100) ?>", true);
                    xhttp_inter.send();
                }
            };
            xhttp_newbie.open("GET", "<?php echo $training_user_dir.'/'.$userfile.'_newbie.xml?p='.rand(1,100) ?>", true);
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
                    $("#trainingProgress").css('display', 'none');
                    $("#homepage").css('display', 'none');
                    $('#trainingButton').css('display', 'none');
                    $('.slideshow-container').css('display', 'block');
                    if("<?php echo $type ?>" == 'newbie')
                        $('.slideshow-container').css('display', 'none');
                }

                else{
                    $('.slideshow-container').css('display', 'none');
                    $("#homepage").css('display', 'block');
                }

                if(sequence == 100) {
                    window.location.href = 'mailto:aneumann1@islander.tamucc.edu; bgillis@islander.tamucc.edu?subject='+encodeURI( '<?php echo $username?> ' + '<?php echo $collection?>'+ ' training completion')+'&body='+encodeURI('Congratulations '+ '<?php echo $username?>'+'! \n\nSend this email to confirm your successful completion of your '+'<?php echo $collection?>' + ' training.\nTraining Documents: '+ String(completedTags) +'\nCompleted Documents: '+ String(completeTagsLength))+'\
                    \n\n\nid: ' + '<?php echo $username ?>' + String(new Date().getTime()) + 'AD-' + String(Math.random());
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

                        /*Conditions the completion of the newbie training, the newbie training type, and last frame
                        display call to continue to the intermediate level*/
                        if(newbieCompletedTags == 1 && '<?php echo $type ?>' == 'newbie'){
                            $("#buttonList").append("<input type='button' id='linkInter' onclick='linkInter()' class='bluebtn' style='margin-left: 60%; background: orange' id='trainingButton' value='Continue to Next Level'>")
                        }

                        //Styles Bandocat Intermediate Image link
                        if(newbieCompletedTags == 1) {

                            if($('#dtable').is(':visible')) {
                                if("<?php echo $type ?>" == 'newbie')
                                {
                                    $('#dtable>thead>tr').append("<th class='sorting ui-state-default' tabindex='0' aria-controls='dtable' rowspan='1' colspan='1' aria-label='Answers: activate to sort column ascending' style='width: 0px'>Answers</th>");
                                    var tableRows =  $('#dtable>tbody>tr');
                                    var libID = JSON.stringify(<?php echo json_encode($docArray) ?>);
                                    var JSONdoc = JSON.parse(libID);
                                    var tm = 0;
                                    function libraryMatch(libraryIdx) {

                                        for(var j = 0; j < JSONdoc.length; j++) {
                                            if(libraryIdx == JSONdoc[j].libraryIndex) {
                                                var linkID = JSONdoc[j].id;
                                            }
                                        }
                                        tableData = $('#dtable>thead>tr').children();
                                        $("<td align='center'><a href='index.php?id=" + linkID + "&user=" + "<?php echo $userfile ?>" + "&col=" + "<?php echo $collection ?>" + "&type=answer&priv=" + "<?php echo $priv ?>" + "'>Answer</a></td>").insertAfter($('#dtable>tbody>tr')[tm].childNodes[tableData.length-2]);
                                        tm += 1;
                                    }

                                    //console.log(tableRows.length);
                                    for(var i = 0; i < tableRows.length; i++) {
                                        libraryMatch($('#dtable>tbody>tr')[i].childNodes[1].innerHTML)
                                    }
                                }
                            }


                            $("#bandocatInter").css('opacity', '1');
                            $("#bandocatInter").mouseover(function(){
                                $(this).css("cursor", "pointer");
                                $(this).css("box-shadow", "1px 0px 6px black");
                                $(this).css("border-radius", "14px");
                            }).mouseleave( function () {
                                $(this).css("box-shadow", "none");
                                $(this).css("border-radius", "0px");
                            });
                        }

                        //Styles Bandocat Newbie Image link
                        if (newbieCompletedTags <= 1) {
                            $("#bandocatNewbie").hover(function(){
                                $(this).css("cursor", "pointer");
                                $(this).css("box-shadow", "1px 0px 6px black");
                                $(this).css("border-radius", "14px");
                            }).mouseleave( function () {
                                $(this).css("box-shadow", "none");
                                $(this).css("border-radius", "0px");
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
                trainLoc = 'list.php?col='+ "<?php echo $collection ?>" +'&action=training&type='+ type +'&user=<?php echo $username?>&priv=admin';
                console.log(trainLoc);
            }

            else
                trainLoc = 'list.php?col='+ "<?php echo $collection ?>" +'&action=training&type='+ type;
            return trainLoc;
        }

        /*On click events
        * 1. Link to the intermediate training
        * 2. Link to the newbie training
        * 3. Link to the slideshow presentation
        * 4. While on the slideshow continue to the newbie training page
        * 5. While on any of the trainings it link to the training homepage
        * 6. While on the newbie training it links to the intermediate page
        * 7. Resets training, Admin only*/

        //1
        $('#bandocatInter').click(function () {
            var progressText = parseInt($('#progressBar').text());

            if(newbieCompletedTags < 1) {
                return false;
            }

            if(newbieCompletedTags == 1){
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
        $("#slideshowLink").click(function () {
            $("#trainingProgress").css('display', 'none');
            $("#homepage").css('display', 'none');
            $('#trainingButton').css('display', 'none');
            $('.slideshow-container').css('display', 'block');
        });

        $("#slideshowLink").hover(function () {
           $("#slideshowLink").css("cursor", "pointer")
        });

        //4
        $("#continue").click(function () {
            trainLoc = winLocation('newbie');
            window.location.href = trainLoc
        });

        //5
        function backList() {
            trainLoc = winLocation('none');
            window.location.href = trainLoc
        }

       //6
        function linkInter() {
           trainLoc = winLocation('inter');
            window.location.href = trainLoc
        }

        //7
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