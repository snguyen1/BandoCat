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
    writeXMLtag($doc_id, "author1", $_POST['txtAuthor'], $userfile);
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
    echo "<script>window.location = 'mapEditingProcess.php'</script>";

}

function writeXMLtag($id, $tag, $data, $username){
	$document  = new DOMDocument();

//Determine if the file exist so to create a new folder with the new xml files; newbie and intern
    $filename = "../Training_Collections/jobfolder/" . $username . "/" . $username . "_newbie.xml";


	$document->load($filename);

    if ($tag == 'author1') {
        var_dump($tag);
    }
	$tag = $document->getElementsByTagName($tag);

	if ($tag->length > 0) {
		if ($id > $tag->length && isset($_SESSION[$username])) {
			$_SESSION[$username] = 1;
			return;
		}


		else
		{
		    var_dump($tag->item($id)->nodeName);
            var_dump($tag->item($id)->nodeValue);

            $tag->item($id)->nodeValue = $data;
				//echo $data." ".$id."<br>";
		}
	}
	$document->save($filename);
}
?>