<?php
include '../../Library/SessionManager.php';
$session = new SessionManager();

if(isset($_GET['col']) && isset($_GET['column']))
{
    require('../../Library/DBHelper.php');
    require('../../Library/FieldBookDBHelper.php');
    //Get passed variables, use htmlspecialchars to verify col
    $collection = htmlspecialchars($_GET['col']);
    $column = $_GET['column'];
    $booktitle = $_GET['booktitle'];
    $stage = $_GET['stage'];
    $errorFlag = false;
    $errorType = null;
    //create new instance of DBHelper
    $DB = new DBHelper();
    $FB = new FieldBookDBHelper();
    //Selects appropriate database, and counts the number of columns to return an accurate count.
    $count = $DB->GET_DOCUMENT_COUNT($collection);
    //Switch statement for "action" parameter to determine which document we are counting
}
else header('Location: ../../');
    $config = $DB->SP_GET_COLLECTION_CONFIG($_GET['col']);
    $ret = $FB->GET_ALL_FIELDBOOK_FILENAMES_BY_BOOKTITLE($_GET['col'], $booktitle);
    $folder = null;

    //GET THE PARENT DIRECTORY NAME
    foreach($ret as $innerArray)
    {
        if(is_array($innerArray))
        {
           // var_dump($innerArray);
            foreach($innerArray as $value)
            {
               // echo $value;
               // echo $value;
                $folder = explode("-", $value)[0];
                break;

            }
        }
    }

    //COMBINE THE PATH AND CHECK IF VALID
    $path = $config['StorageDir'] . $folder;

    if(!is_dir($path))
    {
        $errorFlag = true;
        $errorType = "1";
    }
    //IF THE DIRECTORY WAS FOUND
    if($errorFlag != true)
    {
        //SCAN DIRECTORY AND CONVERT TIF FILES TO PDF WITH 40% COMPRESSION
        $files = scandir($path);
        foreach($files as $file)
        {

            if ($file != '.' && $file != '..' && $file != "Title_Page.pdf")
            {
                $exec1 = "convert " . $path . '/' . basename($file) . " -quiet -compress jpeg -quality 40 " . $path . '/' . basename($file, '.tif') . ".pdf";
                exec($exec1, $yaks, $return);
            }
        }
        //If the compression/conversion failed
        if($return == 1)
        {
            $errorFlag = true;
            $errorType = "2";
        }
        else
        {
            //SCAN DIRECTORY FOR NEWLY CREATED PDF FILES
            $files = scandir($path);
            $exec2 = "pdftk ";
            $titlepage = "C:/xampp/htdocs/BandoCat/Images/Title_Page.pdf ";
            $exec2 .= $titlepage;
            //BUILD STRING TO COMBINE ALL PDFS INTO ONE
           // $exec2 .= $path . '/' . "Title_Page.pdf" . " ";


            foreach($files as $file)
            {
                // var_dump($files);.
                if($file != '.' && $file != '..')
                {
                    $file_info = pathinfo($file);
                    if($file_info['extension'] == "pdf")
                    {
                        $exec2 .= $path . '/' . basename($file) . " ";


                    }
                }
            }
            $exec2 .= " cat output " . $path . '/' . "Book_" . $booktitle . ".pdf";

            exec($exec2,$yaks2,$return1);
            //IF THE COMBINING OF PDFS IS SUCCESSFUL DELETE CREATED PDFS
            if($return1 == 0)
            {

                foreach($files as $file)
                {
                    // var_dump($files);
                    if($file != '.' && $file != '..')
                    {
                        $file_info = pathinfo($file);
                        if($file_info['extension'] == "pdf")
                        {
                            unlink($path . '/' . $file);


                        }
                    }
                }
                echo 'Success!';
                $booktitle = (string)$booktitle;
                $stage = (string)$stage;
                $boop = $FB->UPDATE_FIELDBOOK_READYFORPDF($collection,$booktitle,$stage);
            }else{
                echo 'Failed! ';
                echo $exec2;
            }

        }
    }



    if($errorFlag == true)
    {
        echo "Error: Type " . $errorType;
       // echo $path;
    }
?>

