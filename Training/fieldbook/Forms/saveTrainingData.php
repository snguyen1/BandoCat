<?php
require '../../../Library/SessionManager.php';
$session = new SessionManager();
$userfile = $_SESSION['username'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doc_id = $_POST['txtDocID'];
    writeXMLtag($doc_id, "libraryindex", $_POST['txtLibraryIndex'], $userfile);
    writeXMLtag($doc_id, "bookcollection", $_POST['txtBookcollection'], $userfile);
    writeXMLtag($doc_id, "booktitle", $_POST['txtBooktitle'], $userfile);
    writeXMLtag($doc_id, "jobnumber", $_POST['txtJobnumber'], $userfile);
    writeXMLtag($doc_id, "jobtitle", $_POST['txtJobtitle'], $userfile);
    writeXMLtag($doc_id, "indexedpage", $_POST['txtIndexedpage'], $userfile);
    writeXMLtag($doc_id, "blankpage", $_POST['rbBlankpage'], $userfile);
    writeXMLtag($doc_id, "sketch", $_POST['rbSketch'], $userfile);
    writeXMLtag($doc_id, "loosedocument", $_POST['rbLoosedocument'], $userfile);
    writeXMLtag($doc_id, "needsreview", $_POST['rbNeedsreview'], $userfile);
    writeXMLtag($doc_id, "author", $_POST['txtAuthor'], $userfile);
    writeXMLtag($doc_id, "crewmember", $_POST['txtCrewmember'], $userfile);
    writeXMLtag($doc_id, "startmonth", $_POST['ddlStartMonth'], $userfile);
    writeXMLtag($doc_id, "startday", $_POST['ddlStartDay'], $userfile);
    writeXMLtag($doc_id, "startyear", $_POST['ddlStartYear'], $userfile);
    writeXMLtag($doc_id, "endmonth", $_POST['ddlEndMonth'], $userfile);
    writeXMLtag($doc_id, "endday", $_POST['ddlEndDay'], $userfile);
    writeXMLtag($doc_id, "endyear", $_POST['ddlEndYear'], $userfile);
    writeXMLtag($doc_id, "comments", $_POST['txtComments'], $userfile);
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

    if ($tag == 'crewmember') {
        $crewmember = $document->getElementsByTagName($tag)->item($id);
//        $name = $document->getElementsByTagName('name')->item($id);
//        $name->nodeValue = $data[0];
        $lenData = count($data);
        $lenRemoved = 0;
        $crewmemberNodes = $crewmember->childNodes;
        $lenNode = $crewmemberNodes->length;

        for($d = $lenNode-1; $d >= 0; --$d){
            $crewmember->removeChild($crewmember->childNodes->item($d));
            $lenRemoved++;
        }
        var_dump($lenRemoved);

        $nodeCount = $lenNode - $lenRemoved;
        var_dump($lenNode);
        var_dump($lenRemoved);
        var_dump($nodeCount);
        if ($nodeCount == 0) {
            for ($e = 0; $e < $lenData; $e++){
                $newNode = $crewmember->appendChild(new DOMElement('name'));
                $newNode->nodeValue = $data[$e];
            }
        }

        else{
            for ($e = 1; $e < $lenData; $e++){
                $newNode = $crewmember->appendChild(new DOMElement('name'));
                $newNode->nodeValue = $data[$e];
            }
        }
    }


    else {
        $tag = $document->getElementsByTagName($tag);
        $tag->item($id)->nodeValue = htmlspecialchars($data);
    }
$document->save($filename);
}
?>