<?php
		require_once("business/announcement_handler.php");
		require_once("business/utilities.php");
?>
<div class="container bg-white py-3">
		<ul class="nav nav-tabs" style="border: none;">
		  <li class="nav-item">
		    <a class="nav-link" href="?pageName=notification&tab=anounce" id="anounceTab"><i class="far fa-bullhorn text-danger"></i> Announcement</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="?pageName=notification&tab=result" id="resultTab"><i class="far fa-poll text-warning"></i> Result</a>
		  </li>
		</ul>

			<?php
				if(isset($_GET['tab'])){
					checkPost();
					if ($_GET['tab']=="anounce"){
						getActiveTab("anounceTab");
					  addAnnounceHTML();
					}else if ($_GET['tab']=="result"){
						getActiveTab("resultTab");
						addResultHTML();
					}
				}
			?>

		</div>
		<?php
			function checkPost(){
				if (isset($_POST['submit'])){
						if($_POST['submit']=="addAnnouncement") {
							addAnnouncement();
						}else if($_POST['submit']=="updateAnnouncement"){
							updateAnnouncement();
						}else if($_POST['submit']=="deleteAnnouncement"){
							deleteAnnouncement();
						}else if($_POST['submit']=="declareResult"){
							updateResult("true");
						}else if($_POST['submit']=="deleteResult"){
							updateResult("false");
						}

				}
			}
		?>
    <?php
      function addAnnounceHTML(){
      ?>
      <div class="container border p-5">
        <div class="container shadow-lg p-0">
          <h3 class="p-4 bg-purple text-white"><i class="far fa-folder-plus"></i> Create Announcement</h3>
					<form class="p-5" action="?pageName=notification&tab=anounce" method="POST" onsubmit="return addNoti()">
						<div class="row">
							<div class="col-md-8 form-group">
								<label for="announcementTitle" class="mr-sm-2">Title:</label>
								<input type="text" class="form-control" placeholder="title*" name="announcementTitle" id="announcementTitle" autocomplete="off" required>
							</div>
							<div class="col-md-4">
								<label for="announcementDate" class="mr-sm-2">Date:</label>
								<input type="date" class="form-control"  id="announcementDate" name="announcementDate" autocomplete="off" required>
							</div>
						</div>
						<div class="form-group">
							<label for="announcementDetail" class="mr-sm-2">Description:</label>
							<textarea name="announcementDetail" rows="3" class="form-control" id="announcementDetail" placeholder="type description (only 300 words)*" required></textarea>
						</div>
						<div class="text-right">
							<button type="submit" class="btn btn-success mb-2 px-5" value="addAnnouncement" name="submit"><i class="far fa-plus-circle"></i> Add</button>
						</div>
					</form>
        </div>
				<!-- second box -->
				<div class="container shadow-lg p-0 mt-5">
          <h3 class="p-4 bg-purple text-white"><i class="far fa-file-check"></i> Update Announcement</h3>
					<form class="form-inline px-5 pt-5" action="?pageName=notification&tab=anounce" method="POST" onsubmit="return srchNoti()">
            <div class="form-group">
							<label for="searchAnnouncementTitle" class="mr-sm-2">Title:</label>
							<input type="text" class="form-control mr-sm-2" placeholder="type title*" id="searchAnnouncementTitle" name="searchAnnouncementTitle" autocomplete="off">
            </div>
            <button type="submit" class="btn btn-info" name="submit" value="searchAnnouncement"><i class="fal fa-file-search"></i> Search</button>
          </form>
					<?php if(isset($_POST['submit']) && $_POST['submit']=="searchAnnouncement"){
									$announcement=getAnnouncementOf();
							}
					?>
					<form class="p-5" action="" method="POST" onsubmit="return upNoti()">
						<input type="hidden" name="announcementId" value="<?php if(!empty($announcement)) echo $announcement["id"];?>">
						<div class="row">
							<div class="col-md-8 form-group">
								<label for="updateAnnouncementTitle" class="mr-sm-2">Title:</label>
								<input type="text" class="form-control" placeholder="type title*" id="updateAnnouncementTitle" name="updateAnnouncementTitle" autocomplete="off" disabled
								value="<?php if(!empty($announcement)) echo $announcement["title"];?>">
							</div>
							<div class="col-md-4">
								<label for="updateAnnouncementDate" class="mr-sm-2">Date:</label>
								<input type="date" class="form-control"  id="updateAnnouncementDate" name="updateAnnouncementDate" autocomplete="off" disabled
								value="<?php if(!empty($announcement)) echo $announcement["date"];?>">
							</div>
						</div>
						<div class="form-group">
							<label for="updateAnnouncementDetail" class="mr-sm-2">Description:</label>
							<textarea name="updateAnnouncementDetail" id="updateAnnouncementDetail" rows="3" class="form-control" placeholder="type question statement*" disabled
							><?php if(!empty($announcement)) echo $announcement["description"];?></textarea>
						</div>
						<button type="button" class="btn btn-warning mb-2 px-5" id="updateAnnounceEditBtn"
						<?php if(empty($announcement)) echo "disabled"?> ><i class="fad fa-edit"></i> Edit</button>
						<button type="submit" class="btn btn-primary mb-2 px-5" name="submit" id="updateAnnouncement" value="updateAnnouncement"
						disabled ><i class="far fa-file-check"></i> Update</button>
						<button type="submit" class="btn btn-danger mb-2 px-5" name="submit" value="deleteAnnouncement"
						<?php if(empty($announcement)) echo "disabled"?> id="deleteAnnouncement"><i class="fal fa-trash-alt"></i> Delete</button>
					</form>
        </div>
      </div>
      <?php
        }
       ?>

			 <?php
			 	function addResultHTML(){
			 	?>
				<div class="container border p-5">
	        <div class="container shadow-lg p-0">
	          <h3 class="p-4 bg-purple text-white"><i class="far fa-folder-plus"></i> Declare Result</h3>
						<form class="p-5" action="" method="POST" onsubmit="return decResult()">
							<div class="row">
								<div class="col-md-6 form-group">
									<label for="resultSubCode" class="mr-sm-2">Subject:</label>
									<select class="form-control patternSubCode" name="resultSubCode" id="resultSubCode">
										<option value="select">select</option>
										<?php
							                $rawArray=getAssignSubjects();
							                for($i=0;$i<count($rawArray);$i++){ ?>
							                  <option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
							              <?php }
							                ?>
									</select>
								</div>
								<div class="col-md-6 form-group">
									<label for="resultTerm" class="mr-sm-2">Term:</label>
									<select class="form-control patternTerm" name="resultTerm" id="resultTerm">
										<option value="select">select</option>
									</select>
								</div>
								
							</div>
							<div class="text-right">
								<button type="submit" class="btn btn-success mb-2 px-5" value="declareResult" name="submit"><i class="far fa-plus-circle"></i> Declare</button>
							</div>
						</form>
					</div>
					<!-- second box -->
					<div class="container shadow-lg p-0 mt-5">
						<h3 class="p-4 bg-purple text-white"><i class="far fa-file-check"></i> Update Result Declaration</h3>
						
						<form class="p-5" action="" method="POST" onsubmit="return unDecResult()">
							<div class="row">
								<div class="col-md-6 form-group">
									<label for="updateResultSubCode" class="mr-sm-2">Subject:</label>
									<select class="form-control patternSubCode" name="resultSubCode" id="updateResultSubCode">
										<option value="select">select</option>
										<?php
							                $rawArray=getAssignSubjects();
							                for($i=0;$i<count($rawArray);$i++){ ?>
							                  <option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
							              <?php }
							                ?>
									</select>
								</div>
								<div class="col-md-6 form-group">
									<label for="updateResultTerm" class="mr-sm-2">Term:</label>
									<select class="form-control patternTerm" name="resultTerm" id="updateResultTerm">
										<option value="select">select</option>
									</select>
								</div>
								
							</div>
							<div class="text-right">
								<button type="submit" class="btn btn-danger mb-2 px-5" value="deleteResult" name="submit"><i class="fal fa-trash-alt"></i> Undeclare</button>
							</div>
						</form>
					</div>
				</div>
				<?php
					}
				 ?>
