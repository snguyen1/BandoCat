<?php
require '../../../Library/SessionManager.php';
$session = new SessionManager();
$userfile = $_SESSION['username'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doc_id = $_POST['txtDocID'];
    writeXMLtag($doc_id, "libraryindex", $_POST['txtLibraryIndex'], $userfile);
    writeXMLtag($doc_id, "title", $_POST['txtTitle'], $userfile);
    writeXMLtag($doc_id, "subtitle", $_POST['txtSubtitle'], $userfile);
    writeXMLtag($doc_id, "scale", $_POST['txtScale'], $userfile);
    writeXMLtag($doc_id, "is", $_POST['rbIs'], $userfile);
    writeXMLtag($doc_id, "needsreview", $_POST['rbNeedsReview'], $userfile);
    writeXMLtag($doc_id, "northarrow", $_POST['rbNortharrow'], $userfile);
    writeXMLtag($doc_id, "street", $_POST['rbStreet'], $userfile);
    writeXMLtag($doc_id, "poi", $_POST['rbPoi'], $userfile);
    writeXMLtag($doc_id, "coordinates", $_POST['rbCoordinates'], $userfile);
    writeXMLtag($doc_id, "coast", $_POST['rbCoast'], $userfile);
    writeXMLtag($doc_id, "customername", $_POST['txtCustomername'], $userfile);
    writeXMLtag($doc_id, "startmonth", $_POST['ddlStartMonth'], $userfile);
    writeXMLtag($doc_id, "startday", $_POST['ddlStartDay'], $userfile);
    writeXMLtag($doc_id, "startyear", $_POST['ddlStartYear'], $userfile);
    writeXMLtag($doc_id, "endmonth", $_POST['ddlEndMonth'], $userfile);
    writeXMLtag($doc_id, "endday", $_POST['ddlEndDay'], $userfile);
    writeXMLtag($doc_id, "endyear", $_POST['ddlEndYear'], $userfile);
    writeXMLtag($doc_id, "fieldbooknumber", $_POST['txtFieldbooknumber'], $userfile);
    writeXMLtag($doc_id, "fieldbookpage", $_POST['txtFieldbookpage'], $userfile);
    writeXMLtag($doc_id, "readability", $_POST['ddlReadability'], $userfile);
    writeXMLtag($doc_id, "rectifiability", $_POST['ddlRectifiability'], $userfile);
    writeXMLtag($doc_id, "companyname", $_POST['txtCompanyname'], $userfile);
    writeXMLtag($doc_id, "documenttype", $_POST['txtDocumenttype'], $userfile);
    writeXMLtag($doc_id, "documentmedium", $_POST['ddlDocumentmedium'], $userfile);
    writeXMLtag($doc_id, "author", $_POST['txtAuthor'], $userfile);

    writeXMLtag($doc_id, "completed", 1, $userfile);
}

/**********************************************
 *Function: writeXMLtag
 *Description: writes the value of the input form into the element node value
 * Parameter(string): id (int) The document id
 *                      tag (string) the name of the element
 *                      data (post value) the value of an element
 *                      username (string) username; used to get to the file
 * Return value(string): None
 ***********************************************/
function writeXMLtag($id, $tag, $data, $username){
   	$document  = new DOMDocument();

//Determine if the file exist so to create a new folder with the new xml files; newbie and intern
    $filename = "../../Training_Collections/".$_POST['col']. "/" . $username . "/" . $username . "_".$_POST['type'].".xml";
	$document->load($filename);

    $tag = $document->getElementsByTagName($tag);
    var_dump($tag);
    $tag->item($id)->nodeValue = htmlspecialchars($data);
    var_dump($data);

$document->save($filename);
}
?>