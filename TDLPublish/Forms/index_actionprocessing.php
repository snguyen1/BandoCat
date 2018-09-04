<?php
//This performs server side action when user select an action on Action column in index.php
//This performs server side action when user select an action on Action column in index.php
spl_autoload_register(function ($class_name) {
    require_once "../../Library/" . $class_name . '.php';});

date_default_timezone_set("America/Chicago");
$session = new SessionManager();
$Schema = new TDLSchema();
$TDL = new TDLPublishJob();
$DB = new DBHelper();
$collectionName = $_POST['ddlCollection'];
$collection = $DB->GET_COLLECTION_INFO($collectionName);
$docID = $_POST['docID'];

//collect metadata of the document, given collectionName, templateID and documentID
switch($collection["templateID"])
{
    case 1: //map template
        $DB = new MapDBHelper();
        $doc = $DB->SP_TEMPLATE_MAP_DOCUMENT_SELECT($collectionName,$docID);
        break;
    case 2: //jobfolder template
        $DB = new FolderDBHelper();
        $doc = $DB->SP_TEMPLATE_FOLDER_DOCUMENT_SELECT($collectionName,$docID);
        $doc['Authors'] = $DB->GET_FOLDER_AUTHORS_BY_DOCUMENT_ID($collectionName,$docID); //multiple authors to 1 document
        break;
    case 3: //fieldbook template
        $DB = new FieldBookDBHelper();
        $doc = $DB->SP_TEMPLATE_FIELDBOOK_DOCUMENT_SELECT($collectionName,$docID);
        $doc['Crews'] = $DB->GET_FIELDBOOK_CREWS_BY_DOCUMENT_ID($collectionName,$docID); //multiple crews
        break;
    case 4: //indices template
        $DB = new IndicesDBHelper();
        $doc = $DB->SP_TEMPLATE_INDICES_DOCUMENT_SELECT($collectionName,$docID);
        break;
    default:
        $doc = null;
        echo "Error initializing class!";
        return; //error
}
//include Collection's info to the $doc Array
$doc["TDLCollection"] = $collection["TDLname"];
$doc += $collection;

//switch to the currently working Database
$DB->SWITCH_DB($collectionName);
//GET ITEM INFO
$dspaceDocInfo = $DB->PUBLISHING_DOCUMENT_GET_DSPACE_INFO($docID);
$dspaceID = $dspaceDocInfo['dspaceID'];


//Specify different actions to perform in this SWITCH/CASE statement
switch($_POST['action'])
{
    case "push":
        //PUSH
        $ret = $DB->PUBLISHING_DOCUMENT_UPDATE_STATUS($docID,2); //push to queue;
        break;
    case "pop":
        //POP
        $ret = $DB->PUBLISHING_DOCUMENT_UPDATE_STATUS($docID,0);
        break;
    case "unpublish":
        //START UNPUBLISH
        //FIND ALL BITSTREAMS, DELETE ALL BITSTREAMS BELONG TO THIS ITEM
        $bitstreams = json_decode($TDL->TDL_CUSTOM_GET("items/" . $dspaceID . "/bitstreams"),true);	
		$jsonfilename = __DIR__ . '\\' . $docID . '.json';
        $fp = fopen($jsonfilename, 'w');
		
	    fwrite($fp, $bitstreams);
		
       
        fclose($fp);
       /*  foreach($bitstreams as $b)
        {
            $ret = $TDL->TDL_CUSTOM_DELETE("bitstreams/" . $b["id"]); //delete bitstreams
            if($ret != "200") {
                echo "Deleting bitstreams, return value: " . $ret . "\n";
                return;
            }
        }
        //DELETE ITEM
        $ret = $TDL->TDL_CUSTOM_DELETE("items/" . $dspaceID); //delete item (metadata)

        //reset status flag
        //write log to DB
        $ret = $DB->PUBLISHING_DOCUMENT_UPDATE_STATUS($docID,0);
        //reset
        if($ret) $ret = $DB->PUBLISHING_DOCUMENT_TDL_UPDATE($docID,0,null); */
        break;
        //end UNPUBLISH
    case "update":
        //START UPDATE
        $convertedSchema = $Schema->convertSchema($collection['templateID'],$doc,false); //convert from BandoCat to TDL schema using method in TDLSchema
		$bitstreams = $TDL->TDL_GET_BITSTREAMS($dspaceID);
		
		 foreach($bitstreams as $b)
        { 
			//var_dump($b);
			$bstream = json_decode(json_encode($b), true);
			
			$ext = substr($bstream["name"], -4);
			
				switch($ext)
				{
					//this case coveres the bitstream where the name ends in ".tif.jpg" i.e : 1-_31_rectified.tif.jpg // this is also known as the thumbnail (check bundleName in the rest Meta data)
					//so we need to check to see if the thumbnail or if this is an image
					case ".jpg":
						if(substr($bstream["name"],-8) == ".tif.jpg")
						{
							//this is the thumbnail
							if($bstream["sizeBytes"] == 0)
							{
								
							}
							
						}
						else
						{
							//this is an original .jpg
							if($bstream["sizeBytes"] == 0)
							{
								//this means the .jpg had an error and doesn't exist on TDL (0 size file)
								//we need to identify the bitstream in our database, and regenerate the .jpg
								
								//!!!! Our FileNames hold a .tif image. We need to strip off the .jpg from this and append a .jpg
								$retdoc = $DB->GET_DOCUMENT_BY_FILENAME($collectionName, substr($bstream["name"],0, -4) . ".tif");
								
								//verify this is the same item
								//$retdoc is returned as a 2D array. It is technically possible to get more than 1 return, this is why we verify in the next step
								if($retdoc[0]["dspaceID"] == $dspaceID)
								{
									//Verified!
									var_dump("We have verified the document");
									
									//Need to regenerate the .jpg file
									//var_dump($retdoc);
									 $pathtoImage = $collection["storagedir"] . $retdoc[0]["filenamepath"];
									 $jpgFilePath = str_replace(".tif",".jpg",$pathtoImage);
									 $jpgFileName = str_replace(".tif",".jpg",$retdoc[0]["filename"]);
									 exec("convert -limit memory 32MiB " . $pathtoImage . " " . $jpgFilePath );
								}
								else
								{
									//UNVERIFIED - problem
								}
								
							}
						}
						break;
					//this case covers the recitifed original TIF image
					case ".tif":
						   //this is a .tif (recitifed)
						break;
						
					case ".kmz":
						   //this is  a .kmz
						break;
				}
				
			
		}
           /*  $ret = $TDL->TDL_CUSTOM_DELETE("bitstreams/" . $b["id"]); //delete bitstreams
            if($ret != "200") {
                echo "Deleting bitstreams, return value: " . $ret . "\n";
                return;
            } */
        //}
        //save the converted schema in a temporary json file
        $jsonfilename = __DIR__ . '\\' . $docID . '.json';
        $fp = fopen($jsonfilename, 'w');
        fwrite($fp, $convertedSchema);
        fclose($fp);
        $ret = $TDL->TDL_CUSTOM_PUT("items/" . $dspaceID . "/metadata",$jsonfilename,"application/json",null);
		
        unlink($jsonfilename);
        //END UPDATE
        break;
    default:
        echo "Error! Unclassified action!";
        return;
}

//WRITE A LOG
    if($ret)
        $ret = $DB->SP_LOG_WRITE($_POST['action'] . " (tdl)",$collection["collectionID"],$docID,$session->getUserID(),"success","");
    if($ret)
        echo "Success!";
    else echo "Error!";
    return;
	
	function objectToArray( $data ) 
	{
    if ( is_object( $data ) ) 
        $d = get_object_vars( $data );
	}
	function startsWith($haystack, $needle)
	{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
	}

	function endsWith($haystack, $needle)
	{
    $length = strlen($needle);
    if ($length == 0)
	{
        return true;
    }

    return (substr($haystack, -$length) === $needle);
	}
?>