<!DOCTYPE html>

<?php
$user = $_GET['user'];
$collection = $_GET['col'];
$type = $_GET['type'];
var_dump($collection)


?>

<html xmlns="http://www.w3.org/1999/xhtml"><head></head><body>

			<a href="Form/list.php?col=&action=training&type='<?php echo $type ?>'">Back</a>

			<?php
				session_start(); 
				if (isset($_SESSION['currentId'])) {					
				}
				else
				{
					header("Location: list.php?col=jobfolder&action=training&type='<?php echo $type ?>'");
				}
			?>

<link rel="stylesheet" type="text/css" href="../styles.css">
<script type="text/javascript">
	var myMessages = ['info','warning','error','success'];


	function showMessage(type)
	{
		$('.'+ type +'-trigger').click(function(){
							  
			  $('.'+type).animate({margin-top:"0"}, 500);
		});
	}

	$(document).ready(function(){
		 
		 		 
		 // Show message
		 for(var i=0;i<myMessages.length;i++)
		 {
			showMessage(myMessages[i]);
		 }
		 
		 
		 
	}); 

</script>

</body></html>