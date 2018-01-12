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
                    $doc1 = new Fiedlbook($collection,'../../Training_Collections/' . $collection . '/'.$username.'/'. $XMLfile, $username, $doc_id);
                    break;
                case 'inter':
                    $doc1 = new Fiedlbook($collection,'../../Training_Collections/' . $collection . '/'.$username.'/'. $XMLfile, $username, $doc_id);
                    break;
                case 'answer':
                    $doc1 = new Fiedlbook($collection, 'newbie_Answers.xml', $username, $doc_id);
                    break;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
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
                                <span class="labelradio" title="This field is automatically created by the file name; each value is unique and does not need to be changed.">
                                    <mark class="label">
                                        <span style = "color:red;"> * </span>
                                        Library Index:
                                    </mark>
                                </span>
                                <input type = "text" name = "txtLibraryIndex" id = "libraryindex" size="26" value='<?php echo $doc1->libraryindex; ?>' required />
                            </div>
                            <!-- COLLECTION -->
                            <div class="cell" id="collectionCell">
                                <span class="labelradio" title="This should always be entered as “Blucher”, unless told otherwise"><mark class="label"><span style = "color:red;"> * </span>Collection: </mark></span>
                                <input type = "text" name = "txtBookcollection" id = "bookcollection" size="26" required="true" value='<?php echo $doc1->bookcollection; ?>' />
                            </div>
                            <!-- BOOKTITLE -->
                            <div class="cell" id="booktitleCell">
                                <span class="labelradio" title="This field is automatically created by the file name, this value should not be changed.">
                                    <mark class="label">Book Title: </mark></span>
                                <input type = "text" name = "txtBooktitle" id = "booktitle" size="26" value='<?php echo $doc1->booktitle; ?>' />
                            </div>
                            <!-- JOB NUMBER -->
                            <div class="cell" id="jobnumberCell">
                                <span class="labelradio" title="This value can usually be seen on the first page for a specific job in the field book. This number will usually be in the top right corner following the letter “J”, and can usually be found near the job title. Most jobs should have these, however it is not rare for a job number to be missing. An example would be “J-4237”. Only include the numbered value, not the “J”. Some jobs may contain more than one job number, include them all separated by commas.">
                                    <mark class="label">Job Number: </mark></span>
                                <input type = "text" name = "txtJobnumber" id = "jobnumber" size="26" value='<?php echo $doc1->jobnumber; ?>' />
                            </div>

                            <!-- JOB TTITLE -->
                            <div class="cell" id="jobtitleCell">
                                <span class="labelradio" title="This is the main header at the top of the page for each job listed in the field book. Each job title should be listed as well in the index. Although they can occasionally be lengthy, include the full job title; the more detail the better.">
                                    <mark class="label">Job Title: </mark></span>
                                <input type = "text" name = "txtJobtitle" id = "jobtitle" size="26" value='<?php echo $doc1->jobtitle; ?>' />
                            </div>

                            <!-- INDEXED PAGE -->
                            <div class="cell" id="indexedpageCell">
                                <span class="labelradio" title="This is the page number that is written in the top corner of the page. Odd numbers are usually not written out in the field book, however it is implied that these pages are still numbered. Pages on the left side are generally numbered evenly, and pages on the right side are odd.">
                                    <mark class="label">Indexed Page: </mark></span>
                                <input type = "text" name = "txtIndexedpage" id = "indexedpage" size="26" value='<?php echo $doc1->indexedpage; ?>' />
                            </div>


                            <!-- BLANK PAGE -->
                            <div class="cell" id="blankpageCell">
                                <span class="labelradio" title="If the page is COMPLETELY (except for the page number) blank, then it is a blank page. If there is any writing on the page (except for the page number), it is not blank.">
                                <mark>Blank Page: </mark>
                                </span>
                                <input type = "radio" name = "rbBlankpage" id = "blankpage" size="26" value="1" <?php if($doc1->blankpage == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbBlankpage" id = "blankpage" size="26" value="0" <?php if($doc1->blankpage == 0) echo "checked"; ?>  />No
                            </div>

                            <!-- SKETCH -->
                            <div class="cell" id="sketchCell">
                                <span class="labelradio" title="If there is a drawing or a map present on the page, then it is considered a sketch. In some cases, the surveyor may draw an angle or lines which may not represent a sketch. Use your best judgment to determine if it is a sketch of the jobsite or something else.">
                                <mark>Sketch: </mark>
                                </span>
                                <input type = "radio" name = "rbSketch" id = "sketch" size="26" value="1" <?php if($doc1->sketch == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbSketch" id = "sketch" size="26" value="0" <?php if($doc1->sketch == 0) echo "checked"; ?>  />No
                            </div>

                            <!-- LOOSE DOCUMENT -->
                            <div class="cell" id="loosedocumentCell">
                                <span class="labelradio" title="Indicate this page as a loose document if there is any file or document that is loose/stapled/glued to the pages. A loose document is not part of the original field book. They can often be found in between the pages, examples include receipts, attached drawings, invoices, etc.">
                                <mark>Loose Document: </mark>
                                </span>
                                <input type = "radio" name = "rbLoosedocument" id = "loosedocument" size="26" value="1" <?php if($doc1->loosedocument == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbLoosedocument" id = "loosedocument" size="26" value="0" <?php if($doc1->loosedocument == 0) echo "checked"; ?>  />No
                            </div>


                            <!-- NEEDS REVIEW -->
                            <div class="cell" id="needsreviewCell">
                                <span class="labelradio" title="Don’t change this, it should remain marked as “yes”.">
                                <mark>Needs Review: </mark>
                                </span>
                                <input type = "radio" name = "rbNeedsreview" id = "needsreview" size="26" value="1" <?php if($doc1->needsreview == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbNeedsreview" id = "needsreview" size="26" value="0" <?php if($doc1->needsreview == 0) echo "checked"; ?>  />No
                            </div>

                            <!-- FIELD BOOK AUTHOR -->
                            <div class="cell" id="authorCell" title="This is a field that is very rarely used. Older field books had a field book author indicated towards the front of the book. Do not enter any names in this field unless the book specifically states there is a field book author.">
                                <span class="labelradio"><mark class="label">Field Book Author: </mark></span>
                                <input type = "text" name = "txtAuthor" id = "author" size="26" value='<?php echo $doc1->author; ?>' />
                            </div>

                            <!-- FIELD CREW MEMBER: -->
                            <div class="cell" id="crewCell">
                                <div class="crewMemberClass" id="crewMemberId0" style="width: 115%">
                                    <span class="labelradio" title="The names for the field crew members will almost always be found on the odd numbered pages in the top left corner. List each and every field crew member on each page for that specific job. If their names are abbreviated, an index of field crew members can almost always be found at the very beginning of the field book. Field crew members can change throughout the job, enter each field crew member on every page. The maximum amount of field crew members that can be entered for the training is five, however the average is usually around four. For example, if a job is twenty pages and you see John Carter on only one page and he is absent from the rest, his name must be included on every page for the field crew members.">
                                        <mark class="label">Field Book Crew: </mark>
                                    </span>
                                        <input type = "text" name = "txtCrewmember" id = "crewmember" class="crewmember0" size="26" value='<?php echo $doc1->crewmember->name[0];?>' />
                                        <input type="button" id="more_fields" onclick="add_fields($('.crewMemberClass').length, null);" value="+"/>
                                        <input type="button" id="less_fields" onclick="remove_fields($('.crewMemberClass').length)" value="-">
                                </div>
                                <?php $lenCrewmembers = count($doc1->crewmember->name);
                                for ($d = 1; $d < $lenCrewmembers; $d++){
                                    echo '<div class="crewMemberClass" id="crewMemberId'.$d.'" style="width: 115%; margin-top: 2%"><span class="label" style="margin:0% 14% 0% -2%">Field Book Crew: </span> <input type = "text" name = "txtCrewmember" id = "crewmember" class="crewmember'.$d.'" size="26" value="'.$doc1->crewmember->name[$d].'" /> </div>';
                                }
                                ?>

                            </div>
                        </td>

                        <!--Second Column-->
                        <td id="col2" style="padding-left:40px">

                            <!-- GET START DDL MONTH -->
                            <div class="cell" id="startDateCell">
                                <span class="labelradio" title="The dates for jobs can almost always be found to the right of the field crew members on the odd numbered pages. Put to the earliest date for the job in the start date, and the last date you find as the end date. If only one date is listed, enter the date as the end date and leave the start date fields empty. Theses dates should be on every page for the specific job.">
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
                                <span class="labelradio" title="The dates for jobs can almost always be found to the right of the field crew members on the odd numbered pages. Put to the earliest date for the job in the start date, and the last date you find as the end date. If only one date is listed, enter the date as the end date and leave the start date fields empty. Theses dates should be on every page for the specific job.">
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

                            <!-- COMMENTS -->
                            <div class="cell" id="commentsCell">
                                <span class="labelradio" title="There are a few things you will often want to include in the comments. These things include: 1. The client for the job. After the job title, there is usually a following line that says “For John Doe”, include this line in the comments.               2. Include all field books, pages, and maps that are referenced on the job title page. Often you will see something such as “B 309 P 42”, or “map 4R-87” on this page. Include these values in the comments, as this job may share similarities to another in a different field book or map. 3. The front cover, indices, and back cover should simply be indicated as so in the comments. Just insert “Front cover”, “Index”, and “Back cover” in the comments when needed. Other Notes: Towards the end of field books, pages may no longer be numbered. In this case do not enter a value for the indexed page as there is none. There will also probably be a section of mathematical tables, charts, and graphs near the end of the field book. There is no need to include any of this information in the comments, or change anything on the catalog page. Simply change the Collection to “Blucher” and hit “Update”.">
                                    <mark class="label">Comments: </mark></span>
                                <textarea cols="25" name = "txtComments" id = "comments" /><?php echo $doc1->comments; ?></textarea>
                            </div>

                            <!--FIELD BOOK PAGE SCAN-->
                            <div style="text-align: center">
                                <span class="label" style="text-align: center">Scan of Page</span><br>
                                <?php
                                $frontImage = realpath($doc1->frontimage);
                                $backImage = realpath($doc1->backimage);
                                echo "<a id='download_front' href=\"download.php?file=$frontImage\"><br><img src='". $doc1->frontthumbnail . " ' alt = Error /></a>";
                                echo "<br>Size: " . round(filesize($doc1->frontimage)/1024/1024, 2) . " MB";
                                echo "<br><a href=\"download.php?file=$frontImage\">(Click to download)</a>";
                                ?>
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
            xhttp_answers.open("GET", "newbie_Answers.xml");
            xhttp_answers.send();
        }

        $('form').on('change', ['input', 'textarea'], function (event) {
            //On change the table data is stored to the formJSON object
            table2JSON();
            //Document ID
            var docID = formJSON.document;
            //Target element ID
            var targetID = event.originalEvent.target.id;
            //Target element value
            var targetValue = event.target.value;
            //Taget element class
            var targetClass = event.originalEvent.target.className;
            //Target element ID converted into a json object to be used as an object property
            var IDProperty = JSON.parse(JSON.stringify(targetID));
            //Answer JSON element
            var answerElement = ansDataJSON.document[docID][IDProperty];


            if(targetID !== 'crewmember'){
                //Answer element value
                var answerValue = ansDataJSON.document[docID][IDProperty]['#text'];
                //Removes wrong decleration answer style
                if(jQuery.isEmptyObject(answerElement))
                    answerValue = '';
                if (answerValue.toLowerCase() == targetValue.toLowerCase()) {
                    var targetAttribute = event.originalEvent.srcElement.parentNode.nextSibling.attributes[1].nodeValue;
                    $("span[name = "+ targetAttribute +"]").remove();
                    $("#" + String(targetID)).removeAttr('style').css('-webkit-animation', 'correctFade 2s linear');
                    return
                }
                //Includes correct declaration style
                else
                    $("#" + String(targetID)).css('outline', 'red').css('outline-style', 'solid');
            }

            else{
                //If the Answer JSON element has a property called name a crewJSON object is initiated
                var nameFlagComp = answerElement.hasOwnProperty('name');
                if(nameFlagComp){
                    if(jQuery.isEmptyObject(answerElement.name)){
                        answerValue = '';
                    }
                    else {
                        targetValue = $("." + targetClass)[0].value;
                        var crewIndex = parseInt(targetClass.match(/\d+/), 10);
                        answerValue = ansDataJSON.document[docID]['crewmember']['name'][crewIndex]['#text'];
                    }
                    if (answerValue.toLowerCase() == targetValue.toLowerCase()) {
                        //Removes wrong decleration answer style
                        if(event.originalEvent.srcElement.nextSibling.attributes !== undefined) {
                            var targetAttribute = event.originalEvent.target.nextSibling.attributes[1].nodeValue;
                            $("span[name = "+ targetAttribute +"]").remove();
                        }
                        $("." + String(targetClass)).removeAttr('style').css('-webkit-animation', 'correctFade 2s linear');
                    }
                    //Includes correct declaration style
                    else {
                        $("." + String(targetClass)).css('outline', 'red').css('outline-style', 'solid');
                    }
                }
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
        //Field crew members' names array
        var crewTableArray = [];

        /****** LEFT COLUMN ******/
        //For every element in the Left column
        $.each(accountInputsCol1, function (index, element) {
            if(element.id !== "") {
                var inputDivs = $("#" + element.id + ":has(input)")[0];
                if(inputDivs !== undefined && element.id !== "crewCell") {
                    var inputId = $("#" + inputDivs.id + " > input")[0].id;
                    var inputVal = $("#" + inputDivs.id + " > input")[0].value;
                        if($("#"+inputId).is(':radio'))
                            structureJSON(formJSON, inputId,$("#" + inputId + ":checked").val());
                        //Otherwise if not a radio nor a field crew element the input value is stored into the formJSON object
                        else
                            structureJSON(formJSON, inputId,inputVal);
                }
                else if(element.id == "crewCell") {
                    for(var j = 0; j < element.children.length;j++){
                        //If a field crew input is not undefined its value is stored into an array that is then posted as
                        //into the formJSON object
                        if(typeof element.children[j].children['crewmember'] !== "undefined") {
                            crewTableArray.push(element.children[j].children['crewmember'].value)
                        }
                    }
                    structureJSON(formJSON, "crewmember", crewTableArray)
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
     * Function: add_fields
     * Description: adds more fields for authors
     * Parameter(s): length (integer) Length of Author's cells
     * val (String ) - name of the author
     * Return value(s): None
     ***********************************************/
    var max = 5;
    var crew_count = 0;

    function add_fields(length, val) {
        if (val == null)
            val = "";
        if (crew_count >= max)
            return false;
        $('#crewMemberId' + (length - 1)).after('' +
            '<div class="crewMemberClass" id="crewMemberId' + length + '" style="margin-top: 2%">' +
            '<span class="label" style="margin: 0% 16% 0% -2%">Field Book Crew: </span>' +
            '<input type = "text" name = "txtCrewmember" id = "crewmember" class="crewmember'+length+'" size="26" value="' + val + '" />' +
            '</div>');
        crew_count++;
    }

    /**********************************************
     *Function: remove_fields
     *Description: removes fields from the Document Author field
     * Parameter(s): length (integer) Length of Author's cells
     * Return value(s): None
     ***********************************************/
    function remove_fields(length) {
        //This will prevent for the function to delete all the authors' cells
        if (length < 2)
            return false;
        //Removes the las childrend of the authorsCell class
        $('.crewMemberClass').last().remove();
        crew_count--;
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
        //For each property of the JSON its id and value properties are being looped
        $.each(ansDataJSON.document[formJSON.document],function (ansID, ansVal) {
            //if the id(input id) and ansID(answer id), which is a JSON property type, are the same the JSON property
            //is converted into a string
            if(id == ansID) {
                var idProperty = JSON.parse(JSON.stringify(ansID));
                //if the JSON property contains an empty object an empty string value is given to the property, thus to
                //compare it with an empty user input.

                if(jQuery.isEmptyObject(ansDataJSON.document[formJSON.document][idProperty]))
                    ansVal = '';
                else{
                    ansVal = ansVal['#text'];
                }


                if(id !== 'crewmember'){
                    //User's values and answer values are compared
                    if(value.toLowerCase() == ansVal.toLowerCase()){
                        //Returns false for errors
                        e = false;
                        comparisonArray.push([e, id, ansVal])
                    }
                    else if(ansID == 'startday' || ansID == 'startmonth' || ansID == 'startyear'){
                        if (value.toLowerCase() == ansVal.toLowerCase()) {
                            e = false;
                            comparisonArray.push([e, id, ansVal]);
                        }
                        else {
                            //True for errors
                            e = true;
                            var DocAnswers = ansDataJSON.document[formJSON.document];
                            var day = DocAnswers['startday']['#text'];
                            var month = DocAnswers['startmonth']['#text'];
                            var year = DocAnswers['startyear']['#text'];
                            if(day == '00' || month == '00' || year == '0000'){
                                day = 'day';
                                month = 'month';
                                year = 'year'
                            }
                            var date = month + '/' + day + '/' + year;
                            comparisonArray.push([e, id, date]);
                        }
                    }
                    else if(ansID == 'endday' || ansID == 'endmonth' || ansID == 'endyear'){
                        if (value.toLowerCase() == ansVal.toLowerCase()) {
                            e = false;
                            comparisonArray.push([e, id, ansVal]);
                        }
                        else {
                            //True for errors
                            e = true;
                            var DocAnswers = ansDataJSON.document[formJSON.document];
                            var day = DocAnswers['endday']['#text'];
                            var month = DocAnswers['endmonth']['#text'];
                            var year = DocAnswers['endyear']['#text'];
                            if(day == '00' || month == '00' || year == '0000'){
                                day = 'day';
                                month = 'month';
                                year = 'year'
                            }
                            var date = month + '/' + day + '/' + year;

                            comparisonArray.push([e, id, date]);
                        }
                    }
                    else{
                        //Returns true for errors
                        e = true;
                        if(ansVal == '')
                            ansVal = 'No information required';
                        comparisonArray.push([e, id, ansVal]);
                    }
                }



               else{
                    for(var v = 0; v < value.length; v++) {
                        //Crew members'names array
                         ansVal = ansDataJSON.document[formJSON.document][idProperty];

                        if(value.length == ansVal['name'].length){
                            //Validates the equality of answer value and input value
                            if(value[v].toLowerCase() == ansVal['name'][v]['#text'].toLowerCase()){
                                //Returns false for errors
                                e = false;
                                comparisonArray.push([e, id, ansVal['name'][v]['#text']])
                            }
                            else {
                                //Returns true for errors
                                e = true;
                                comparisonArray.push([e, id, ansVal['name'][v]['#text']]);
                            }
                        }
                        //Error if uneven amount of answer values and input values
                        else{
                            if(jQuery.isEmptyObject(ansVal['name'])){
                                ansVal = '';
                                if(value[v].toLowerCase() == ansVal.toLowerCase()){
                                    //Returns false for errors
                                    e = false;
                                    comparisonArray.push([e, id, ansVal])
                                }
                                else {
                                    //Returns true for errors
                                    e = true;
                                    comparisonArray.push([e, id, "No field crew member"]);
                                }
                            }
                            else{
                                //Returns true for errors
                                e = true;
                                comparisonArray.push([e, id, ansVal['name']['#text']]);
                            }
                        }
                    }
                }
            }
        });
        return comparisonArray;
    }

    //Input form array
    formArray = [];
    //Crew members array
    crewArray = [];
    //No errors wil submitting
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
              //Stores the errors from dataComparison function
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
                          //Non crewmembers answer declaration
                          if(data[1] !== "crewmember"){
                              $("#" + data[1]).css('outline', 'orange').css('outline', 'orange').css('outline-style', 'solid');
                              var parentDeclerin = $("#" + String(formJSONID)).parent()[0].id;
                              var correctValue = data[2];
                              $('<span class="labelradio" name="aDeclerin'+ d + '" style="width: 10px;margin: -11% 0% 0% 90%; min-width:10%" ><img src="../../images/pin_question.png" style="width: 50%; position: relative;"></span>').insertAfter("#" + parentDeclerin).prop('title', correctValue);
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
          formArray = [];

          /*JQuery that iterates through the serialized array to create a JSON object that will be posted to save the
          training input data*/
          $.each(formSerialized, function (i, field) {
              var rgexspecialChar = /["']/g;
              var flag = rgexspecialChar.test(field.value);
              if(flag) {
                  var idxSpecialChar = rgexspecialChar.exec(field.value);
              }
              if(field.name == 'txtCrewmember'){
                  crewArray.push(field.value);
              }
              else if(field.name == 'ddlStartMonth'){
                  formArray.push('"txtCrewmember":[]');
                  formArray.push('"'+field.name + '":"' + field.value+'"' )
              }
              //Obtains the name and value of each input and stores it into the Input form array in a JSON format
              else
                  formArray.push('"'+field.name + '":"' + field.value+'"' )

          });
          //Training type attribute is pushed to the Input Form Array
          formArray.push('"type":"<?php echo $_GET['type']?>"');
          formArray.push('"col":"<?php echo $collection;?>"');

          //Input Form is parsed into a JSON
          formJSON = JSON.parse("{" + formArray.toString() + "}");
          for(var d = 0; d < crewArray.length; d++){
              formJSON['txtCrewmember'].push(crewArray[d])
          }

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