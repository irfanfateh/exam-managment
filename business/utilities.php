<?php
	function printErrorMsg($msg,$flag){
		if ($flag==true) { ?>
							<script>
								jQuery(document).ready(function($) {
									$("#error").html('<div class="alert alert-success container alert-dismissible fade show" role="alert">'
										  +'<strong>successfully!</strong> <?php echo $msg; ?>'
										 +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
										    +'<span aria-hidden="true">&times;</span>'
										 +'</button>'
										+'</div>');

								});
							</script>
		<?php } else { ?>
						<script>
								jQuery(document).ready(function($) {
									$("#error").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
										  +'<strong>Error!</strong> <?php echo $msg; ?>'
										 +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
										    +'<span aria-hidden="true">&times;</span>'
										 +'</button>'
										+'</div>');

								});
							</script>
		<?php }
	}
?>

<?php
	function getActiveTab($id){ ?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$("#<?php echo $id ?>").addClass('active');
				});
			</script>
	<?php }
?>

<?php
	function redirectTo($path){
		header("Location: ".$path, true, 301);
			exit();
	}
?>

<?php
			require_once("database/announcementDB.php");
function getAnnouncement()
{
		return 	getAnnouncementDB();
}
?>

<?php
function isSession(){
	session_start();
	if (!isset($_SESSION['actorData'])) {
		redirectTo("login.php");
	}
}
 ?>

 <?php
 require_once("database/settingDB.php");
 function changeAdminPass()
 {
     if (isOldPass($_POST['oldpass'],$_SESSION['actorData']["user_name"])) {
       $flag=changeAdminPassDB($_POST['newpass'],$_SESSION['actorData']["user_name"]);
       if ($flag) {
         printErrorMsg("updated your password into database.",true);
       } else {
         printErrorMsg("system failed to update into database.",false);
       }

     } else {
       printErrorMsg("Old password is wrong!",false);
     }

 }
  ?>

	<?php
	require_once("database/subjectDB.php");
	  function getAssignSubjects(){
			$raw=getAssignSubjectFor($_SESSION['actorData']["user_name"]);
			return $raw;
	  }
	  function getSubjects(){
			$raw=getAssignSubject();
			return $raw;
	  }

	?>
	<?php
	require_once("database/homeDB.php");
	  function getHome(){
			$raw=getHomeForDB($_SESSION['actorData']["user_type"]);
			return $raw;
	  }
	?>
