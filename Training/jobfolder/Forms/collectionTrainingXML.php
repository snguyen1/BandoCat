<?php
/***************************************************************************************************
 * File that creates the trainees' XML files for newbie and intermediate type, for catalog and trainee progress.
 * The file is executed when a training option is selected from a main page.
 ***************************************************************************************************/
//Posted data from Collection Template index page.
//Data includes: Collection name, Newbie training, Intermediate training, and User name
$data = $_POST;
$training_col = $data['col'];
$training_user = $data['user'];
$training_newbie = $data['ntype'];
$training_inter = $data['itype'];

//Construction of the User's training directory path
//Training main directory
$training_parent = "../../Training_Collections";
//Collection directory
$training_collection_dir = $training_parent.'/'.$training_col;
//User directory
$training_user_dir = $training_collection_dir.'/'.$training_user;



/*Collection Directory Folder*/
//If the Collection directory exists nothing happens
    if (file_exists($training_collection_dir))
        $training_collection_dir;
//Else a new Collection directory is made
    else
        mkdir($training_collection_dir, 07000);

/*User Directory Folder*/
//If the User directory exists nothing happens
    if (file_exists($training_user_dir))
        $training_user_dir;
//Else a new User directory is made
    else
        mkdir($training_user_dir, 07000);



/* User Newbie XML file creation.*/
    if ($training_newbie == 'newbie') {
        //Newbie training document path
        $training_XML = $training_user_dir.'/'.$training_user . "_newbie.xml";
        //If the Newbie training document exists nothing happens
        if (file_exists($training_XML))
            $training_XML = $training_user_dir.'/'.$training_user . "_newbie.xml";

        else{
            //Otherwise, a new empty Newbie training document is created
            $xml = new DOMDocument();
            //The new Newbie training document is saved to the Newbie training document path
            $xml->save($training_XML);
            //The new Newbie training document is opened in a writing mode
            $myfile = fopen($training_XML, 'w') or die("Cannot create training log!");
            fclose($myfile);
            //The information stored in the newbie.xml document is copied to the new Newbie training
            copy( "newbie.xml", $training_XML);
        }
    }

/*User Intermediate XML file creation.*/
    if ($training_inter == 'inter') {
        //Newbie training document path
        $training_XML = $training_user_dir.'/'.$training_user . "_inter.xml";
        //If the Newbie training document exists nothing happens
        if (file_exists($training_XML))
            $training_XML = $training_user_dir.'/'.$training_user . "_inter.xml";


        else{
            //Otherwise, a new empty Intermediate training document is created
            $xml = new DOMDocument();
            //The new Intermediate training document is saved to the Intermediate training document path
            $xml->save($training_XML);
            //The new Intermediate training document is opened in a writing mode
            $myfile = fopen($training_XML, 'w') or die("Cannot create training log!");
            fclose($myfile);
            //The information stored in the inter.xml document is copied to the new Intermediate training
            copy( "inter.xml", $training_XML);
        }
}
?>