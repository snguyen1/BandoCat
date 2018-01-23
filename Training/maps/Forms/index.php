<?php
include '../../../Library/SessionManager.php';
require('../../../Library/DBHelper.php');
require '../../../Library/ControlsRender.php';

$Render = new ControlsRender();
$session = new SessionManager();

//User name
$username = $_GET["user"];
//Collection
$collection = $_GET['col'];
//Training type
$type = $_GET['type'];
//User's privilege
$priv = $_GET['priv'];

//Include Training type class
switch ($type) {
    case 'newbie':
        include 'newbieClass.php';
        break;
    case 'answer':
        include 'newbieClass.php';
        break;
    case 'inter':
        include 'interClass.php';
        break;
}

include 'config.php';
//Classification information
include 'main.php';

//Document ID
$doc_id = $_GET["id"];
//Filename
$XMLname = $username . '_' . $type;
$XMLfile = XMLfilename($XMLname);

//Loads file
if($type == 'newbie' || $type == 'inter')
    $file = simplexml_load_file('../../Training_Collections/' . $collection . '/'.$username.'/'. $XMLfile) or die("Cannot open file!");
else
    $file = simplexml_load_file('newbie_Answers.xml');
//Loops through every document tag in the file
foreach ($file->document as $a) {
    //Conditions the document's Id
    if ($a->id == $doc_id) {
        //Future Collections Implementations: $collection -> Collection Name (string)
        if ($a["collection"] == $collection) {
            //Map class
            switch ($type) {
                case 'newbie':
                    $doc1 = new Maps($collection,'../../Training_Collections/' . $collection . '/'.$username.'/'. $XMLfile, $username, $doc_id);
                    break;
                case 'inter':
                    $doc1 = new Maps($collection,'../../Training_Collections/' . $collection . '/'.$username.'/'. $XMLfile, $username, $doc_id);
                    break;
                case 'answer':
                    $doc1 = new Maps($collection, 'newbie_Answers.xml', $username, $doc_id);
                    break;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>[Training] Maps</title>
    <!--Training CSS-->
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <!--Master CSS-->
    <link rel = "stylesheet" type = "text/css" href = "../../../Master/master.css" >
    <!--JQuery UI CSS-->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <!--JQuery Javascript-->
    <script type="text/javascript" src="../../../ExtLibrary/jQuery-2.2.3/jquery-2.2.3.min.js"></script>
    <!--JQuery UI Javascript-->
    <script type="text/javascript" src="../../../ExtLibrary/jQueryUI-1.11.4/jquery-ui.js"></script>
    <!--Master Javascript-->
    <script type="text/javascript" src="../../../Master/master.js"></script>
</head>
<body>
    <div id="wrap">
        <div id="main">
            <div id="divleft">
                <?php include '../../trainingMaster.php' ?>
                </div>
        </div>


        <div id="divright">
            <h2> Input Training Session </h2>
            <div id="divscroller" style="height: 700px">
                <form id="form" name="form" method="post">
                    <table class="Account_Table">
                        <td id="col1">
                            <!-- LIBRARY INDEX -->
                            <div class="cell" id="indexCell">
                                <span class="labelradio" title="Library Index: The library index is the name of a scanned document. Copy and paste the image’s name into the textbox exactly as you see it. Example: <?php echo $doc1->libraryindex; ?>">
                                    <mark class="label">
                                        <span style = "color:red;"> * </span>
                                        Library Index:
                                    </mark>
                                </span>
                                <input type = "text" name = "txtLibraryIndex" id = "libraryindex" size="26" value='<?php echo $doc1->libraryindex; ?>' required />
                            </div>
                            <!-- TITLE -->
                            <div class="cell" id="titleCell">
                                <span class="labelradio" title="Document Title: This can be printed or hand written, but it is typically found across the top of the document. If one cannot be found, enter the library index. Envelopes: An envelope will always be given the title of the library index.">
                                    <mark class="label"><span style = "color:red;"> * </span>Document Title: </mark>
                                </span>
                                <input type = "text" name = "txtTitle" id = "title" size="26" required="true" value='<?php echo $doc1->title; ?>' />
                            </div>
                            <!-- SUBTITLE -->
                            <div class="cell" id="subtitleCell">
                                <span class="labelradio" title="A continuation of the title that contains more detail. Ex: AlbertBrown-1_16 in the Blucher collection- Title: Las Milpas    Subtitle: A Subdivision of northern 208 Acres of Share 2 of the partition of the estate of Nicholas Bluntzer in the Casa Blanca Grant.">
                                    <mark class="label">Subtitle: </mark>
                                </span>
                                <input type = "text" name = "txtSubtitle" id = "subtitle" size="26" value='<?php echo $doc1->subtitle; ?>' />
                            </div>
                            <!-- MAP SCALE -->
                            <div class="cell" id="scaleCell">
                                <span class="labelradio" title="If the map contains a visible map scale select 'Yes'.">
                                    <mark class="label">Map Scale: </mark>
                                </span>
                                <input type = "text" name = "txtScale" id = "scale" size="26" value='<?php echo $doc1->scale; ?>' />
                            </div>


                            <!-- IS MAP -->
                            <div class="cell" id="mapCell">
                                <span class="labelradio" title="If the document is a map of any kind, then select “Yes”. If the paper is blank or includes only a stencil, it is not a map.">
                                <mark>Is Map: </mark>
                                </span>
                                <input type = "radio" name = "rbIs" id = "is" size="26" value="1" <?php if($doc1->is == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbIs" id = "is" size="26" value="0" <?php if($doc1->is == 0) echo "checked"; ?>  />No
                            </div>

                            <!-- NEEDS REVIEW -->
                            <div class="cell" id="reviewCell">
                                <span class="labelradio" title="This is to signal if a review is needed, and always keep selection as yes">
                                    <mark>Needs Review: </mark>
                                </span>
                                <input type = "radio" name = "rbNeedsReview" id = "needsreview" size="26" value="1" <?php if($doc1->needsreview == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbNeedsReview" id = "needsreview" size="26" value="0" <?php if($doc1->needsreview == 0) echo "checked"; ?>  />No
                            </div>

                            <!-- NORTH ARROW -->
                            <div class="cell" id="arrowCell">
                                <span class="labelradio" title="If the document has a north arrow, drawn or stamped, then check “Yes”. If not, check “No”. Note: The north arrow isn’t always obvious, so look carefully.">
                                <mark>North Arrow: </mark>

                                </span>
                                <input type = "radio" name = "rbNortharrow" id = "northarrow" size="26" value="1" <?php if($doc1->northarrow == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbNortharrow" id = "northarrow" size="26" value="0" <?php if($doc1->northarrow == 0) echo "checked"; ?>  />No
                            </div>


                            <!-- STREETS -->
                            <div class="cell" id="streetsCell">
                                <span class="labelradio" title="Check “Yes” if the document contains labeled streets or roads. Check “No”, if there are no streets of if the streets are not labeled.">
                                <mark>Streets: </mark>
                                </span>
                                <input type = "radio" name = "rbStreet" id = "street" size="26" value="1" <?php if($doc1->street == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbStreet" id = "street" size="26" value="0" <?php if($doc1->street == 0) echo "checked"; ?>  />No
                            </div>

                            <!-- POI -->
                            <div class="cell" id="poiCell">
                                <span class="labelradio" title="POI stands for Point of Interest. POIs include any “permanent” object that can help in locating the map on the Earth. These typically include named railroads, named creeks or rivers, lakes, large bodies of water, parks, and cemeteries. *Note: Schools and hospitals do not constitute has POIs, because they can easily be torn down and moved to another location.">
                                <mark>POI: </mark>
                                </span>
                                <input type = "radio" name = "rbPoi" id = "poi" size="26" value="1" <?php if($doc1->poi == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbPoi" id = "poi" size="26" value="0" <?php if($doc1->poi == 0) echo "checked"; ?>  />No
                            </div>

                            <!-- COORDINATES -->
                            <div class="cell" id="coordinatesCell">
                                <span class="labelradio" title="Coordinates are comprised of a latitude and longitude pair normally displayed in degrees, minutes, seconds (ex: Corpus is located at 27o 48’ 02”, 97o 23’ 47”). This will normally only be found on the United States Topographic Quadrangle maps. More commonly, the maps will display bearings, indicating at what angle the surveyor must turn to find the property corner (ex: N 45o 20’ 01” W). If bearings are displayed on the map, then select “No”- the map does not have coordinates.">
                                <mark>Coordinates: </mark>
                                </span>
                                <input type = "radio" name = "rbCoordinates" id = "coordinates" size="26" value="1" <?php if($doc1->coordinates == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbCoordinates" id = "coordinates" size="26" value="0" <?php if($doc1->coordinates == 0) echo "checked"; ?>  />No
                            </div>

                            <!-- COAST -->
                            <div class="cell" id="coastCell">
                                <span class="labelradio" title="If the map contains an area where land touches the edge of a bay, the Gulf coast, or an ocean then select “Yes”. If the land is only touching a lake, pond, creek, or river, then select “No”.">
                                <mark>Coast: </mark>
                                </span>
                                <input type = "radio" name = "rbCoast" id = "coast" size="26" value="1" <?php if($doc1->coast == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbCoast" id = "coast" size="26" value="0" <?php if($doc1->coast == 0) echo "checked"; ?>  />No
                            </div>

                            <!--SCAN OF FRONT-->
                        <div style="text-align: center">
                            <span class="label" style="text-align: center">Scan of Front</span><br>
                            <?php
                            $frontImage = realpath($doc1->frontimage);
                            $backImage = realpath($doc1->backimage);
                            echo "<a id='download_front' href=\"download.php?file=$frontImage\"><br><img src='". $doc1->frontthumbnail . " ' alt = Error /></a>";
                            echo "<br>Size: " . round(filesize($doc1->frontimage)/1024/1024, 2) . " MB";
                            echo "<br><a href=\"download.php?file=$frontImage\">(Click to download)</a>";
                            ?>
                        </div>
                        </td>

                        <!--Second Column-->
                        <td id="col2" style="padding-left:40px">

                            <!-- CUSTOMER NAME -->
                            <div class="cell" id="customerCell">
                                <span class="labelradio" title="This is the name of the person requesting the survey- typically found in the title block or as a hand-written note.">
                                    <mark class="label">Customer Name: </mark>
                                </span>
                                <input type = "text" name = "txtCustomername" id = "customername" size="26" value='<?php echo $doc1->customername; ?>' />
                            </div>


                            <!-- GET START DDL MONTH -->
                            <div class="cell" id="startDateCell">
                                <span class="labelradio" title="Document Start Date: The earliest date on the document- as it pertains to the creation of that document. *If there is one date on the document, only fill out the Document End Date boxes.">
                                    <mark class="label">
                                        Document Start Date:
                                    </mark>
                                </span>
                                <select name="ddlStartMonth" id="startmonth" style="width:60px">
                                    <?php $Render->GET_DDL_MONTH($doc1->startmonth); ?>
                                </select>

                                <!-- GET START DDL DAY -->
                                <select name="ddlStartDay" id="startday" style="width:60px">
                                    <?php $Render->GET_DDL_DAY($doc1->startday); ?>
                                </select>
                                <!-- GET START DDL YEAR -->
                                <select  name="ddlStartYear" id="startyear" style="width:85px">
                                    <?php $Render->GET_DDL_YEAR($doc1->startyear); ?>
                                </select>

                            </div>
                            <!-- GET END DDL MONTH -->
                            <div class="cell" id="endDateCell">
                                <span class="labelradio" title="Document End Date: The latest date on the document- as it pertains to the creation of that document.">
                                    <mark class="label">
                                        Document End Date:
                                    </mark>
                                </span>
                                <select name="ddlEndMonth" id="endmonth" style="width:60px">
                                    <?php $Render->GET_DDL_MONTH($doc1->endmonth); ?>
                                </select>

                                <!-- GET END DDL DAY -->
                                <select name="ddlEndDay" id="endday" style="width:60px">
                                    <?php $Render->GET_DDL_DAY($doc1->endday); ?>
                                </select>
                                <!-- GET END DDL YEAR -->
                                <select name="ddlEndYear" id="endyear" style="width:85px">
                                    <?php $Render->GET_DDL_YEAR($doc1->endyear); ?>
                                </select>
                            </div>

                            <!-- FIELD BOOK NUMBER -->
                            <div class="cell" id="bookNumberCell">
                                <span class="labelradio" title="A reference to a field book is typically written in the title block (accompanied by a field book page). However, it can also be written anywhere on the document with the abbreviation “FB”.">
                                    <mark class="label">Field Book Number: </mark>
                                </span>
                                <input type = "text" name = "txtFieldbooknumber" id = "fieldbooknumber" size="26" value='<?php echo $doc1->fieldbooknumber; ?>' />
                            </div>

                            <!-- FIELD BOOK PAGE -->
                            <div class="cell" id="bookPageCell">
                                <span class="labelradio" title="A reference to the page within the stated field book that related survey information can be found (also found paired with the field book number and typically found in the title block). The common abbreviation is “P” for page.">
                                    <mark class="label">Field Book Page: </mark>
                                </span>
                                <input type = "text" name = "txtFieldbookpage" id = "fieldbookpage" size="26" value='<?php echo $doc1->fieldbookpage; ?>' />
                            </div>

                            <!-- READABILITY -->
                            <div class="cell" id="readabilityCell">
                                <span class="labelradio" title="How easily can this document be read? Are the markings faint and hard to decipher? If yes, select poor. If the drawing is somewhat easy to read select good; and if the document is legible select excellent.">
                                    <mark class="label"><span style = "color:red;"> * </span>Readability:</mark>
                                </span>
                                <select name="ddlReadability" id="readability" style="width: 120px;" required>
                                    <?php $Render->GET_DDL2(array("POOR","GOOD","EXCELLENT"), $doc1->readability); ?>
                                </select>
                            </div>

                            <!-- RECTIFIABILITY -->
                            <div class="cell" id="rectifiabilityCell">
                                <span class="labelradio" title="How easy would it be to take this document and find the specified area today? If it would be very difficult select poor, moderately difficult select good, or easy select excellent. *Note: An easy way to interpret rectifiability is to look at how many yeses were selected for the map features. If between the north arrow and coast, three of the five are selected then rectifiability is good. If there are less than three, rectifiability is poor; and if there are more than three, rectifiability is excellent.">
                                    <mark class="label"><span style = "color:red;"> * </span>
                                        Rectifiability:
                                    </mark>
                                </span>
                                <select name="ddlRectifiability" id="rectifiability" style="width: 120px;" required>
                                    <?php $Render->GET_DDL2(array("POOR","GOOD","EXCELLENT"), $doc1->rectifiability); ?>
                                </select>
                            </div>

                            <!-- COMPANY NAME -->
                            <div class="cell" id="companyCell">
                                <span class="labelradio" title="Input the name of a company if one is recorded in the document.</p>">
                                    <mark class="label">Company Name: </mark>
                                </span>
                                <input type = "text" name = "txtCompanyname" id = "companyname" size="26" value='<?php echo $doc1->companyname; ?>' />
                            </div>

                            <!-- DOCUMENT TYPE -->
                            <div class="cell" id="typeCell">
                                <span class="labelradio" title="Fill out this input box to identify if the document is a plat, map, sketch, stencil, quadrangle, aerial photo, etc… The document type can generally be found in the document’s title (Ex: Plat of… or Map of…), but if type is unclear leave the input box blank.">
                                    <mark class="label">Document Type: </mark>
                                </span>
                                <input type = "text" name = "txtDocumenttype" id = "documenttype" size="26" value='<?php echo $doc1->documenttype; ?>' />
                            </div>

                            <!-- DOCUMENT MEDIUM -->
                            <div class="cell" id="mediumCell">
                                <span class="labelradio" title="Identify what material the document is made of- paper (generally a white or tan color, plus the Photostats- plastic black and white see through sheets), blueprint (paper that has been colored blue- sometimes this is overlaid on cloth and in that case the type becomes cloth), tracing (the paper is thin and the scanner lines can be seen underneath), or cloth (this can be determined by zooming into the image and seeing if there is a woven structure. If there is then the document is cloth, if not then it is paper).">
                                    <mark class="label"><span style = "color:red;"> * </span>Document Medium: </mark>
                                </span>
                                <select name="ddlDocumentmedium" id="documentmedium" style="width: 120px;" required>
                                    <?php
                                        $Render->GET_DDL2(array('Paper','Blueprint','Tracing','Cloth'), $doc1->documentmedium)
                                    ?>
                                </select>
                            </div>

                            <!-- DOCUMENT AUTHOR -->
                            <div class="cell" id="authorCell">
                                <span class="labelradio" title="Identify who created the document, including their title (Ex: County Surveyor, Civil Engineer, Licensed State Surveyor, etc...). This is generally found either in the title block or legal description. Sometimes there are only initials in the bottom right corner, these are also acceptable inputs. *Note: There is only an input box for one author, so if there are two authors separate their names with a coma. If there are more than two, only identify the one that signed the document.">
                                    <mark class="label">Document Author:</mark>
                                </span>
                                <input type="text" id="author" class="author" name="txtAuthor" size="20" list="lstAuthor" value="<?php echo $doc1->author?>"/>
                            </div>

                            <!-- THUMBNAIL LINKS -->
                            <div class="cell" id="">
                                <!--SCAN OF BACK-->
                                <div style="text-align: center">
                                            <?php
                                            if($doc1->backimage != '../Images/Intermediate/Documents/' && $doc1->backimage != '../Images/Newbie/Documents/'){ //has Back Scan
                                                echo '<span class="label" style="text-align: center">Scan of Back</span><br>';
                                                echo "<a id='download_front' href=\"download.php?file=$backImage\"><br><img src='". $doc1->backthumbnail . " ' alt = Error /></a>";
                                                echo "<br>Size: " . round(filesize($doc1->backimage) / 1024 / 1024, 2) . " MB";
                                                echo "<br><a href=\"download.php?file=$backImage\">(Click to download)</a>";
                                            }

                                            else
                                                echo '<span class="label" style="text-align: center">No Scan of Back</span><br>';

                                            ?>
                                </div>
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
                                        <?php if($session->hasWritePermission() && $type != 'answer'){
                                            echo "<input type='submit' id='btnSubmit' name='submit' value='Update' action='index.php' class='bluebtn'/>";
                                        }
                                        ?>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</body>


<?php
$data = file_get_contents('php://input')
?>


<script>
    //Window Height
    var windowHeight = window.innerHeight;
    $('#divscroller').height(windowHeight - (windowHeight * 0.1));

    $(window).resize(function (event) {
        windowHeight = event.target.innerHeight;
        $('#divscroller').height(windowHeight - (windowHeight * 0.1));
    });


    var formJSON = {};
    var answersJSON = '';
    $(document).ready(function () {
        if('<?php echo $type?>' == 'newbie')
        {
            //object to request data for the newbie_Answers.xml
            var xhttp_answers = new XMLHttpRequest();

            //Loads XML
            xhttp_answers.onreadystatechange = function () {
                if(this.readyState == 4 && this.status == 200) {
                    //XML object
                    var xmlAnswers = this.responseXML;
                    answersJSON = xmlToJson(xmlAnswers);
                    //JSON document{[documents array[fields]]}
                    ansDataJSON = answersJSON.data;
                    table2JSON();
                }
            };
            xhttp_answers.open("GET", "newbie_Answers.xml?p="+String(Math.random()));
            xhttp_answers.send();
        }

        $(':input').change(function (event) {
            table2JSON();
            var targetID = event.currentTarget.id;
            //targetID parsed into a JSON object to be used as a property variable to retrieve answer value
            var IDProperty = JSON.parse(JSON.stringify(targetID));
            var targetValue = event.target.value;
            //valid document ID
            var docID = formJSON.document;
            var answerValue = ansDataJSON.document[docID][IDProperty]['#text'];
            if(jQuery.isEmptyObject(ansDataJSON.document[docID][IDProperty])) {
                answerValue = ''
                switch (targetID){
                    case 'startday':
                        if(answerValue == '')
                            answerValue = '00';
                        break;
                    case 'startmonth':
                        if(answerValue == '')
                            answerValue = '00';
                        break;
                    case 'startyear':
                        if(answerValue == '')
                            answerValue = '0000';
                        break;
                    case 'endday':
                        if(answerValue == '')
                            answerValue = '00';
                        break;
                    case 'endmonth':
                        if(answerValue == '')
                            answerValue = '00';
                        break;
                    case 'endyear':
                        if(answerValue == '')
                            answerValue = '0000';
                        break;
                }
            }

            if (answerValue.toLowerCase() == targetValue.toLowerCase()) {
                //Gets the index input element from the formJSON object to remove the answer declaration icon by id
                for(target = 0; target < formJSON.data.length; target++) {
                    if(formJSON.data[target].id == targetID) {
                        var targetIndex = target
                    }
                }
                $("span[name = aDeclerin"+ targetIndex +"]").remove();
                $("#" + String(targetID)).removeAttr('style').css('-webkit-animation', 'correctFade 2s linear');
            }

            else{
                $("#" + String(targetID)).css('outline', 'red').css('outline-style', 'solid');
            }

        });

        /**********************************************
         *Function: xmlToJSON
         *Description: Changes XML to JSON
         * Parameter(string): XML object
         * Return value(string): JSON object
         ***********************************************/
        function xmlToJson(xml) {
            // Create the return object
            var obj = {};

            if (xml.nodeType == 1) { // element
                // do attributes
                if (xml.attributes.length > 0) {
                    obj["@attributes"] = {};
                    for (var j = 0; j < xml.attributes.length; j++) {
                        var attribute = xml.attributes.item(j);
                        obj["@attributes"][attribute.nodeName] = attribute.nodeValue;
                    }
                }
            } else if (xml.nodeType == 3) { // text
                obj = xml.nodeValue;
            }

            // do children
            if (xml.hasChildNodes()) {
                for(var i = 0; i < xml.childNodes.length; i++) {
                    var item = xml.childNodes.item(i);
                    var nodeName = item.nodeName;
                    if (typeof(obj[nodeName]) == "undefined") {
                        obj[nodeName] = xmlToJson(item);
                    } else {
                        if (typeof(obj[nodeName].push) == "undefined") {
                            var old = obj[nodeName];
                            obj[nodeName] = [];
                            obj[nodeName].push(old);
                        }
                        obj[nodeName].push(xmlToJson(item));
                    }
                }
            }
            return obj;
        };

        //Disables the labels' description marks
        if("<?php echo $type?>" == "inter"){
            $(".labelradio > p").remove();
        }
        //End of document ready
    });

    /**********************************************
     * Function: table2JSON
     * Description: Converts the table's columns input form fields and values into a structured JSON object
     * Parameter(string): None
     * Return value(string): None
     ***********************************************/
    function table2JSON() {
        var accountTable = $(".Account_Table").children();
        //Left column rows
        var accountInputsCol1 = accountTable[0].rows[0].cells.col1.children;
        //Right column rows
        var accountInputsCol2 = accountTable[0].rows[0].cells.col2.children;

        //Stores teh document id into a JSON property value
        formJSON["document"]= '<?php echo $doc_id?>';
        //Creates an empty property array
        formJSON["data"] = [];

        /****** LEFT COLUMN ******/
        //For every element in the Left column

        $.each(accountInputsCol1, function (index, element) {
            if (element.id !== "") {
                var inputDivs = $("#" + element.id + ":has(input)")[0];
                if(inputDivs !== undefined) {
                    var inputId = $("#" + inputDivs.id + " > input")[0].id;
                    var inputVal = $("#" + inputDivs.id + " > input")[0].value;
                    if($("#"+inputId).is(":radio"))
                        structureJSON(formJSON, inputId,$("#" + inputId + ":checked").val());
                    else
                        structureJSON(formJSON, inputId, inputVal);
                }

            }
        });

        /****** RIGHT COLUMN ******/
        //For every element in the Right column
        $.each(accountInputsCol2, function (index, element) {
            if (element.id !== "") {
                var inputDivs = $("#" + element.id + ":has(input)")[0];
                var selectDivs = $("#" + element.id + ":has(select)")[0];
                var selectList = $("#" + element.id + "> select");

                if(inputDivs !== undefined){
                    var inputId = $("#" + inputDivs.id + " > :input")[0].id;
                    var inputVal = $("#" + inputDivs.id + " > :input")[0].value;
                    structureJSON(formJSON, inputId, inputVal);
                }
                //Detects the select elements and loops through the three day input drop downs to retrieve their
                //elements ids and values.
                else if(selectDivs !== undefined){
                    for(var s = 0; s < selectList.length; s++) {
                        var selectId = selectList[s].id;
                        var selectVal = selectList[s].value;
                        structureJSON(formJSON, selectId, selectVal)
                    }
                }
            }
        });
    }

    /**********************************************
     *Function: structureJSON
     *Description: Creates a property structure of ids and values for a JSON object
     * Parameter(string): json (object) JSON object to which the properties will be stored
     * elemID (string) Input element id of the field
     * value (string) Value of the Element id input
     * Return value(string): None
     ***********************************************/
    function structureJSON(json, elemID, value) {
        json["data"].push({ "id":elemID, "value":value});
    }

    /**********************************************
     *Function: winLocation
     *Description: Function triggered when the page is submitted to compare answer values with user input values.
     * Parameter(string): id (string) the input element id value
     *                      value (string) the input element value
     * Return value(string): e (bool) Returns e if any of the elements input and answer values is different.
     ***********************************************/
    function dataComparison(id, value) {
        var comparisonArray = [];
        //For each property of the JSON the its id and value properties are being looped
        $.each(ansDataJSON.document[formJSON.document],function (ansID, ansVal) {
            //if the id(input id) and ansID(answer id), which is a JSON property type, are the same the JSON property
            //is converted into a string
            if(id == ansID) {
                var idProperty = JSON.parse(JSON.stringify(ansID));
                //if the JSON property contains an empty object an empty string value is given to the property, thus to
                //compare it with an empty user input.
                if(jQuery.isEmptyObject(ansDataJSON.document[formJSON.document][idProperty])){
                    ansDataJSON.document[formJSON.document][idProperty]['#text'] = ''
                }
                //If the JSON property contains an empty object but it is a date element a proper value is given to its
                //property
                switch (id){
                    case 'startday':
                        if(value == '00')
                        value = '';
                        break;
                    case 'startmonth':
                        if(value == '00')
                        value = '';
                        break;
                    case 'startyear':
                        if(value == '0000')
                        value = '';
                        break;
                    case 'endday':
                        if(value == '00')
                        value = '';
                        break;
                    case 'endmonth':
                        if(value == '00')
                        value = '';
                        break;
                    case 'endyear':
                        if(value == '0000')
                        value = '';
                        break;
                }

                //User and answer values are compared
                if(value.toLowerCase() == ansVal['#text'].toLowerCase()){
                    //Returns false for errors
                    e = false;
                    comparisonArray.push([e, id, ansVal['#text']])
                }
                else if(ansID == 'startday' || ansID == 'startmonth' || ansID == 'startyear'){
                    if (id.toLowerCase() == ansVal['#text'].toLowerCase()) {
                        e = false;
                        comparisonArray.push([e, id, ansVal['#text']]);
                    }
                    else {
                        //True for errors
                        e = true;
                        var DocAnswers = ansDataJSON.document[formJSON.document];
                        var day = DocAnswers['startday']['#text'];
                        var month = DocAnswers['startmonth']['#text'];
                        var year = DocAnswers['startyear']['#text'];
                        var date = month + '/' + day + '/' + year;
                        comparisonArray.push([e, id, date]);
                    }
                }
                else if(ansID == 'endday' || ansID == 'endmonth' || ansID == 'endyear'){
                    if (id.toLowerCase() == ansVal['#text'].toLowerCase()) {
                        e = false;
                        comparisonArray.push([e, id, ansVal['#text']]);
                    }
                    else {
                        //True for errors
                        e = true;
                        var DocAnswers = ansDataJSON.document[formJSON.document];
                        var day = DocAnswers['endday']['#text'];
                        var month = DocAnswers['endmonth']['#text'];
                        var year = DocAnswers['endyear']['#text'];
                        var date = month + '/' + day + '/' + year;
                        comparisonArray.push([e, id, date]);
                    }
                }
                else{
                    //Returns true for errors
                    e = true;
                    comparisonArray.push([e, id, ansVal['#text']]);
                }
            }
        });
        return comparisonArray
    }

    //Input form array
      formArray = [];
    //No errors while submiting
        var submitErrors = 0;
        var errorsCorrection = 0;
      //Submit function that will convert the input form into a JSON
      $("#form").on("submit", function (e) {
          if(errorsCorrection > 0){
              submitErrors = 0;
              $("span[name = 'aDeclerin']").remove();
          }
          e.preventDefault();
          table2JSON();
          //Default no error values
          if('<?php echo $type ?>' == 'newbie'){
              error = false;
              formErrors = [];

              for(var d = 0; d < formJSON.data.length; d++){
                  //User input id
                  var formJSONID = formJSON.data[d].id;
                  //User input value
                  var formJSONValue = formJSON.data[d].value;
                  //Compares User and Answer values
                  error = dataComparison(formJSONID, formJSONValue);
                  formErrors.push(error);

                  //If error, the user and answer values are different on submit the submission is stopped an the input
                  //element's outline is highlighted with a orange color
                  $.each(formErrors[d], function (index, data) {
                      if(data[0]){
                          submitErrors = 1;
                          if(data[1] !== "crewmember"){
                              $("#" + data[1]).css('outline', 'orange').css('outline', 'orange').css('outline-style', 'solid');
                              var parentDeclerin = $("#" + String(formJSONID)).parent()[0].id;
                              var correctValue = data[2];
                              $('<span class="labelradio" name="aDeclerin'+ d +'" style="width: 10px;margin: -11% 0% 0% 90%; min-width:10%" ><img src="../../images/pin_question.png" style="width: 50%; position: relative;"></span>').insertAfter("#" + parentDeclerin).prop('title', correctValue);

                          }
                          else {
                              $("." + data[1] + index).css('outline', 'orange').css('outline', 'orange').css('outline-style', 'solid');
                              var parentDeclerin = $("." + data[1] + index);
                              var correctValue = data[2];
                              $('<span class="labelradio" name="aDeclerin'+ d +"-"+ index + '" style="width: 10px;margin: -4.5% 0% 0% 90%; min-width:10%" ><img src="../../images/pin_question.png" style="width: 50%; position: relative;"></span>').insertAfter(parentDeclerin).prop('title', correctValue);

                          }
                      }
                  });
              }
              if(submitErrors == 1) {
                  alert('There is an error');
                  errorsCorrection += 1;
                  return
              }
          }


          //Creates an array of objects by form values
          var formSerialized = $(this).serializeArray();

          /*JQuery that iterates through the serialized array to create a JSON object that will be posted to save the
          training input data*/
          $.each(formSerialized, function (i, field) {
              //Obtains the name and value of each input and stores it into the Input form array in a JSON format
              formArray.push('"'+field.name + '":"' + field.value+'"' )
          });
          //Training type attribute is pushed to the Input Form Array
          formArray.push('"type":"<?php echo $_GET['type']?>"');
          formArray.push('"col":"<?php echo $collection;?>"');

          //Input Form is parsed into a JSON
          formJSON = JSON.parse("{" + formArray.toString() + "}");

          $.ajax({
              type: 'post',
              url: 'saveTrainingData.php',
              data: formJSON,
              success: function () {
                  alert('Success')
              },
              error: function (error) {
                  alert(error)
              }
          });

          /**********************************************
           *Function: winLocation
           *Description: Declares the location on which the window will be replaced when the Submission is completed
           * Parameter(string): Training Type
           * Return value(string): URL that will replace the window
           ***********************************************/
          var trainLocation = function winLocation(type) {
              var trainLoc = "";
              if("<?php echo $priv?>" == 'admin')
                  trainLoc = 'list.php?col=' + "<?php echo $collection ?>" + '&action=training&type='+ type +'&user=<?php echo $username?>&priv=admin';
              else
                  trainLoc = 'list.php?col=' + "<?php echo $collection ?>" + '&action=training&type='+ type;
              return trainLoc;
          };

          window.location.replace(trainLocation("<?php echo $type ?>"));
      })
</script>

</body>
<?php include '../../../Master/footer.php'; ?>
</html>