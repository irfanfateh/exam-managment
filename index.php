<?php
require_once("business/utilities.php");
isSession();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Exam management system</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<link rel="stylesheet" href="style/style.css">
	<link rel="stylesheet" href="style/style2.css">
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
</head>
<body>
   <div class="container-fluid">
   		<div class="row">
   			<div class="col-2 bg-dark px-0" id="sideBar" style="min-height: 100vh;">
					<div class="text-right mt-4">
						<img src="image/sideBarLogo.png" alt="" class="img-fluid menuBtnsText">
						<button class="btn m-1" id="menuToggler"><i class="far fa-align-right text-white " id="togglerIcon"></i></button>
					</div>
				  <section class="sideBarLinksSection">
				  	<ul class="navbar-nav my-5">
							<!-- <li>  </li> -->
							<?php if ($_SESSION['actorData']["user_type"]=="ADMIN") { ?>
								<li><a href="?pageName=home&tab=adSt" class="btn btn-dark w-100 text-left iconMouse" id="home"><i class="fal fa-home btn-lg"></i> <span class="menuBtnsText"> Home</span> </a></li>
					  		<li><a href="?pageName=subject&tab=adSt" class="btn btn-dark w-100 text-left iconMouse" id="subject" ><i class="far fa-books-medical btn-lg"></i> <span class="menuBtnsText"> Manage Subjects</span> </a></li>
					  		<li><a href="?pageName=teacher&tab=adTchr" class="btn btn-dark w-100 text-left iconMouse" id="teacher" ><i class="fal fa-chalkboard-teacher btn-lg"></i> <span class="menuBtnsText"> Manage Teacher</span> </a></li>
					  		<li><a href="?pageName=setting" class="btn btn-dark w-100 text-left iconMouse" id="setting"><i class="fal fa-cogs text-white btn-lg"></i> <span class="menuBtnsText"> Settings</span> </a></li>
						<?php	} else if($_SESSION['actorData']["user_type"]=="TEACHER") { ?>
							<li><a href="?pageName=" class="btn btn-dark w-100 text-left iconMouse" id="home"><i class="fal fa-home btn-lg"></i> <span class="menuBtnsText"> Home</span> </a></li>
							<li><a href="?pageName=addquiz&tab=topic" class="btn btn-dark w-100 text-left iconMouse" id="addquiz"><i class="fal fa-question-square btn-lg"></i> <span class="menuBtnsText"> Manage Quiz</span> </a></li>
							<li><a href="?pageName=notification&tab=anounce" class="btn btn-dark w-100 text-left iconMouse" id="notification"><i class="far fa-bullhorn btn-lg"></i> <span class="menuBtnsText"> Make Announcement</span> </a></li>
							<li><a href="?pageName=paper&tab=make" class="btn btn-dark w-100 text-left iconMouse" id="paper"><i class="fal fa-paste btn-lg"></i> <span class="menuBtnsText"> Manage Paper</span> </a></li>
							<li><a href="?pageName=approvals" class="btn btn-dark w-100 text-left iconMouse" id="approvals"><i class="fad fa-user-graduate btn-lg"></i> <span class="menuBtnsText"> Approve Student</span> </a></li>
							<li><a href="?pageName=setting" class="btn btn-dark w-100 text-left iconMouse" id="setting"><i class="fal fa-cogs text-white btn-lg"></i> <span class="menuBtnsText"> Settings</span> </a></li>
						<?php		}  else if($_SESSION['actorData']["user_type"]=="STUDENT") { ?>
							<li><a href="?pageName=paper" class="btn btn-dark w-100 text-left iconMouse" id="paper"><i class="fal fa-sticky-note btn-lg"></i> <span class="menuBtnsText"> Take Paper</span> </a></li>
							<li><a href="?pageName=result" class="btn btn-dark w-100 text-left iconMouse" id="result"><i class="far fa-poll btn-lg"></i> <span class="menuBtnsText"> View Result</span> </a></li>
							<li><a href="?pageName=setting" class="btn btn-dark w-100 text-left iconMouse" id="setting"><i class="fal fa-cogs text-white btn-lg"></i> <span class="menuBtnsText"> Settings</span> </a></li>
						<?php } ?>

				  	</ul>
				  </section>
					<section class="pt-5 menuBtnsText">
						<span class="text-white ml-3">Powered By</span>
						<img src="image/companyLogo.png" alt="" class="img-fluid" height="100px">
					</section>
   			</div>
   			<div class="col-10 p-0" id="mainBar" style="background-color: #f5f7fa;">
   				<?php include("pages/navbar.php"); ?>
				<!-- nav bar end -->
				<div class="container-fluid" >
					<?php
						$pageName;
							switch (strtolower($_SESSION['actorData']["user_type"])) {
								case 'admin':
										$file="adminpages/home.inc.php";
										$pageFolder="adminpages";
									break;
								case 'teacher':
								$file="teacherpages/home.inc.php";
								$pageFolder="teacherpages";
									break;
								case 'student':
								$file="studentpages/paper.inc.php";
								$pageFolder="studentpages";
										break;
								default:
									$file='pages/nonapprove.inc.php';
							}
							$header="home";
							if (isset($_GET['pageName']) && $_SESSION['actorData']["user_type"]!="NOT APPROVED") {
								$pageName=strtolower($_GET['pageName']);
								$pageDir=scandir($pageFolder, 0);
								unset($pageDir[0],$pageDir[1]);
								if (in_array($pageName.".inc.php",$pageDir)) {
									$file=$pageFolder."/".$pageName.".inc.php";
									$header=$pageName;
								}else{
										$pageDir=scandir("pages", 0);
										unset($pageDir[0],$pageDir[1]);
										if (in_array($pageName.".inc.php",$pageDir)) {
											$file="pages"."/".$pageName.".inc.php";
											$header=$pageName;
										}
								}
							}

						?>
						<div class="container py-5">
						<h3><?php echo ucwords($header);
							getActiveTab($header);
						?></h3>
						</div>
						<span id="error"></span>
						<?php include($file);?>
				</div>
   			</div> <!-- col-10 closing -->
   		</div>
   </div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="js/jquerry.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
</body>
</html>
