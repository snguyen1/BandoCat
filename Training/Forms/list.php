<?php
include '../../Library/SessionManager.php';
require('../../Library/DBHelper.php');
$session = new SessionManager();
//Get collection name and action
	$username = $_SESSION["username"];
$collection = $_GET["col"];
	$userfile = "";

	include 'config.php';
$file_arr = array();

//list of files in the directory
if($_SESSION["role"] == 1)
{
    $pos = -1;
    $listfile = scandir(getcwd());

    //Conditions to save only xml files to the file_arr array
    foreach($listfile as $row)
    {
        $pos = -1;
        $pos = strpos($row,".xml");
        if($pos != 0){
            //echo '<a href="list.php?user='  . $row . '">' . $row . '</a>';
            array_push($file_arr,$row);
        }
    }

    if(isset($_GET["user"]))
    {
        $userfile = str_replace(".xml","",$_GET["user"]);
        if($userfile == "")
            $userfile = $username;
    }
    else $userfile = $username;
}
else $userfile = $username;
?>


<!DOCTYPE html>
<head>
	<title>Edit Map Information</title>
	<!-- <meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" /> -->
	<meta http-equiv = "Content-Type" content = "text/html; charset = utf-8" />
    <!-- Style CSS -->
		<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="../../ExtLibrary/DataTables-1.10.12/css/jquery.dataTables_themeroller.css">
        <link rel = "stylesheet" type = "text/css" href = "../../Master/master.css" >
    <link rel="stylesheet" type="text/css" href="../styles.css"/>
    <!--Script-->
    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="../../ExtLibrary/jQuery-2.2.3/jquery-2.2.3.js"></script>
    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="../../ExtLibrary/DataTables-1.10.12/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
    <div id="wrap">
        <div id="main">
            <div id="divleft">
                <?php include '../../Master/header.php';
                include '../../Master/sidemenu.php' ?>
            </div>
            <div id="divright">
                <h2 id="page_title">Training <?php if($_GET['type']== 'newbie') echo $_GET['type']; else echo "Intermediate"; ?></h2>

                <!--Training Progress/Progress Bar-->
                <div id="trainingProgress">
                    <div id="progressBar"></div>
                </div>

                <!--Document table list-->
                <div id="divscroller" style="display: none;">
                    <table id="dtable" class="display compact cell-border hover stripe" cellspacing="0" width="100%" data-page-length='10'>
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
                        <!--Block of code that load the information from the xml file to the table-->
                            <?php
                            $training_parent = "../Training_Collections";
                            //Collection directory
                            $training_collection_dir = $training_parent.'/'.$collection;
                            //User directory
                            $training_user_dir = $training_collection_dir.'/'.$userfile;
                            $document = new DOMDocument();
                            if ($_GET['type'] == 'newbie') {
                                $document->load($training_user_dir.'/'.$userfile.'_newbie.xml');
                            } elseif ($_GET['type'] == 'inter') {
                                $document->load($training_user_dir.'/'.$userfile.'_inter.xml');
                            }

                            $nodes = $document->getElementsByTagName('document');
                            $count = 0;
                            foreach ($nodes as $node) {
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
                                $type = $_GET['type'];


                                echo '<tr>';
                                echo "<td align = 'center'><a href=\"index.php?id=$id&user=$userfile&col=$collection&type=$type\">$libraryindex</a></td>";
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


                        <div id="continueInter"></div>
                        
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
                <!--Continue button-->
                <div id="continueTraining">
                    <span id="continueNewbi" class="continueSpan"><a href="http://localhost/BandoCat/Training/Forms/list.php?col=jobfolder&action=training&type=newbie"><img src="../images/BandoCatScan.PNG" class="bandocatImage"></a></span>
                    <span id="continueInter" class="continueSpan"><img src="../images/BandoCatScan.PNG" id="bandocatInter" class="bandocatImage" style="opacity: 0.5;"></a></span>
                    <div id="trainingTabs">
                        <ul>
                            <li><a href="#tabs-1">Training Tips</a></li>
                            <li><a href="#tabs-2">Help</a></li>
                            <li><a href="#tabs-3">Admin</a></li>
                        </ul>
                        <div id="tabs-1">
                            <ul>
                                <li>Always leave the Needs Review field as yes</li>
                            </ul>
                        </div>
                        <div id="tabs-2">
                            <p>Ana's contact Info</p>
                        </div>
                        <div id="tabs-3">
                            <table width="100%" style="text-align:center">
                                <tr>
                                    <td><label class="unselectable" for="username">Username</label>
                                    </td>
                                    <td>
                                        <input type="text" id="txtUsername" name="username" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="unselectable" for="password">Password</label></td>
                                    <td>
                                        <input type="password" id="txtPassword" name="password" required>

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="submit" name = "login" id="btnSubmit" value="Login" class="bluebtn"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><p id="txt_error"></p></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>


    <script>

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
    </script>
    
    
    
    
    


    <!--Table container-->
<!--	<!--<div id = "interContainer" style="display: none">-->
<!--	 		--><?php //if($_SESSION["role"] == 'Admin'){ ?>
<!--	 		 <form enctype="multipart/form-data" id="switch" name="switch" method="GET">-->
<!--	 			<p>Switch View:-->
<!--	 			<select id="ddl_switch" name="user">-->
<!--	 				<option value="">Select a file...</option>-->
<!--	 				--><?php
//	 					foreach($file_arr as $a)
//	 					{
//	 						if(isset($_GET['user']) && $_GET['user'] == $a && $a != "")
//	 							echo '<option selected value="' . $a . '">' . $a . '</option>';
//	 						else echo '<option value="' . $a . '">' . $a . '</option>';
//	 					}
//	 				?>
<!--	 			</select>-->
<!--	 		</form>-->
<!--	 		--><?php //} ?>
<!--	 		<form enctype="multipart/form-data" onsubmit = "return confirmReset()" action = ""  method = "POST">-->
<!--	 			<input  align="center" class="button button-blue" name="resetProfile" type="submit" value="Reset Training Session" />-->
<!--	 		</form>-->
<!---->
<!--        --><?php ////Array with all the xml files in the directory
//
//
//        ?>
<!---->
<!--	 		--><?php
//	 			if (isset($_POST['resetProfile'])) {
//	 					if(copy("data.xml", $userfile . ".xml" ))
//	 					{
//	 						echo "<script>window.location = 'list.php'</script>";
//	 					}
//	 					else
//	 					{
//	 						print "<script type=\"text/javascript\">";
//							print "alert('An error has occured')";
//							print "</script>";
//	 					}
//	 			}
//	 		 ?>
<!---->
<!---->
<!--	     	<table id = "tableMap1" >-->
<!---->
<!--	    	</table>-->
<!--	    <br><br>-->
<!--	</div>-->

    <script type="text/javascript">
    var trainingCollectionsJSON =  {"col": '<?php echo $collection ?>', "user": '<?php echo $username?>', "loc": 'parent'};

        //Function that creates the training directory by collection, user, and training type and it is triggered when the document is ready
        $( document ).ready(function() {
            if("<?php echo $_GET['type']?>" == 'newbie' || "<?php echo $_GET['type']?>" == 'inter'){
                $('#newbie').css('display', 'none');
                $('#intermediate').css('display', 'none');
                $('div').remove('#continueTraining');
                $('#divscroller').css('display', 'block');
                $('div').remove('.slideshow-container');
                $( "#divscroller" ).after( "<div id='buttonList' style='padding: 5%;'><input type='button' onclick='backList()' id='backList' class='bluebtn' id='trainingButton' value='Back to Training Home'></div>" );
            }


            $('#dtable').dataTable({
                "bJQueryUI": true,
                "order": [[3, "desc"]],
                //'sPaginationType': 'full_numbers',
                "lengthMenu": [10, 25, 50],
                "iDisplayLength":10
            });

            $( function() {
                $( "#trainingTabs" ).tabs();
            } );

            $.ajax({
                type: 'post',
                url: "collectionTrainingXML.php",
                data: trainingCollectionsJSON
            });
        });

        function confirmReset() {
            var x =confirm("Are you sure want to reset your Training session?");
            if ( x == true) {
                return true;
            } else {
                return false;
            }
        }
        var progress = 0;
        var frameDisplay = 0;
        //Count the number of completed training documents to display in a progress bar
        function trainingProgress() {
            var xhttp_newbie = new XMLHttpRequest();
            var xhttp_inter = new XMLHttpRequest();


            xhttp_newbie.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    completedTags = 0;
                    elemCompletedLenght = 0;
                    completeTagsLenght = xmlGetLenght(this);
                    completedTags = xmlGetComplete(this);
                    progress = progressComplete(completedTags, completeTagsLenght);
                    xhttp_inter.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            completeTagsLenght = xmlGetLenght(this);
                            completedTags = xmlGetComplete(this);
                            progress = progressComplete(completedTags, completeTagsLenght);
                        }

                    };
                    xhttp_inter.open("GET", "<?php echo $training_user_dir . '/' . $userfile . '_inter.xml' ?>", true);
                    xhttp_inter.send();
                }
            };
            xhttp_newbie.open("GET", "<?php echo $training_user_dir.'/'.$userfile.'_newbie.xml' ?>", true);
            xhttp_newbie.send();


            var sequence = 0;
            function progressComplete(completedTags, completeTagsLength ) {
                var width = 1;
                progressLevel = (completedTags/completeTagsLength)*100;
                sequence = parseInt(progressLevel);

                if(progressLevel == 0) {
                    progressLevel = 3;
                    $('.slideshow-container').css('display', 'block');
                    $("#continueTraining").css('display', 'none');
                    $('#trainingButton').css('display', 'none');
                    if("<?php echo $_GET['type']?>" == 'newbie')
                        $('.slideshow-container').css('display', 'none');
                }

                else{
                    $('.slideshow-container').css('display', 'none')
                }

                var id = setInterval(frame, 10);
                function frame() {
                    if (width >= progressLevel-1){
                        frameDisplay++;
                        clearInterval(id);
                        if(sequence >= 38 && '<?php echo $_GET['type']?>' == 'newbie' && frameDisplay == 2){
                            $("#buttonList").append("<input type='button' id='linkInter' onclick='linkInter()' class='bluebtn' style='margin-left: 60%; background: orange' id='trainingButton' value='Continue to Next Level'>")
                        }
                        if(sequence >= 38 && frameDisplay == 2) {
                            $("#bandocatInter").css('opacity', '1');
                            $("#bandocatInter").hover(function(){
                                $(this).css("cursor", "pointer");
                            });
                        }

                    }


                     else {
                        width++;
                        $('#progressBar').width(width+'%').height(20).css("background-color", "green").css("height", "").css("text-align", "center").text(sequence + ' %');

                    }
                }
            }
       }
var elemCompletedLenght = 0;
        function xmlGetLenght(xml) {
            var xmlDoc = xml.responseXML;
            elemCompleted = xmlDoc.getElementsByTagName('completed');
            elemCompletedLenght += elemCompleted.length;
            return elemCompletedLenght
        }

var sumCompletedTags = 0;
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

        trainingProgress();

        //On click events
        $('#bandocatInter').click(function () {
            var progressText = parseInt($('#progressBar').text());

            if(progressText < 38) {
                return false;
            }

            if(progressText >= 38){
                $("#bandocatInter").css('opacity', '1');
                window.location.href = 'http://localhost/BandoCat/Training/Forms/list.php?col=jobfolder&action=training&type=inter';
            }
        });

        function backList() {
            window.location.href = "http://localhost/BandoCat/Training/Forms/list.php?col=jobfolder&action=training&type=none"
        }

       function linkInter() {
            window.location.href = 'http://localhost/BandoCat/Training/Forms/list.php?col=jobfolder&action=training&type=inter';
        }

        $(function() {
            $('#ddl_switch').change(function() {
                this.form.submit();
            });
        });



    </script>
	</body>
	</html>