<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
					<!-- <a class="navbar-brand" href="#"></a> -->
					<a class="navbar-brand ml-3" href="#"><img src="image/logo.png" class="img-fluid" alt="..." width="80px"> Exam Management System</a>
				  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				  </button>
				  <div class="collapse navbar-collapse" id="navbarNav">
				  	<ul class="navbar-nav ml-auto">
				  			<li class="nav-item">
					        <a class="nav-link" href="?pageName=announcement"><i class="far fa-bell text-white btn-lg"></i></a>
					      </li>
					    </ul>
				  	<ul class="navbar-nav">
					      <li class="nav-item">
					        <a class="nav-link" href="?pageName=profile">
										<span><?php echo ucwords(strtolower($_SESSION['actorData']["name"]))." ".ucwords(strtolower($_SESSION['actorData']["last_name"]));
										
										
										?></span>
										<span>
												<?php	echo '
									    		<img src="data:image/jpeg;base64,'.base64_encode($_SESSION['actorData']['image']).'" width="50px" style="height:50px;" class="img-fluid rounded-circle "/>
														';	?>
										</span>
					        </a>
					      </li>

					    </ul>
				    <ul class="navbar-nav mr-5">
					    	<li class="nav-item">
					        <a class="nav-link" href="logout.php"><i class="far fa-power-off"></i> LogOut</a>
					      </li>
					    </ul>
				  </div>
				</nav>
