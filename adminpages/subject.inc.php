<?php
		require_once("business/subject_handler.php");
		require_once("business/utilities.php");
?>
<div class="container bg-white py-3">
		<ul class="nav nav-tabs" style="border: none;">
		  <li class="nav-item">
		    <a class="nav-link" href="?pageName=subject&tab=adSt" id="addSubBtn"><i class="far fa-plus-circle text-success"></i> Add Subject</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="?pageName=subject&tab=delSt" id="delSubBtn"><i class="fal fa-trash-alt text-danger"></i> Delete Subject</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="?pageName=subject&tab=asSt" id="assignSubBtn"><i class="fab fa-app-store"></i> Assign Subject</a>
		  </li>
		</ul>

			<?php
				if(isset($_GET['tab'])){
					checkPost();
					if ($_GET['tab']=="adSt"){
						getActiveTab("addSubBtn");
						echo addSubjectHTML();
					}else if ($_GET['tab']=="delSt"){
						getActiveTab("delSubBtn");
						echo delStudentHTML();
					}else if ($_GET['tab']=="asSt"){
						getActiveTab("assignSubBtn");
						assignSubjectHTML();
					}
				}
			?>

		</div>


	<?php
		function addSubjectHTML(){
		?>
		<div class="container border p-5">
				<h2 class="pb-2">Add Subject</h2>
				<form class="form-inline" action="?pageName=subject&tab=adSt" method="POST" onsubmit="return getAddSubjectValidation()">
					<div class="form-group">
						<label for="subCode" class="mr-sm-2">Subject Code:</label>
						<input type="text" class="form-control mb-2 mr-sm-2" placeholder="subject code*" id="subCode" name="subCode" autocomplete="off">
					</div>
				<div class="form-group">
				  <label for="subName" class="mr-sm-2">Subject Name:</label>
				  <input type="text" class="form-control mb-2 mr-sm-2" placeholder="subject name*" id="subName" name="subName" autocomplete="off">
				</div>

				  <button type="submit" class="btn btn-success mb-2 px-5" value="add" name="submit"><i class="far fa-plus-circle"></i> Add</button>
				</form>
			</div>
	<?php
		}
	 ?>
	 <?php
		function delStudentHTML(){
		?>
		<div class="container border py-5 px-lg-5">
				<h2 class="pb-2">Search Subject</h2>
				<form class="form-inline" action="?pageName=subject&tab=delSt" method="POST" onsubmit="return getSearchSubValidation()">
				  <label for="searchSubCode" class="mr-sm-2">Subject Code:</label>
				  <input type="text" class="form-control mb-2 mr-sm-2" placeholder="subject code" name="searchSubCode" id="searchSubCode" autocomplete="off" required>
				  <button type="submit" class="btn btn-danger mb-2 px-5" name="submit" value="search"><i class="fal fa-file-search"></i> Search</button>
				</form>
				<table class="table table-hover table-striped text-center table-bordered mt-3 text-wrap">
					<thead>
						<tr class="text-white" style="background-color: #9a57f2;">
							<th>Subject Code</th>
							<th>Subject Name</th>
							<th>Assigned To</th>
							<th>Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<?php
						if(isset($GLOBALS['searchSubjectTable']) && !$GLOBALS['searchSubjectTable']==false){ ?>
							<tbody>
								<tr>
									<td><?php echo $GLOBALS['searchSubjectTable']['subject_code']; ?></td>
									<td><?php echo $GLOBALS['searchSubjectTable']['subject_name']; ?></td>
									<td><?php echo $GLOBALS['searchSubjectTable']['assigned_to']; ?></td>
									<td><?php echo $GLOBALS['searchSubjectTable']['date']; ?></td>
									<td><button class="btn btn-warning" id="updateSubject">Update</button>
										<?php getPopUpModel(); ?>
									</td>
								</tr>
							</tbody>
							</table>
						<?php }else {
							echo '</table> <div class="text-center bg-light">
									<span>Record not found</span>
								</div>';
						}
					?>

				<form class="form-inline mt-5" action="?pageName=subject&tab=delSt&id=<?php echo $GLOBALS['searchSubjectTable']['subject_code']; ?>" id="reEntersubjectForm" method="POST" onsubmit="return getAddSubjectValidation()">
					<div class="form-group">
						<label for="subCode" class="mr-sm-2">ReEnter code:</label>
						<input type="text" class="form-control mb-2 mr-sm-2" placeholder="subject code" id="subCode" name="reSubCode" autocomplete="off">
						</div>
					<div class="form-group">
				  <label for="subName" class="mr-sm-2">ReEnter Name:</label>
				  <input type="text" class="form-control mb-2 mr-sm-2" placeholder="subject name" id="subName" name="reSubName" autocomplete="off">
				</div>

				  <button type="submit" class="btn btn-success mb-2 px-5" name="submit" value="readd"><i class="fad fa-check"></i> Confirm</button>
				</form>
			</div>
	<?php
		}
	 ?>

<?php
	function checkPost(){
		if (isset($_POST['submit'])){
				if($_POST['submit']=="add") {
					addSubject($_POST['subCode'],$_POST['subName']);
				} else if($_POST['submit']=="search"){
					$GLOBALS['searchSubjectTable']=searchSubject($_POST['searchSubCode']);
					if ($GLOBALS['searchSubjectTable']==false) {
						printErrorMsg("record not found, please write valid subject name.",false);
					}
				}else if($_POST['submit']=="readd"){
					updateSubject($_GET['id'],$_POST['reSubCode'],$_POST['reSubName']);
				}else if($_POST['submit']=="Delete"){
						deleteSubject($_GET['id']);
				}else if($_POST['submit']=="assign"){
						assignSubToTchr();
				}else if ($_POST['submit']=="unassign"){
					unassignSub();
				}
		}
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
			        <p class="font-weight-normal">are you sure to delete subject permanently from the database ?</p>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
			        <form method="POST" action="?pageName=subject&tab=delSt&id=<?php echo $GLOBALS['searchSubjectTable']['subject_code']; ?>">
			        	<input type="submit" name="submit" value="Delete" class="btn btn-danger">
			        </form>
			      </div>
			    </div>
			  </div>
			</div>
	<?php }
?>
<?php
	function assignSubjectHTML(){
				 $data=getAssignData();
				  $subjectArray=$data[0];
				 $tchrArray=$data[1];
				 $assignedSubject=$data[2];
		?>
		<div class="container border py-5 px-lg-5">
				<h2 class="text-center">Assign Subject </h2>
			<form class="w-75 m-auto" method="POST" action="?pageName=subject&tab=asSt" onsubmit="return getAssignSubjectValidation()">
				<div class="form-group">
				  <label for="subjectAssigned">Select Subject:</label>
				  <select class="form-control" id="subjectAssigned" name="subCodeToAssign">
				    <option>select</option>
				    <?php
				   		for ($i=0;$i<count($subjectArray);$i++) { ?>
				   			<option value="<?php echo $subjectArray[$i]['subject_code']; ?>"><?php echo $subjectArray[$i]['subject_code']; ?></option>
				   		<?php }
				   	?>
				  </select>
				</div>
				<div class="form-group">
				  <label for="teacherAssigned">Select Teacher:</label>
				  <select class="form-control" id="teacherAssigned" name="emailToAssign">
				    <option>select</option>
				   	<?php
				   		for ($i=0;$i<count($tchrArray);$i++) { ?>
				   			<option value="<?php echo $tchrArray[$i]['user_name']; ?>"><?php echo $tchrArray[$i]['user_name']; ?></option>
				   		<?php }
				   	?>
				  </select>
				</div>
				<div class="text-right">
					<button type="submit" class="btn btn-success mb-2 px-5" name="submit" value="assign"><i class="fad fa-equals"></i> Assign</button>
				</div>
			</form>
			<h2 class="text-center">Unassign Subject </h2>
			<form class="w-75 m-auto" method="POST" action="?pageName=subject&tab=asSt" onsubmit="return getUnassignSubjectValidation()">
				<div class="form-group">
				  <label for="subjectUnassigned">Select Subject:</label>
				  <select class="form-control" id="subjectUnassigned" name="subCodeToUnssign">
				    <option>select</option>
				    <?php
				   		for ($i=0;$i<count($assignedSubject);$i++) { ?>
				   			<option value="<?php echo $assignedSubject[$i]['subject_code']; ?>"><?php echo $assignedSubject[$i]['subject_code']; ?></option>
				   		<?php }
				   	?>
				  </select>
				</div>
				<div class="text-right">
					<button type="submit" class="btn btn-success mb-2 px-5" name="submit" value="unassign"><i class="far fa-not-equal"></i> Unassign</button>
				</div>
			</form>
		</div>
	<?php }
?>
