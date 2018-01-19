<?php
//
include '../../Library/SessionManager.php';
$session = new SessionManager();
if($session->isAdmin()) {
    require('../../Library/DBHelper.php');
    $DB = new DBHelper();
}
$data = $_POST;
//Retrieves the document id of a library index
    $docID = $DB->SELECT_DOCID_BY_SUBJECT($data['subject'], $data['subjectCol']);

echo json_encode($docID);
?>