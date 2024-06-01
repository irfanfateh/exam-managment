<?php
	$errorMessage="";
		if (isset($_POST["submit"])) {
			require_once("database/loginDB.php");
			if($_POST["submit"]=="signIn"){
				$actor=getLogInConfirmation(strtoupper($_POST["id"]),$_POST["pwd"]);
					if ($actor!="none") {
						// $_SESSION['actor']=$actor;
						require_once("business/utilities.php");
						redirectTo("http://localhost/EXM/");
					}else{
						$errorMessage='<div class="alert alert-danger alert-dismissible">
														<button type="button" class="close" data-dismiss="alert">&times;</button>
														<strong>Error!</strong> invalid id or password access denied. Try again!
														</div>';
					}
			}else if($_POST["submit"]=="addStd"){
					require_once("business/student_handler.php");
					if(addStudent()){
						$errorMessage='<div class="alert alert-success alert-dismissible">
														<button type="button" class="close" data-dismiss="alert">&times;</button>
														<strong>Successfully!</strong> Registered to sytem now log in to get services.
														</div>';
					}else{
						$errorMessage='<div class="alert alert-danger alert-dismissible">
														<button type="button" class="close" data-dismiss="alert">&times;</button>
														<strong>Error!</strong> system fail to registration. Try again!
														</div>';
					}
			}
		}


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<title>LogIn</title>
	<style type="text/css">
		#quoteBg{
			background: url(image/bg-Logo.jpg) no-repeat center center fixed;
			background-size: cover;
		}
		#registrationBtn{
			cursor:pointer;
		}
	</style>
	<script>
	    if ( window.history.replaceState ) {
	        window.history.replaceState( null, null, window.location.href );
	    }
	</script>
</head>
<body>
	<header>
		<!-- title bar -->
		<div class="container-fluid">
			<div class="row text-center px-3">
			<div class="col-md-6">
				<h3 class="py-4">“in the name of Allah the most beneficent the most merciful.”</h3>
			</div>
			<div class="col-md-6">
				<h1 class="py-4">بِسْمِ ٱللَّٰهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ</h1>
			</div>
			</div>
		</div>
		</header>
		<!-- title bar end -->
		<div style="height:5px; background-color: #f2eeed;"></div>
		<!-- login & logo row -->
		<section id="loginSection" class="my-3">
		<div class="container-fluid">
		<div class="row">
			<div class="col-lg-5">
				<div class="w-75 text-center m-auto py-5">
					<img src="image/loginLogo.png" alt="">
					<form action="login.php" class="pt-3" method="post">
						<span><?php echo $errorMessage;?></span>
					  <div class="form-group">
					    <input type="text" class="form-control" placeholder="user name" name="id" required autocomplete="off">
					  </div>
					  <div class="form-group">
					    <input type="password" class="form-control" placeholder="password" name="pwd" required>
					  </div>
						<p class=" font-italic">for new students <span class="text-primary" id="registrationBtn" data-toggle="modal" data-target="#myModal">Click here</span> to registraion</p>
					  <button type="submit" class="btn btn-primary btn-lg rounded-pill w-50" name="submit" value="signIn">Sign In</button>
					</form>

				</div>
			</div>
			<div class="col-lg-7" id="quoteBg">
				<div class="text-white w-75 m-auto text-center" style="padding-top:150px;padding-bottom:150px;">
					<h1>Exam Management System</h1>
					<h1 class="mt-3"> <q cite=""> Integrity is the foundation upon which all other values are built. (Brian Tracy) </q> </h1>
				</div>
			</div>
	</div>
	</div>
	</section>
	<!-- The Modal -->
	<div class="modal" id="myModal">
	  <div class="modal-dialog">
	    <div class="modal-content">

	      <!-- Modal Header -->
	      <div class="modal-header">
	        <h4 class="modal-title">Student Details</h4>
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>

	      <!-- Modal body -->
	      <div class="modal-body">
					<div class="container">
						<span id="stdError"></span>
						<form action="" method="POST" onsubmit="return getAddStdValid()" enctype="multipart/form-data">
				  <div class="form-row">
					  	<div class="form-group col-md-6">
					      <label for="stdName">Name</label>
					      <input type="text" class="form-control" id="stdName" name="stdName" placeholder="Name*" autocomplete="off" required>
					    </div>
					    <div class="form-group col-md-6">
					      <label for="stdLastName">Last Name</label>
					      <input type="text" class="form-control" id="stdLastName" name="stdLastName" placeholder="last name*" autocomplete="off" required>
					    </div>
				  </div>
				   <div class="form-row">
					    <div class="form-group col-md-6">
					      <label for="stdEmail">Email</label>
					      <input type="email" class="form-control" id="stdEmail" name="stdEmail" placeholder="Email*" autocomplete="off" required>
					    </div>
					    <div class="form-group col-md-6">
					      <label for="stdPassword">Password</label>
					      <input type="password" class="form-control" id="stdPassword" name="stdPassword" placeholder="Password*" autocomplete="off" required>
					    </div>
				  </div>
				  <div class="form-group">
				    <label for="stdAddress">Address</label>
				    <input type="text" class="form-control" id="stdAddress" name="stdAddress" placeholder="1234 Main St" autocomplete="off" required>
				  </div>

				  <div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="stdQual">Qualification</label>
				      <input type="text" class="form-control" id="stdQual" name="stdQual" autocomplete="off" required>
				    </div>
				    <div class="form-group col-md-6">
				      <label for="stdState">State</label>
				      <select id="stdState" name="stdState" class="form-control">
				        <option selected value="select">select</option>
				        <option value="Punjab">Punjab</option>
				        <option value="Sindh">Sindh</option>
				        <option value="KPK">KPK</option>
				        <option value="Balochistan">Balochistan</option>
				      </select>
				    </div>
				  </div>
					<div class="row">
						<div class="form-group col-md-6">
							<input type="number" class="form-control" name="stdContact" id="stdContact" placeholder="923xxx" autocomplete="off" required>
						</div>
					  <div class="custom-file col-md-6">
					    <input type="file" class="custom-file-input" id="customFile" name="image">
					    <label class="custom-file-label" for="customFile" id="imageLabel">Choose file</label>
					  </div>
					</div>
				  <div class="text-right mt-3">
				   <button type="submit" class="btn btn-success mb-2 px-5" id="addStdBtn" value="addStd" name="submit"><i class="far fa-plus-circle"></i> Submit</button>
				  </div>
				</form>
				</div>
	      </div>

	    </div>
	  </div>
	</div>
	<!-- Footer -->
	<footer class="page-footer font-small"  style="background-color: #f2eeed;">

	  <!-- Copyright -->
	  <div class="footer-copyright text-center py-3">© 2020 Copyright all rights are reserved by :
	    <a href="">CodeSolution</a>
	  </div>
	  <!-- Copyright -->

	</footer>
	<!-- Footer -->

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="Js/functions.js"></script>
<script src="Js/jquerry.js"></script>
</body>
</html>
