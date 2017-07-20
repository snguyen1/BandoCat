<?php
include '../../Library/SessionManager.php';
require('../../Library/DBHelper.php');
require '../../Library/ControlsRender.php';

$Render = new ControlsRender();
$session = new SessionManager();

$username = $_GET["user"];
$collection = $_GET['col'];
$type = $_GET['type'];
$priv = $_GET['priv'];


if ($type == 'newbie') {
    include 'newbieClass.php';
} elseif ($type == 'inter') {
    include 'interClass.php';
}

include 'config.php';
include 'main.php';

$doc_id = $_GET["id"];
$userType = $username . '_' . $type;
$XMLfile = XMLfilename($userType);


$file = simplexml_load_file('../Training_Collections/' . $collection . '/'.$username.'/'. $XMLfile) or die("Cannot open file!");
foreach ($file->document as $a) {
    if ($a->id == $doc_id) {
        if ($a["collection"] == $collection) {
            $doc1 = new JobFolder($collection,'../Training_Collections/' . $collection . '/'.$username.'/'. $XMLfile, $username, $doc_id);
            break;
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>[Training] Job Folder</title>
    <link rel = "stylesheet" type = "text/css" href = "../../Master/master.css" >
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="../../ExtLibrary/jQuery-2.2.3/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="../../ExtLibrary/jQueryUI-1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="../../Master/master.js"></script>
</head>
<body>
    <div id="wrap">
        <div id="main">
            <div id="divleft">
                <?php include '../../Master/header.php';
                include '../../Master/sidemenu.php' ?>
                <div id="descriptionBox">
                    <table id="tableClass">
                        <tr>
                            <th>
                                <h3 id="txtClass" style="margin: 2% 4% 0% 4%; background-color: #0067C5; color: white">Classification Description</h3>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <h4 id="className" style="text-align: center; margin: 2% 0% 0% 0%"></h4>
                            </td>
                        </tr>
                        <tr>
                            <td><p id="tdClass" style="text-align: center; margin: -1% 0% 4% 0%"></p></td>
                        </tr>
                    </table>
                </div>
                </div>
        </div>


        <div id="divright">
            <h2> Input Training Session </h2>
            <div id="divscroller" style="height: 776px">
                <!--<p id="field"> (*) required field <br><br> (Hover mouse on 'Needs Review' to know instruction) </p>-->
                <form id="theform" name="theform" method="post">
                    <table class="Account_Table">
                        <td id="col1">
                            <!-- LIBRARY INDEX -->
                            <div class="cell">
                                <span class="labelradio">
                                    <mark class="label">
                                        <span style = "color:red;"> * </span>
                                        Library Index:
                                    </mark>
                                    <p hidden>
                                        <b></b>
                                        <strong>Library Index: </strong>The library index is the name of a scanned document. Copy and paste the image’s name into the textbox exactly as you see it.<br><i>Example: </i><?php echo $doc1->libraryindex; ?>
                                    </p>
                                </span>
                                <input type = "text" name = "txtLibraryIndex" id = "txtLibraryIndex" size="26" value='<?php echo $doc1->libraryindex; ?>' required />
                            </div>
                            <!-- TITLE -->
                            <div class="cell">
                                <span class="labelradio"><mark class="label"><span style = "color:red;"> * </span>Document Title: </mark><p hidden><b></b><strong>Document Title: </strong>This can be printed or hand written, but it is typically found across the top of the document. If one cannot be found, enter the library index.</br><strong>Envelopes: </strong>An envelope will always be given the title of the library index.</p></span>
                                <input type = "text" name = "txtTitle" id = "txtTitle" size="26" required="true" value='<?php echo $doc1->title; ?>' />
                            </div>
                            <!-- NEEDS REVIEW -->
                            <div class="cell">
                                <span class="labelradio" >
                                <mark>Needs Review: </mark>
                                <p hidden><b></b>This is to signal if a review is needed</p>
                                </span>
                                <input type = "radio" name = "rbNeedsReview" id = "rbNeedsReview_yes" size="26" value="1" <?php if($doc1->needsreview == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbNeedsReview" id = "rbNeedsReview_no" size="26" value="0" <?php if($doc1->needsreview == 0) echo "checked"; ?>  />No
                            </div>
                            <!-- SUB FOLDER -->
                            <div class="cell">
                                <span class="labelradio" >
                                <mark>In A Subfolder: </mark>
                                <p hidden><b></b>This document belongs in a subfolder</p>
                                </span>
                                <input type = "radio" name = "rbInASubfolder" id = "rbInASubfolder_yes" size="26" value="1" <?php if($doc1->inasubfolder == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbInASubfolder" id = "rbInASubfolder_no" size="26" value="0" <?php if($doc1->inasubfolder == 0) echo "checked"; ?> />No
                            </div>
                            <!-- SUBFOLDER COMMENTS -->
                            <div class="cell">
                                <span class="labelradio">
                                    <mark class="label">
                                        Subfolder Comments:
                                    </mark>
                                    <p hidden>
                                        <b></b>
                                        <strong>Subfolder Comments: </strong>The first document of a subfolder will say what to expect within the subfolder. If looking at the first document, type exactly what is written on the document into this box. If you are cataloging a consecutive document, copy the text from the first document into this box. All documents within the subfolder will have the subfolder comments from the first document.
                                    </p>
                                </span>
                                <textarea cols = "30" name="txtSubfolderComments" id="txtSubfolderComments"/><?php echo $doc1->subfoldercomments; ?></textarea>
                            </div>
                            <!-- CLASSIFICATION -->
                            <div class="cell">
                                <span class="labelradio">
                                    <mark class="label">
                                        Classification:
                                    </mark>
                                    <p hidden>
                                        <b></b>
                                        <strong>Classification: </strong>Classify the type of document. If you don’t know what it should be, consult the Classification Description box.
                                    </p>
                                </span>
                                <select id="ddlClassification" name="ddlClassification" style="width:215px">
                                    <?php
                                    classification($classification_arr, $doc1->classification);
                                    ?>
                                </select>
                            </div>
                            <!-- CLASSIFICATION COMMENTS-->
                            <div class="cell">
                                <span class="labelradio">
                                    <mark class="label">
                                        Classifications Comments:
                                    </mark>
                                    <p hidden>
                                        <b></b>
                                        <strong>Classifications Comments: </strong>This is reserved only for the folder’s envelope. Copy what is seen on the envelope into this box.
                                    </p>
                                </span>
                                <textarea rows = "2" cols = "30" id="txtClassificationComments" name="txtClassificationComments"/><?php echo $doc1->classificationcomments; ?></textarea>
                            </div>
                            <!-- GET START DDL MONTH -->
                            <div class="cell">

                                <select name="ddlStartMonth" id="ddlStartMonth" style="width:60px">
                                    <?php $Render->GET_DDL_MONTH($doc1->startmonth); ?>
                                </select>
                                <span class="labelradio">
                                    <mark class="label">
                                        Document Start Date:
                                    </mark>
                                    <p hidden>
                                        <b></b>
                                        <strong>Document Start Date: </strong>The earliest date on the document- as it pertains to the creation of that document.</br><i>*If there is one date on the document, only fill out the Document End Date boxes.</i>
                                    </p>
                                </span>
                                <!-- GET START DDL DAY -->
                                <select name="ddlStartDay" id="ddlStartDay" style="width:60px">
                                    <?php $Render->GET_DDL_DAY($doc1->startday); ?>
                                </select>
                                <!-- GET START DDL YEAR -->
                                <select id="ddlStartYear" name="ddlStartYear" style="width:85px">
                                    <?php $Render->GET_DDL_YEAR($doc1->startyear); ?>
                                </select>

                            </div>
                            <!-- GET END DDL MONTH -->
                            <div class="cell">
                                <select name="ddlEndMonth" id="ddlEndMonth" style="width:60px">
                                    <?php $Render->GET_DDL_MONTH($doc1->endmonth); ?>
                                </select>
                                <span class="labelradio">
                                    <mark class="label">
                                        Document Start Date:
                                    </mark>
                                    <p hidden>
                                        <b></b>
                                        <strong>Document Start Date: </strong>The latest date on the document- as it pertains to the creation of that document.
                                    </p>
                                </span>
                                <!-- GET END DDL DAY -->
                                <select name="ddlEndDay" id="ddlEndDay" style="width:60px">
                                    <?php $Render->GET_DDL_DAY($doc1->endday); ?>
                                </select>
                                <!-- GET END DDL YEAR -->
                                <select name="ddlEndYear" id="ddlEndYear" style="width:85px">
                                    <?php $Render->GET_DDL_YEAR($doc1->endyear); ?>
                                </select>
                            </div>
                            <!-- DOCUMENT AUTHOR -->
                            <div class="cell">
                                <div class='authorsCell' id="author0">
                                    <span class="labelradio">
                                    <mark class="label">
                                        Document Author:
                                    </mark>
                                    <p hidden>
                                        <b></b>
                                        <strong>Document Author: </strong>Who created the document. This can be found at the top of the document or at the end. However, if there are documents grouped together in sequence, with the author’s name on the last page, all the documents have the same author. If there are multiple authors, press the “+” to create more input boxes.
                                    </p>
                                </span>
                                    <div style="width: 110%">
                                    <input type="text" class="txtAuthor" name="txtAuthor[]" size="26" list="lstAuthor" value="<?php echo $doc1->author->name[0]?>"/>
                                    <span style="padding-right:5px"></span>

                                        <input type="button" id="more_fields" onclick="add_fields($('.authorsCell').length, null);" value="+"/>
                                        <input type="button" id="less_fields" onclick="remove_fields($('.authorsCell').length)" value="-">
                                    </div>
                                    </div>

                                <?php $lenAuthors = count($doc1->author->name);
                                for ($d = 1; $d < $lenAuthors; $d++) {
                                    echo '<div class="authorsCell" id="author'.$d.'" style="margin: 1% 0% 0% -1.5%"><span class="label">Document Author: </span>
                                    <input type="text" id="txtAuthor" name="txtAuthor[]" size="26" list="lstAuthor" value="'.$doc1->author->name[$d].'"/></div>';
                                }
                                ?>

                            </div>
                        </td>

                        <td id="col2" style="padding-left:40px">
                            <!-- COMMENTS-->
                            <div class="cell">
                                <span class="labelradio">
                                    <mark class="label">
                                        Comments:
                                    </mark>
                                    <p hidden>
                                        <b></b>
                                        <strong>Comments: </strong>Any additional information that needs to be included from the document. This can include the individuals involved in a correspondence, metadata from a map, sheet number, and job folder number.
                                    </p>
                                </span>
                                <textarea rows = "4" cols = "30" id="txtComments" name="txtComments"/><?php echo $doc1->comments; ?></textarea>
                                <br><br><br>
                            </div>
                            <!-- THUMBNAIL LINKS -->
                            <div class="cell" id="scanThumbnails">
                                <table>
                                    <tr>
                                        <!--SCAN OF FRONT-->
                                        <td style="text-align: center">
                                            <span class="label" style="text-align: center">Scan of Front</span><br>
                                            <?php
                                            $frontImage = realpath($doc1->frontimage);
                                            $backImage = realpath($doc1->backimage);
                                            echo "<a id='download_front' href=\"download.php?file=$frontImage\"><br><img src='". $doc1->frontthumbnail . " ' alt = Error /></a>";
                                            echo "<br>Size: " . round(filesize($doc1->frontimage)/1024/1024, 2) . " MB";
                                            echo "<br><a href=\"download.php?file=$frontImage\">(Click to download)</a>";
                                            ?>
                                        </td>
                                        <!--SCAN OF BACK-->
                                        <td style="text-align: center">
                                            <?php
                                            if($backImage != '../Training_Newbie_Images/Images/') //has Back Scan
                                            {

                                                echo '<span class="label" style="text-align: center">Scan of Back</span><br>';
                                                echo "<a id='download_front' href=\"download.php?file=$backImage\"><br><img src='". $doc1->backthumbnail . " ' alt = Error /></a>";
                                                echo "<br>Size: " . round(filesize($doc1->backimage) / 1024 / 1024, 2) . " MB";
                                                echo "<br><a href=\"download.php?file=$backImage\">(Click to download)</a>";
                                            }
                                            else
                                            {
                                                echo '<span class="label" style="text-align: center">No Scan of Back</span><br>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>

                        <tr>
                            <td colspan="2">
                                <div class="cell" style="text-align: center;padding-top:20px">
                                    <!-- Hidden inputs that are passed when the update button is hit -->
                                    <input type = "hidden" id="txtDocID" name = "txtDocID" value = "<?php echo $doc_id;?>" />
                                    <input type = "hidden" id="txtAction" name="txtAction" value="catalog" />  <!-- catalog or review -->
                                    <input type = "hidden" id="txtCollection" name="txtCollection" value="<?php echo $collection; ?>" />
                                    <span>
                                        <?php if($session->hasWritePermission()){
                                            echo "<input type='submit' id='btnSubmit' name='submit' value='Update' action='index.php' class='bluebtn'/>";
                                        }
                                        ?>
                                        <div class="bluebtn" id="loader" style="display: none">Updating
                                            <img style="width:4%" src='../../Images/loader.gif'/>
                                        </div>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>


	<!--<div id="drag_classification" class="ui-widget-content">
	<span id="title_class_desc">Classification Description</span>
	<form id="class_form" name="class_form" method="post">
		 <select id="ddl_class_desc" name="ddl_class_desc">
		 <?php
		 	for($i = 0; $i < count($classification_arr);$i++)
		 	{
		 		echo "<option value='" . $classification_arr[$i] . "'>" . $classification_arr[$i] . "</option>";
		 	}
		 ?>
		 </select>
		 <p id="txt_class_desc"></p>
		</div>
	</form>
	<div class = "navbar center">
	</div>-->
</body>


<?php
$data = file_get_contents('php://input')
?>


<script>
	  $(function() {
	    $( "#drag_classification" ).draggable();
	    $( "#drag_classification" ).resizable();
  	});
	  var ar_class = <?php echo json_encode($classification_arr); ?>;
	 var ar_class_desc = <?php echo json_encode($classification_desc); ?>;

	  $("#ddl_class_desc").change(function()
	  {
	  	var ddl_value = document.getElementById("ddl_class_desc").value;
	  	
	  	if (ddl_value == "none")
	  		document.getElementById("txt_class_desc").innerHTML = "";
	  	else
	  	{ 
	  		for (var i = 0; i < ar_class_desc.length; i++)
	  		{
	  			if(ddl_value == ar_class[i])
	  				document.getElementById("txt_class_desc").innerHTML = ar_class_desc[i];
	  		}
	  	}
	  });

      /**********************************************
      * Function: add_fields
      * Description: adds more fields for authors
                                          * Parameter(s):
      * val (in String ) - name of the author
      * Return value(s):
      * $result (assoc array) - return a document info in an associative array, or FALSE if failed
      ***********************************************/
      var max = 5;
      var author_count = 0;
      function add_fields(index, val) {
          if(val == null)
              val = "";
          if(author_count >= max)
              return false;
          $('#author'+(index-1)).after('' +
              '<div class="authorsCell" id="author'+ index +'" style="margin: 1% 0% 0% -1.5%">' +
              '<span class="label">Document Author: </span>' +
              '<input type = "text" name = "txtAuthor[]" autocomplete="off" class="txtAuthor" size="26" value="' + val + '" list="lstAuthor">' +
              '</div>')
          author_count++;
      }

      function remove_fields(index) {
          if(index < 2)
              return false;
          $('.authorsCell').last().remove();
          author_count--;
      }

      if("<?php echo $type?>" == "inter"){
          $(".labelradio > p").remove();
      }


      $('#ddlClassification').change(function () {
          var classification = $('#ddlClassification option:selected').text();
          var classificationLenght = ar_class.length;
          $("#className").text(classification);
          for(var q = 0; q < classificationLenght; q++){
                if(classification == ar_class[q])
                    $("#tdClass").text(ar_class_desc[q]);
          }
      });




      formArray = [];
      authorArray = [];
      $("#theform").on("submit", function (e) {
          e.preventDefault();

          var formSerialized = $(this).serializeArray();

          $.each(formSerialized, function (i, field) {
              if(field.name == 'txtAuthor[]')
                  authorArray.push('"txtAuthor":[]');

              else
              formArray.push('"'+field.name + '":"' + field.value+'"' )
          });
          formArray.push(authorArray);
          formArray.push('"type":"<?php echo $_GET['type']?>"');

          var authorsName = document.getElementsByName('txtAuthor[]');

          formJSON = JSON.parse("{" + formArray.toString() + "}");

          for(var e = 0; e < authorsName.length; e++) {
              formJSON.txtAuthor[e] = authorsName[e].value;
          }

          $.ajax({
              type: 'post',
              url: 'saveTrainingData.php',
              data: formJSON,
              success: function (result) {
                  console.log(result)
              },
              error: function (error) {
                  console.log(error)
              }
          });
          var trainLocation = function winLocation(type) {
              var trainLoc = "";
              if("<?php echo $priv?>" == 'admin')
                  trainLoc = 'http://localhost/BandoCat/Training/Forms/list.php?col='+ "<?php echo $collection ?>" +'&action=training&type='+ type +'&user=<?php echo $username?>&priv=admin';
              else
                  trainLoc = 'http://localhost/BandoCat/Training/Forms/list.php?col='+ "<?php echo $collection ?>" +'&action=training&type='+ type;
              return trainLoc;
          }

          window.location.replace(trainLocation("<?php echo $type ?>"));
      })


</script>
</body>
<?php include '../../Master/footer.php'; ?>
<style>


    /*Account Stylesheet Adaptation from Collection Name */
    .Account{
        border-radius: 2%;
        box-shadow: 0px 0px 4px;
    }

    .Account_Table{
        background-color: white;
        padding: 3%;
        border-radius: 6%;
        box-shadow: 0px 0px 2px;
        margin: auto;
        font-family: verdana;
        text-align: left;
        margin-top: 2%;
        margin-bottom: 4%;

    }

    .Account_Table .Account_Title{
        margin-top: 2px;
        margin-bottom: 12px;
        color: #008852;
    }

    .Account_Table .Collection_data{
        width: 50%;
    }
    }
    #row{float:bottom;width:2000px;height:52px;background-color: #ccf5ff;}

    .cell
    {
        min-height: 52px;
    }

    .label
    {
        float:left;
        width:initial;
        min-width: 120px;
        padding-top:2px;
        margin-right: 12%;
    }
    .labelradio
    {
        float:left;
        width:150px;
        min-width: 195px;
    }
    mark {
        background-color: rgba(34, 105, 172, 0.32);
        color: black;
        border-radius: 4%;
        box-shadow: 0px 0px 2px;
        margin-left: -7%;
        padding: 2.05%;
    }
    span.labelradio:hover p{
        z-index: 10;
        display: table;
        text-align: initial;
        position: absolute;
        border: 1px solid #000000;
        background: #fefdff;
        font-size: 14px;
        font-style: normal;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px; -o-border-radius: 3px;
        border-radius: 3px;
        -webkit-box-shadow: 4px 4px 4px #175131;
        -moz-box-shadow: 4px 4px 4px #154d2e;
        box-shadow: 4px 4px 4px #175433;
        width: 30%;
        padding: 10px 10px;
    }
    descriptionBox{
        color: #e62014;
    }
#tableClass {
    width: 88%;
    box-shadow: 0px 0px 2px;
    margin: -11% 0% 2% 9%;
    border-radius: 5%;
}
    #selClass {
        width: 50%;
        margin-left: 48%;
    }

</style>
</html>