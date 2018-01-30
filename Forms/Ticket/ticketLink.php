<?php
//
include '../../Library/SessionManager.php';
$session = new SessionManager();
if($session->isAdmin()) {
    require('../../Library/DBHelper.php');
    $DB = new DBHelper();
}
$data = $_POST;
$ticketData = [];

foreach($data['data'] as $ticket){
    //Retrieves the document id of a library index
    $docID = $DB->SELECT_DOCID_BY_SUBJECT($ticket['subject'], $ticket['subjectCol']);

    if ($docID == false)
      array_push($ticketData,[false, $ticket['subject']]);

    else
        array_push($ticketData, $docID);
}
$objJSON = new \stdClass();
$objJSON -> data = $ticketData;

echo json_encode($objJSON)



?>