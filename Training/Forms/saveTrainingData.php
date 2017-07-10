<?php
require '../../Library/SessionManager.php';
$session = new SessionManager();
$userfile = $_SESSION['username'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doc_id = $_POST['txtDocID'];
    writeXMLtag($doc_id, "libraryindex", $_POST['txtLibraryIndex'], $userfile);
    writeXMLtag($doc_id, "title", $_POST['txtTitle'], $userfile);
    writeXMLtag($doc_id, "needsreview", $_POST['rbNeedsReview'], $userfile);
    writeXMLtag($doc_id, "inasubfolder", $_POST['rbInASubfolder'], $userfile);
    writeXMLtag($doc_id, "author", $_POST['txtAuthor'], $userfile);
    writeXMLtag($doc_id, "subfoldercomments", $_POST['txtSubfolderComments'], $userfile);
    writeXMLtag($doc_id, "classification", $_POST['ddlClassification'], $userfile);
    writeXMLtag($doc_id, "classificationcomments", $_POST['txtClassificationComments'], $userfile);
    writeXMLtag($doc_id, "comments", $_POST['txtComments'], $userfile);
    writeXMLtag($doc_id, "startmonth", $_POST['ddlStartMonth'], $userfile);
    writeXMLtag($doc_id, "startday", $_POST['ddlStartDay'], $userfile);
    writeXMLtag($doc_id, "startyear", $_POST['ddlStartYear'], $userfile);
    writeXMLtag($doc_id, "endmonth", $_POST['ddlEndMonth'], $userfile);
    writeXMLtag($doc_id, "endday", $_POST['ddlEndDay'], $userfile);
    writeXMLtag($doc_id, "endyear", $_POST['ddlEndYear'], $userfile);
    writeXMLtag($doc_id, "completed", 1, $userfile);
}

function writeXMLtag($id, $tag, $data, $username){
   	$document  = new DOMDocument();

//Determine if the file exist so to create a new folder with the new xml files; newbie and intern
    $filename = "../Training_Collections/jobfolder/" . $username . "/" . $username . "_newbie.xml";
	$document->load($filename);
    if ($tag == 'author') {
        $author = $document->getElementsByTagName($tag)->item($id);
        $name = $document->getElementsByTagName('name')->item(0);
        $name->nodeValue = $data[0];
        $lenData = count($data);
        $lenNode = 0;
        $lenRemoved = 0;
        $authorNodes = $author->childNodes;

        foreach ($authorNodes as $node) {
            if ($node->tagName == 'name') {
                $lenNode++;
            }
        }

        if ($lenNode > 1) {
            for ($d = 0; $d < $lenNode; $d++) {
                $authorNodes->item(0)->parentNode->removeChild($authorNodes->item(0));
                $lenRemoved++;
            }
        }

        $nodeCount = $lenNode - $lenRemoved;
        if ($nodeCount == 0) {
            for ($e = 0; $e < $lenData; $e++){
                $newNode = $author->appendChild(new DOMElement('name'));
                $newNode->nodeValue = $data[$e];
            }
        }

        else{
            for ($e = 1; $e < $lenData; $e++){
                $newNode = $author->appendChild(new DOMElement('name'));
                $newNode->nodeValue = $data[$e];
            }
        }
    }


	else {
		    $tag = $document->getElementsByTagName($tag);
            $tag->item($id)->nodeValue = $data;
	}
$document->save($filename);
    clearstatcache();
}
?>