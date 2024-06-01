<?php
		require_once("business/teacher_handler.php");
		require_once("business/utilities.php");
?>
<div class="container bg-white py-3">
		<ul class="nav nav-tabs" style="border: none;">
		  <li class="nav-item">
		    <a class="nav-link" href="?pageName=teacher&tab=adTchr" id="addTchrTab"><i class="far fa-plus-circle text-success"></i> Add Teacher</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="?pageName=teacher&tab=upTchr" id="upTchrBtn"><i class="fal fa-trash-alt text-danger"></i> Update Teacher</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="?pageName=teacher&tab=vwTchr" id="vwTchrBtn"><i class="fal fa-eye text-success"></i> View Teacher</a>
		  </li>

		</ul>

			<?php
				if(isset($_GET['tab'])){
					checkPost();
					if ($_GET['tab']=="adTchr"){
						getActiveTab("addTchrTab");
						echo addTeacherHTML();
					}else if ($_GET['tab']=="upTchr"){
						getActiveTab("upTchrBtn");
						echo updateTchrHTML();
					}else if ($_GET['tab']=="ssTchr"){
						getActiveTab("searchTchrBtn");
					}else if ($_GET['tab']=="vwTchr"){
						getActiveTab("vwTchrBtn");
						echo viewTchrHTML(getTeachers());
					}
				}
			?>

		</div>

<?php
	function checkPost()
	{
		if (isset($_POST['submit'])){
				if($_POST['submit']=="add") {
					addTeacher();
				} else if($_POST['submit']=="search"){
					$GLOBALS['searchTeacherTable']=searchTeacher($_POST['searchTchrEmail']);
					if ($GLOBALS['searchTeacherTable']==false) {
						printErrorMsg("record not found, please write valid teacher email.",false);
					}
				}else if($_POST['submit']=="update"){
					updateTeacher();
				}else if($_POST['submit']=="Delete"){
						deleteTeacher();
				}
		}
	}
?>

<?php
	function addTeacherHTML()
	{ ?>
	<div class="container border p-5">
		<h2 class="pb-2">Add Teacher</h2>
		<form action="?pageName=teacher&tab=adTchr" method="POST" onsubmit="return getAddTchrValid()" 
		enctype="multipart/form-data">
  <div class="form-row">
	  	<div class="form-group col-md-6">
	      <label for="tchrName">Name</label>
	      <input type="text" class="form-control" id="tchrName" name="tchrName" placeholder="Name*" autocomplete="off" required>
	    </div>
	    <div class="form-group col-md-6">
	      <label for="tchrLastName">Last Name</label>
	      <input type="text" class="form-control" id="tchrLastName" name="tchrLastName" placeholder="last name*" autocomplete="off" required>
	    </div>
  </div>
   <div class="form-row">
	    <div class="form-group col-md-6">
	      <label for="tchrEmail">Email</label>
	      <input type="email" class="form-control" id="tchrEmail" name="tchrEmail" placeholder="Email*" autocomplete="off" required>
	    </div>
	    <div class="form-group col-md-6">
	      <label for="tchrPassword">Password</label>
	      <input type="password" class="form-control" id="tchrPassword" name="tchrPassword" placeholder="Password*" autocomplete="off" required>
	    </div>
  </div>
  <div class="form-group">
    <label for="tchrAddress">Address</label>
    <input type="text" class="form-control" id="tchrAddress" name="tchrAddress" placeholder="1234 Main St" autocomplete="off" required>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="tchrQual">Qualification</label>
      <input type="text" class="form-control" id="tchrQual" name="tchrQual" autocomplete="off" required>
    </div>
    <div class="form-group col-md-4">
      <label for="tchrState">State</label>
      <select id="tchrState" name="tchrState" class="form-control">
        <option selected value="select">select</option>
        <option value="Punjab">Punjab</option>
        <option value="Sindh">Sindh</option>
        <option value="KPK">KPK</option>
        <option value="Balochistan">Balochistan</option>
      </select>
    </div>
    <div class="form-group col-md-2">
      <label for="tchrContact">Contact</label>
      <input type="number" class="form-control" name="tchrContact" id="tchrContact" placeholder="923xxx" autocomplete="off" required>
    </div>
  </div>
  <div class="custom-file col-md-6">
    <input type="file" class="custom-file-input" id="customFile" name="image">
    <label class="custom-file-label" for="customFile" id="imageLabel">Choose file</label>
  </div>
  <div class="text-right mt-3">
   <button type="submit" class="btn btn-success mb-2 px-5" id="addTchrBtn" value="add" name="submit"><i class="far fa-plus-circle"></i> Add</button>
  </div>
</form>
</div>
	<?php }
?>

<?php
		function updateTchrHTML(){
		?>
		<div class="container border py-5 px-lg-5">
				<h2 class="pb-2">Search Teacher</h2>
				<form class="form-inline" action="?pageName=teacher&tab=upTchr" method="POST">
				  <label for="searchTchrEmail" class="mr-sm-2">Teacher Email:</label>
				  <input type="email" class="form-control mb-2 mr-sm-2" placeholder="teacher email" name="searchTchrEmail" id="searchTchrEmail" autocomplete="off" required>
				  <button type="submit" class="btn btn-danger mb-2 px-5" name="submit" value="search"><i class="fal fa-file-search"></i> Search</button>
				</form>
				<table class="table table-hover table-striped text-center table-bordered mt-3">
					<thead>
						<tr class="text-white" style="background-color: #9a57f2;">
							<th>Email</th>
							<th>Name</th>
							<th>contact</th>
							<th>date</th>
							<th>view</th>
							<th>Action</th>
						</tr>
					</thead>
					<?php
						if(isset($GLOBALS['searchTeacherTable']) && !$GLOBALS['searchTeacherTable']==false){ ?>
							<tbody>
								<tr>
									<td class="text-wrap"><?php echo $GLOBALS['searchTeacherTable']['user_name']; ?></td>
									<td class="text-wrap"><?php echo $GLOBALS['searchTeacherTable']['name'].' '.$GLOBALS['searchTeacherTable']['last_name']; ?></td>
									<td class="text-wrap"><?php echo $GLOBALS['searchTeacherTable']['contact']; ?></td>
									<td class="text-wrap"><?php echo $GLOBALS['searchTeacherTable']['date']; ?></td>
									<td><?php
									// echo $GLOBALS['searchTeacherTable']['image'];
									echo '<img src="data:image/jpeg;base64,'.base64_encode($GLOBALS['searchTeacherTable']['image']).'"  style="width:100px; height:inherit;" />'; ?>

									</td>
									<td><button class="btn btn-warning" id="updateTeacher">Update</button>
										<?php
										getPopUpModel();
										 ?>
									</td>
								</tr>
							</tbody>
							</table>


						<form action="?pageName=teacher&tab=upTchr" method="POST" enctype="multipart/form-data" id="updateTchrForm" onsubmit="return getTeacherStateValidation()">
				<h2 class="py-2">Update Teacher</h2>

							<input type="hidden" name="id" value="<?php echo $GLOBALS['searchTeacherTable']['user_name']; ?>">
				  <div class="form-row">
					  	<div class="form-group col-md-6">
					      <label for="tchrName">Name</label>
					      <input type="text" class="form-control" id="tchrName" name="tchrName" placeholder="Name*" autocomplete="off" value="<?php echo $GLOBALS['searchTeacherTable']['name']; ?>">
					    </div>
					    <div class="form-group col-md-6">
					      <label for="tchrLastName">Last Name</label>
					      <input type="text" class="form-control" id="tchrLastName" name="tchrLastName" placeholder="last name*" autocomplete="off" value="<?php echo $GLOBALS['searchTeacherTable']['last_name']; ?>">
					    </div>
				  </div>
				   <div class="form-row">
					    <div class="form-group col-md-6">
					      <label for="tchrEmail">Email</label>
					      <input type="email" class="form-control" id="tchrEmail" name="tchrEmail" placeholder="Email*" autocomplete="off" value="<?php echo $GLOBALS['searchTeacherTable']['user_name']; ?>">
					    </div>
					    <div class="form-group col-md-6">
					      <label for="tchrPassword">Password</label>
					      <input type="password" class="form-control" id="tchrPassword" name="tchrPassword" placeholder="Password*" autocomplete="off" value="<?php echo $GLOBALS['searchTeacherTable']['password']; ?>">
					    </div>
				  </div>
				  <div class="form-group">
				    <label for="tchrAddress">Address</label>
				    <input type="text" class="form-control" id="tchrAddress" name="tchrAddress" placeholder="1234 Main St" autocomplete="off" value="<?php echo $GLOBALS['searchTeacherTable']['address']; ?>">
				  </div>

				  <div class="form-row">
				    <div class="form-group col-md-6">
				      <label for="tchrQual">Qualification</label>
				      <input type="text" class="form-control" id="tchrQual" name="tchrQual" autocomplete="off" value="<?php echo $GLOBALS['searchTeacherTable']['qualification']; ?>">
				    </div>
				    <div class="form-group col-md-4">
				      <label for="tchrState">State</label>
				      <select id="tchrState" name="tchrState" class="form-control">

				        <option <?php if($GLOBALS['searchTeacherTable']['state']=="SELECT") echo "selected"; ?> value="select">select</option>
				        <option <?php if($GLOBALS['searchTeacherTable']['state']=="PUNJAB") echo "selected"; ?> value="Punjab">Punjab</option>
				        <option <?php if($GLOBALS['searchTeacherTable']['state']=="SINDH") echo "selected"; ?> value="Sindh">Sindh</option>
				        <option <?php if($GLOBALS['searchTeacherTable']['state']=="KPK") echo "selected"; ?> value="KPK">KPK</option>
				        <option <?php if($GLOBALS['searchTeacherTable']['state']=="BALOCHISTAN") echo "selected"; ?> value="Balochistan">Balochistan</option>
				      </select>
				    </div>
				    <div class="form-group col-md-2">
				      <label for="tchrContact">Contact</label>
				      <input type="number" class="form-control" name="tchrContact" id="tchrContact" placeholder="923xxx" autocomplete="off" value="<?php echo $GLOBALS['searchTeacherTable']['contact']; ?>">
				    </div>
				  </div>
				  <div class="custom-file col-md-6">
				    <input type="file" class="custom-file-input" id="customFile" name="image">
				    <label class="custom-file-label" for="customFile" id="imageLabel">Choose file</label>
				  </div>
				  <div class="text-right mt-3">
				   <button type="submit" class="btn btn-success mb-2 px-5" id="addTchrBtn" value="update" name="submit"><i class="fad fa-check"></i> Confirm</button>
				  </div>
				</form>
			</div>
			<?php }else {
							echo '</table> <div class="text-center bg-light">
									<span>Record not found</span>
								</div>';
						}
					?>
	<?php
		}
	 ?>

	 <?php
	function getPopUpModel(){ ?>
		<!-- Button trigger modal -->
			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">
			  Delete
			</button>

			<!-- Modal -->
			<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title text-danger" id="exampleModalLongTitle"><i class="fal fa-exclamation-triangle"></i> Alert</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <p class="font-weight-normal">are you sure to delete teacher permanently from the database ?</p>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
			        <form method="POST" action="?pageName=teacher&tab=upTchr">
			        	<input type="hidden" name="id" value="<?php echo $GLOBALS['searchTeacherTable']['email']; ?>">
			        	<input type="submit" name="submit" value="Delete" class="btn btn-danger">
			        </form>
			      </div>
			    </div>
			  </div>
			</div>
	<?php }
?>
<?php
		function viewTchrHTML($tchr){
		?>
		<div class="container border py-5 px-lg-5">
           <h3 class="p-4 bg-purple text-white"><i class="far fa-file-check"></i> View Teachers</h3>
           <div class="container">
				<table class="table table-hover table-striped text-center table-bordered">
					<thead>
						<tr class="text-white" style="background-color: #9a57f2;">
							<th>Sr.#</th>
							<th>User Name</th>
							<th>Name</th>
							<th>contact</th>
							<th>date</th>
							<th>view</th>
						</tr>
					</thead>
					<?php
						if(!empty($tchr)){ ?>
							<tbody>
							<?php for ($i=0; $i<count($tchr); $i++) { 
            					?>
								<tr>
									<td class="text-wrap"><?php echo $i+1; ?></td>
									<td class="text-wrap"><?php echo $tchr[$i]['user_name']; ?></td>
									<td class="text-wrap"><?php echo $tchr[$i]['name'].' '.$tchr[$i]['last_name']; ?></td>
									<td class="text-wrap"><?php echo $tchr[$i]['contact']; ?></td>
									<td class="text-wrap"><?php echo $tchr[$i]['date']; ?></td>
									<td><?php
									echo '<img src="data:image/jpeg;base64,'.base64_encode($tchr[$i]['image']).'"  style="width:100px;" />'; ?>

									</td>
								</tr>
              				<?php } ?>
							
							</tbody>
							</table>
		               </div>
						<?php }else
							 echo '</table></div> <div class="text-center bg-light">
				                    <span>Record not found</span>
				                  </div>';
						 ?>
						
			</div>
			
<?php
	}
?>
