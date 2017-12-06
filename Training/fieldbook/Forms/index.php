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
                                <span class="labelradio">
                                    <mark class="label">
                                        <span style = "color:red;"> * </span>
                                        Library Index:
                                    </mark>
                                    <p hidden>
                                        <b></b>
                                        <strong>Library Index: </strong>This field is automatically created by the file name; each value is unique and does not need to be changed.<br><i>Example: </i><?php echo $doc1->libraryindex; ?>
                                    </p>
                                </span>
                                <input type = "text" name = "txtLibraryIndex" id = "libraryindex" size="26" value='<?php echo $doc1->libraryindex; ?>' required />
                            </div>
                            <!-- COLLECTION -->
                            <div class="cell" id="collectionCell">
                                <span class="labelradio"><mark class="label"><span style = "color:red;"> * </span>Collection: </mark><p hidden><b></b><strong>Document collection: </strong>This should always be entered as “Blucher”, unless otherwise specified.</p></span>
                                <input type = "text" name = "txtBookcollection" id = "bookcollection" size="26" required="true" value='<?php echo $doc1->bookcollection; ?>' />
                            </div>
                            <!-- BOOKTITLE -->
                            <div class="cell" id="booktitleCell">
                                <span class="labelradio"><mark class="label">Book Title: </mark><p hidden><b></b><strong>Book Title: </strong>This field is automatically created by the file name, this value should not be changed.</p></span>
                                <input type = "text" name = "txtBooktitle" id = "booktitle" size="26" value='<?php echo $doc1->booktitle; ?>' />
                            </div>
                            <!-- JOB NUMBER -->
                            <div class="cell" id="jobnumberCell">
                                <span class="labelradio"><mark class="label">Job Number: </mark><p hidden><b></b><strong>Job Number: </strong>This value can usually be seen on the first page for a specific job in the field book. This number will usually be in the top right corner following the letter “J”, and can usually be found near the job title. Most jobs should have these, however it is not rare for a job number to be missing. An example would be “J-4237”. Only include the numbered value, not the “J”. Some jobs may contain more than one job number, include them all separated by commas.</p></span>
                                <input type = "text" name = "txtJobnumber" id = "jobnumber" size="26" value='<?php echo $doc1->jobnumber; ?>' />
                            </div>

                            <!-- JOB TTITLE -->
                            <div class="cell" id="jobtitleCell">
                                <span class="labelradio"><mark class="label">Job Title: </mark><p hidden><b></b><strong>Job Title: </strong> This is the main header at the top of the page for each job listed in the field book. Each job title should be listed as well in the index. Although they can occasionally be lengthy, include the full job title; the more detail the better.</p></span>
                                <input type = "text" name = "txtJobtitle" id = "jobtitle" size="26" value='<?php echo $doc1->jobtitle; ?>' />
                            </div>

                            <!-- INDEXED PAGE -->
                            <div class="cell" id="indexedpageCell">
                                <span class="labelradio"><mark class="label">Indexed Page: </mark><p hidden><b></b><strong>Indexed Page: </strong>This is the page number that is written in the top corner of the page. Odd numbers are usually not written out in the field book, however it is implied that these pages are still numbered. Pages on the left side are generally numbered evenly, and pages on the right side are odd. </p></span>
                                <input type = "text" name = "txtIndexedpage" id = "indexedpage" size="26" value='<?php echo $doc1->indexedpage; ?>' />
                            </div>


                            <!-- BLANK PAGE -->
                            <div class="cell" id="blankpageCell">
                                <span class="labelradio" >
                                <mark>Blank Page: </mark>
                                <p hidden><b></b><strong>Blank Page: </strong>If the page is COMPLETELY (except for the page number) blank, then it is a blank page. If there is any writing on the page (except for the page number), it is not blank. </p>
                                </span>
                                <input type = "radio" name = "rbBlankpage" id = "blankpage" size="26" value="1" <?php if($doc1->blankpage == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbBlankpage" id = "blankpage" size="26" value="0" <?php if($doc1->blankpage == 0) echo "checked"; ?>  />No
                            </div>

                            <!-- SKETCH -->
                            <div class="cell" id="sketchCell">
                                <span class="labelradio" >
                                <mark>Sketch: </mark>
                                    <p hidden><b></b><strong>Sketch: </strong>If there is a drawing or a map present on the page, then it is considered a sketch. In some cases, the surveyor may draw an angle or lines which may not represent a sketch. Use your best judgment to determine if it is a sketch of the jobsite or something else.</p>
                                </span>
                                <input type = "radio" name = "rbSketch" id = "sketch" size="26" value="1" <?php if($doc1->sketch == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbSketch" id = "sketch" size="26" value="0" <?php if($doc1->sketch == 0) echo "checked"; ?>  />No
                            </div>

                            <!-- LOOSE DOCUMENT -->
                            <div class="cell" id="loosedocumentCell">
                                <span class="labelradio" >
                                <mark>Loose Document: </mark>
                                <p hidden><b></b><strong>Loose Document: </strong>Indicate this page as a loose document if there is any file or document that is loose/stapled/glued to the pages. A loose document is not part of the original field book. They can often be found in between the pages, examples include receipts, attached drawings, invoices, etc.</p>
                                </span>
                                <input type = "radio" name = "rbLoosedocument" id = "loosedocument" size="26" value="1" <?php if($doc1->loosedocument == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbLoosedocument" id = "loosedocument" size="26" value="0" <?php if($doc1->loosedocument == 0) echo "checked"; ?>  />No
                            </div>


                            <!-- NEEDS REVIEW -->
                            <div class="cell" id="needsreviewCell">
                                <span class="labelradio" >
                                <mark>Needs Review: </mark>
                                <p hidden><b></b><strong>Needs Review: </strong>This is to signal if a review is needed, and always keep selection as yes</p>
                                </span>
                                <input type = "radio" name = "rbNeedsreview" id = "needsreview" size="26" value="1" <?php if($doc1->needsreview == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbNeedsreview" id = "needsreview" size="26" value="0" <?php if($doc1->needsreview == 0) echo "checked"; ?>  />No
                            </div>

                            <!-- FIELD BOOK AUTHOR -->
                            <div class="cell" id="authorCell">
                                <span class="labelradio"><mark class="label">Field Book Author: </mark><p hidden><b></b><strong>Field Book Author: </strong>This is a field that is very rarely used. Older field books had a field book author indicated towards the front of the book. Do not enter any names in this field unless the book specifically states there is a field book author.</p></span>
                                <input type = "text" name = "txtAuthor" id = "author" size="26" value='<?php echo $doc1->author; ?>' />
                            </div>

                            <!-- FIELD CREW MEMBER: -->
                            <div class="cell" id="crewCell">
                                <div class="crewMemberClass" id="crewMemberId0" style="width: 115%">
                                    <span class="labelradio">
                                        <mark class="label">Field Book Crew: </mark>
                                        <p hidden><b></b>
                                            <strong>Field Book Crew: </strong>TThe names for the field crew members will almost always be found on the odd numbered pages in the top left corner. List each and every field crew member on each page for that specific job. If their names are abbreviated, an index of field crew members can almost always be found at the very beginning of the field book. Field crew members can change throughout the job, enter each field crew member on every page. The maximum amount of field crew members that can be entered for the training is five, however the average is usually around four. For example, if a job is twenty pages and you see John Carter on only one page and he is absent from the rest, his name must be included on every page for the field crew members.
                                        </p>
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
                                <span class="labelradio">
                                    <mark class="label">
                                        Document Start Date:
                                    </mark>
                                    <p hidden>
                                        <b></b>
                                        <strong>Document Start Date: </strong>The earliest date on the document- as it pertains to the creation of that document.</br><i>*If there is one date on the document, only fill out the Document End Date boxes.</i>
                                    </p>
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
                                <span class="labelradio">
                                    <mark class="label">
                                        Document End Date:
                                    </mark>
                                    <p hidden>
                                        <b></b>
                                        <strong>Document End Date: </strong>The latest date on the document- as it pertains to the creation of that document.
                                    </p>
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
                                <span class="labelradio"><mark class="label">Comments: </mark><p hidden><b></b><strong>Document Title: </strong>1. The client for the job. After the job title, there is usually a following line that says “For John Doe”, include this line in the comments.
                                2. Include all field books, pages, and maps that are referenced on the job title page. Often you will see something such as “B 309 P 42”, or “map 4R-87” on this page. Include these values in the comments, as this job may share similarities to another in a different field book or map.
                                3. The front cover, indices, and back cover should simply be indicated as so in the comments. Just insert “Front cover”, “Index”, and “Back cover” in the comments when needed.
                                </p></span>
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

                    $('form').on('change', ['input', 'textarea'],function (event) {
                        //On change the table data is stored to the formJSON object
                        table2JSON();
                        //Document ID
                        var docID = formJSON.document;
                        //Target element ID
                        var targetID = event.originalEvent.target.id;
                        //Target element Class
                        var targetClass = event.originalEvent.target.className;
                        //Target element value
                        var targetValue = event.target.value;
                        //Target element ID converted into a json object to be used as an object property
                        var IDProperty = JSON.parse(JSON.stringify(targetID));


                        //Answer JSON element
                        var answerElement = ansDataJSON.document[docID][IDProperty];
                        //Flag that dictates if the Answer JSON element has a property called name because crewmember
                        //contains different names
                        var nameFlag = answerElement.hasOwnProperty('name');
                        //If the Answer JSON element has a property called name a crewJSON object is initiated
                        if(nameFlag){
                            var crewJSON = {};
                            for(var nm = 0; nm < answerElement.name.length; nm++){
                                crewJSON["crewmember" + String(nm)]=answerElement.name[nm]["#text"];
                            }
                        }

                        else
                            var answerValue = ansDataJSON.document[docID][IDProperty]['#text'];

                        //If the Answer JSON element value is empty an empty string value is given
                        if(jQuery.isEmptyObject(ansDataJSON.document[docID][IDProperty])) {
                            answerValue = ''
                        }

                        var crewType = typeof crewJSON;
                        switch (crewType){
                            case 'object':
                                $.each(crewJSON, function (crewClass) {
                                    if(crewClass == targetClass){
                                        var crewProperty = JSON.parse(JSON.stringify(crewClass));
                                        if(crewJSON[crewProperty].toLowerCase() == targetValue.toLowerCase()) {
                                            $("#aDeclerin").remove();
                                            $("." + String(targetClass)).removeAttr('style').css('-webkit-animation', 'correctFade 2s linear');
                                            return
                                        }
                                    else
                                        $("." + String(targetClass)).css('outline', 'red').css('outline-style', 'solid');
                                    }
                                });
                                break;
                            case 'undefined':
                                if (answerValue.toLowerCase() == targetValue.toLowerCase()) {
                                    $("#aDeclerin").remove();
                                    $("#" + String(targetID)).removeAttr('style').css('-webkit-animation', 'correctFade 2s linear');
                                }

                                else{
                                    $("#" + String(targetID)).css('outline', 'red').css('outline-style', 'solid');
                                }
                                break;
                        }
                    })
                }
            };
            xhttp_answers.open("GET", "newbie_Answers.xml");
            xhttp_answers.send();
        }



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
        var crewTableArray = [];

        /****** LEFT COLUMN ******/
        //For every element in the Left column
        $.each(accountInputsCol1, function (index, element) {
            if(element.id == "crewCell") {
                for(var j = 0; j < element.children.length;j++){
                    //If a field crew input is not undefined its value is stored into an array that is then posted as
                    //into the formJSON object
                    if(typeof element.children[j].children['crewmember'] !== "undefined") {
                        crewTableArray.push(element.children[j].children['crewmember'].value)
                    }
                }
                structureJSON(formJSON, 'crewmember', crewTableArray)
            }
            else{
                if($("#"+element.children[1].id).is(':radio'))
                    structureJSON(formJSON, element.children[1].id,$("#" + element.children[1].id + ":checked").val());
                //Otherwise if not a radio nor a field crew element the input value is stored into the formJSON object
                else
                    structureJSON(formJSON, element.children[1].id,element.children[1].value);

            }

        });

        /****** RIGHT COLUMN ******/
        //For every element in the Right column
        for(var i = 0; i < accountInputsCol2.length-1; i++) {
            //Detects the startDateCell div id and loops through the three day input drop downs to retrieve their
            //elements ids and values.
            if(accountInputsCol2[i].id == 'startDateCell'){
                for(var d = 2; d < 4; d++)
                    structureJSON(formJSON, accountInputsCol2[i].children[d].id, accountInputsCol2[i].children[d].value);
            }

            //Detects if the element has a endDateCell id and loops through the next two end days to retrieve their
            //elements ids and values.
            else if(accountInputsCol2[i].id == 'endDateCell') {
                for(var d = 2; d < 4; d++)
                    structureJSON(formJSON, accountInputsCol2[i].children[d].id, accountInputsCol2[i].children[d].value);
            }
            //If not a date element, the elements values are stored into the formJSON
            structureJSON(formJSON, accountInputsCol2[i].children[1].id,accountInputsCol2[i].children[1].value);
        }
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
                if(jQuery.isEmptyObject(ansDataJSON.document[formJSON.document][idProperty])){
                    ansDataJSON.document[formJSON.document][idProperty]['#text'] = ''
                }
                var nameFlagComp = ansDataJSON.document[formJSON.document][idProperty].hasOwnProperty('name');
                if(nameFlagComp){
                    if(jQuery.isEmptyObject(ansDataJSON.document[formJSON.document][idProperty]['name'])){
                        ansDataJSON.document[formJSON.document][idProperty]['name'] = [];
                        emptyName = {};
                        emptyName['#text'] = '';
                        ansDataJSON.document[formJSON.document][idProperty]['name'].push(emptyName)
                    }
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

                if(id == 'crewmember'){
                    for(var v = 0; v < value.length; v++) {
                        if(value.length == ansVal['name'].length){
                            //Validates the equality of answer value and input value
                            if(value[v].toLowerCase() == ansVal['name'][v]['#text'].toLowerCase()){
                                //Returns false for errors
                                e = false;
                                comparisonArray.push([e, value, ansVal['name'][v]['#text'], id])
                            }
                            else {
                                //Returns true for errors
                                e = true;
                                comparisonArray.push([e, value, ansVal['name'][v]['#text'], id]);
                            }
                        }
                        //Error if uneven amount of answer values and input values
                        else{
                            comparisonArray.push([true, '', 'uneven amount of crew members', id])
                        }
                    }
                }

                else{
                    if(id == 'crewmember') {
                        e = true;
                        comparisonArray.push([e, value, ansVal['#text']]);
                    }
                    //User and answer values are compared
                    if(value.toLowerCase() == ansVal['#text'].toLowerCase()){
                        //Returns false for errors
                        e = false;
                        comparisonArray.push([e, value, ansVal['#text']])
                    }
                    else{
                        //Returns true for errors
                        e = true;
                        comparisonArray.push([e, value, ansVal['#text']]);
                    }
                }
            }
        });
        return comparisonArray;
    }

    //Input form array
    formArray = [];
    crewArray = [];
      //Submit function that will convert the input form into a JSON
      $("#form").on("submit", function (e) {
          e.preventDefault();
          table2JSON();
          //Default no error values
          if('<?php echo $type ?>' == 'newbie'){
              error = false;

              for(var d = 0; d < formJSON.data.length; d++){
                  //User input id
                  var formJSONID = formJSON.data[d].id;
                  //User input value
                  var formJSONValue = formJSON.data[d].value;
                  //Compares User and Answer values
                  error = dataComparison(formJSONID, formJSONValue);
                  //If error, the user and answer values are different on submit the submission is stopped an the input
                  //element's outline is highlighted with a orange color
                  for(var er = 0; er < error.length; er++) {
                      if(error[er][0]){
                          $("#aDeclerin").remove();
                          alert("There is an error");
                          $("#"+formJSONID).css('outline', 'orange').css('outline', 'orange').css('outline-style', 'solid');
                          var parentDeclerin = $("#" + String(formJSONID)).parent()[0].id;
                          $('<span class="labelradio" id="aDeclerin" style="float: right; width: 10px;margin: -11% 0% 0% 0%; min-width:10%" ><img src="../../images/pin_question.png" style="width: 50%;"><p hidden>' + error[er][2] + '</p></span>').insertAfter("#" + parentDeclerin);
                          return
                      }
                  }

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