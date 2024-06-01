<div class="container mb-3">
	<div class="row justify-content-around">
		<div class="col-md-4 shadow-lg p-5 bg-white">
			<?php	echo '
			    		<img src="data:image/jpeg;base64,'.base64_encode($_SESSION['actorData']['image']).'" width="500px" style="height:250px;" class="img-fluid rounded-circle "/>
								';	?>
			<h4 class="text-center pt-4"><?php echo ucwords(strtolower($_SESSION['actorData']["name"]))." ".ucwords(strtolower($_SESSION['actorData']["last_name"])); ?></h4>
			<p class="text-center"><?php echo strtolower($_SESSION['actorData']["user_name"]); ?></p>
		</div>
		<div class="col-md-7 shadow-lg p-0 bg-white mt-3 mt-md-0">
		  <h3 class="p-4 bg-purple text-white"><i class="fas fa-user-lock"></i> </i>Personal Info</h3>
			<div class="container my-5">
        <table class="table table-hover table-striped table-bordered">
          <tr>
            <td class="text-right">Last Qualification:</td>
            <td class="text-left"><?php echo $_SESSION['actorData']['qualification']; ?></td>
          </tr>
          <tr>
            <td class="text-right">Contact:</td>
            <td class="text-left"><?php echo $_SESSION['actorData']['contact']; ?></td>
          </tr>
          <tr>
            <td class="text-right">State:</td>
            <td class="text-left"><?php echo $_SESSION['actorData']['state']; ?></td>
          </tr>
          <tr>
            <td class="text-right">Address:</td>
            <td class="text-left"><?php echo $_SESSION['actorData']['address']; ?></td>
          </tr>
        </table>
      </div>
		</div>
	</div>
</div>