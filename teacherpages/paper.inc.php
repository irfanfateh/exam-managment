<?php
		require_once("business/paper_handler.php");
		require_once("business/utilities.php");
?>
<div class="container bg-white py-3">
		<ul class="nav nav-tabs" style="border: none;">
		  <li class="nav-item">
		    <a class="nav-link" href="?pageName=paper&tab=make" id="makePaper"><i class="far fa-layer-plus"></i> Make paper</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="?pageName=paper&tab=view" id="viewPaper"><i class="fal fa-eye text-success"></i> Students Appearance</a>
		  </li>
      <li class="nav-item">
       <a class="nav-link" href="?pageName=paper&tab=check" id="chkPaper"><i class="far fa-highlighter text-warning"></i> Check Paper</a>
     </li>
		</ul>

			<?php
				if(isset($_GET['tab'])){
					checkPost();
					if ($_GET['tab']=="make"){
						getActiveTab("makePaper");
					  addMakePaperHTML();
					}else if ($_GET['tab']=="view"){
						getActiveTab("viewPaper");
            if(isset($_POST['id'])){
              deleteAttendance();
            }
						addViewPaperHTML();
					}else if ($_GET['tab']=="check"){
						getActiveTab("chkPaper");
						addCheckPaperHTML();
					}
				}
			?>

		</div>
    <?php
          function checkPost(){
            if (isset($_POST['submit'])){
                if($_POST['submit']=="add") {
                  addPaper();
                }else if($_POST['submit']=="updatePattern"){
                  updatePattern();
                }else if($_POST['submit']=="deletePattern"){
                    deletePattern();
                }else if($_POST['submit']=="checkedPaper"){
                    checkedPaper();
                }
            }


          }
        ?>
    <?php
      function addMakePaperHTML(){
      ?>
      <div class="container border p-5">
        <div class="container shadow-lg p-0">
          <h3 class="p-4 bg-purple text-white"><i class="far fa-folder-plus"></i> Create Paper</h3>
          <form class="p-5" action="?pageName=paper&tab=make" method="POST" onsubmit="return pattern()">
            <div class="row">
              
              <div class="col-md-3 form-group">
                 <label for="subCode" class="mr-sm-2">Subject Code::</label>
                <select class="form-control mb-2 mr-sm-2" id="subCode" name="subCode">
                <option value="select">select</option>
                <?php
                $rawArray=getAssignSubjects();
                for($i=0;$i<count($rawArray);$i++){ ?>
                  <option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
              <?php }
                ?>
              </select>
              </div>

              <div class="col-md-3 form-group">
                <label for="paperTerm" class="mr-sm-2">Term:</label>
                <input type="text" class="form-control"  id="paperTerm" name="paperTerm" autocomplete="off" required>
              </div>

              <div class="col-md-3 form-group">
                <label for="paperOpDate" class="mr-sm-2">Open Date:</label>
                <input type="date" name="paperOpDate" id="paperOpDate" class="form-control" required>
              </div>
              <div class="col-md-3 form-group">
                <label for="paperLDate" class="mr-sm-2">Last Date:</label>
                <input type="date" name="paperLDate" id="paperLDate" class="form-control" required>
              </div>
            </div>

            <div class="row">
              <div class="col-md-2 form-group">
                <label for="paperTMarks" class="mr-sm-2">Total Marks:</label>
                <input type="number" class="form-control"  id="paperTMarks" min="1" name="paperTMarks" autocomplete="off" required>
              </div>
              <div class="col-md-2 form-group">
                <label for="paperNMcq" class="mr-sm-2">No of Mcq's:</label>
                <input type="number" class="form-control"  id="paperNMcq" min="0" name="paperNMcq" autocomplete="off" required>
              </div>
              <div class="col-md-3 form-group">
                <label for="paperNShort" class="mr-sm-2">No of Short(3 marks):</label>
                <input type="number" name="paperNShort" id="paperNShort" min="0" class="form-control" required>
              </div>
              <div class="col-md-3 form-group">
                <label for="paperNLong" class="mr-sm-2">No of Long(5 marks):</label>
                <input type="number" name="paperNLong" id="paperNLong" min="0" class="form-control" required>
              </div>
              <div class="col-md-2 form-group">
                <label for="paperTime" class="mr-sm-2">Time(mintues):</label>
                <input type="number" name="paperTime" id="paperTime" min="1" class="form-control" required>
              </div>
            </div>
            <div class="text-right">
              <button type="submit" class="btn btn-success mb-2 px-5" value="add" name="submit"><i class="far fa-plus-circle"></i> Add</button>
            </div>
          </form>
        </div>

        <div class="container shadow-lg p-0 mt-5">
          <h3 class="p-4 bg-purple text-white"><i class="far fa-file-check"></i> Update Paper</h3>
          <form class="px-5 pt-5" action="?pageName=paper&tab=make" method="POST" onsubmit="return subTermVerification()">
            <div class="row">
              <div class="col-md-6 form-group">
                 <label for="patternSearchSubCode" class="mr-sm-2">Subject Code:</label>
                <select class="form-control mb-2 mr-sm-2 patternSubCode" id="patternSearchSubCode" name="patternSearchSubCode" >
                <option value="select">select</option>
                <?php
                $rawArray=getAssignSubjects();
                for($i=0;$i<count($rawArray);$i++){ ?>
                  <option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
              <?php }
                ?>
              </select>
              </div>
              <div class="form-group col-md-6">
                <label for="patternSearchTerm" class="mr-sm-2">Select Term:</label>
                <select class="form-control patternTerm" id="patternSearchTerm" name="patternSearchTerm" >
                  <option value="select">select</option>
                </select>
              </div>
              
            </div>
          <button type="submit" class="btn btn-info" name="submit" value="searchPattern"><i class="fal fa-file-search"></i> Search</button>
          </form>
            <?php if(isset($_POST['submit']) && $_POST['submit']=="searchPattern"){
                              $searchedPattern=getPattern();
                          }
                      ?>
            <form class="p-5" action="?pageName=paper&tab=make" method="POST" onsubmit="return upPattern()">
              <input type="hidden" name="updatePatternID" value="<?php if(!empty($searchedPattern)) echo $searchedPattern["id"];?>">
              <input type="hidden" name="patternUpdateSubCode" 
              value="<?php if(!empty($searchedPattern)) echo $searchedPattern["subject_code"];?>">
              <div class="row">
                <div class="col-md-3 form-group">
                 <label for="patternUpdateSubCode" class="mr-sm-2">Subject Code::</label>
                 <input type="text" name="patternUpdateSubCode" id="patternUpdateSubCode" class="form-control" disabled
                 value="<?php if(!empty($searchedPattern)) echo $searchedPattern["subject_code"];?>" >
              </div>
              
              <div class="col-md-3 form-group">
                <label for="updateTerm" class="mr-sm-2">Term:</label>
                <input type="text" class="form-control"  id="updateTerm" name="updateTerm" required autocomplete="off" disabled
                 value="<?php if(!empty($searchedPattern)) echo $searchedPattern["term"];?>">
              </div>
                <div class="col-md-3 form-group">
                  <label for="updatePatternOpDate" class="mr-sm-2">Open Date:</label>
                  <input type="date" name="updatePatternOpDate" id="updatePatternOpDate" required class="form-control" disabled
                  value="<?php if(!empty($searchedPattern)) echo $searchedPattern["open_date"];?>">
                </div>
                <div class="col-md-3 form-group">
                  <label for="updatePatternLDate" class="mr-sm-2">Last Date:</label>
                  <input type="date" name="updatePatternLDate" id="updatePatternLDate" required class="form-control" disabled
                  value="<?php if(!empty($searchedPattern)) echo $searchedPattern["last_date"];?>">
                </div>
              </div>

              <div class="row">
                <div class="col-md-2 form-group">
                  <label for="updatePatternTMarks" class="mr-sm-2">Total Marks:</label>
                  <input type="number" class="form-control"  id="updatePatternTMarks" min="1" required name="updatePatternTMarks" autocomplete="off"
                   value="<?php if(!empty($searchedPattern)) echo $searchedPattern["total_marks"];?>" disabled>
                </div>
                <div class="col-md-2 form-group">
                  <label for="updatePatternNMcq" class="mr-sm-2">No of Mcq's:</label>
                  <input type="number" class="form-control"  id="updatePatternNMcq" min="0" required name="updatePatternNMcq" autocomplete="off" disabled
                  value="<?php if(!empty($searchedPattern)) echo $searchedPattern["n_mcq"];?>">
                </div>
                <div class="col-md-3 form-group">
                  <label for="updatePatternNShort" class="mr-sm-2">No of Short(3 marks):</label>
                  <input type="number" name="updatePatternNShort" id="updatePatternNShort" min="0" required class="form-control" disabled
                  value="<?php if(!empty($searchedPattern)) echo $searchedPattern["n_short"];?>" >
                </div>
                <div class="col-md-3 form-group">
                  <label for="updatePatternNLong" class="mr-sm-2">No of Long(5 marks):</label>
                  <input type="number" name="updatePatternNLong" id="updatePatternNLong" min="0" required class="form-control" disabled
                  value="<?php if(!empty($searchedPattern)) echo $searchedPattern["n_long"];?>" >
                </div>
                <div class="col-md-2 form-group">
                  <label for="updatePatternTime" class="mr-sm-2">Time(mintues):</label>
                  <input type="number" name="updatePatternTime" id="updatePatternTime" min="1" required class="form-control" disabled
                  value="<?php if(!empty($searchedPattern)) echo $searchedPattern["time"];?>" >
                </div>
              </div>
              <button type="button" class="btn btn-warning mb-2 px-5" id="patternEdit"
              <?php if(empty($searchedPattern)) echo "disabled"?> > <i class="fad fa-edit"></i> Edit</button>
              <button type="submit" class="btn btn-primary mb-2 px-5" name="submit" id="updatePattern" value="updatePattern" disabled ><i class="far fa-file-check"></i> Update</button>
              <button type="submit" class="btn btn-danger mb-2 px-5" name="submit" value="deletePattern"
              <?php if(empty($searchedPattern)) echo "disabled"?> id="deletePattern"><i class="fal fa-trash-alt"></i> Delete</button>
          </form>
        </div>
      </div>

    <?php
      }
     ?>

     <?php
       function addViewPaperHTML(){
       ?>
       <div class="container border p-5">
         <div class="container shadow-lg p-0 pb-3">
           <h3 class="p-4 bg-purple text-white"><i class="far fa-file-check"></i> View Paper</h3>
           <form class="px-5 pt-5" action="?pageName=paper&tab=view" method="POST" onsubmit="return subTermVerification()">
             <div class="row">
               <div class="form-group col-md-6">
                 <label for="selectCourse" class="mr-sm-2">Select Subject:</label>
                 <select class="form-control mb-2 mr-sm-2 patternSubCode" id="subCode" name="subCode" >
                    <option value="select">select</option>
                    <?php
                    $rawArray=getAssignSubjects();
                    for($i=0;$i<count($rawArray);$i++){ ?>
                      <option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
                  <?php }
                    ?>
                  </select>
               </div>
               <div class="form-group col-md-6">
                 <label for="selectCourse" class="mr-sm-2">Select Term:</label>
                 <select class="form-control patternTerm" id="term" name="term" >
                      <option value="select">select</option>
                    </select>
               </div>
             </div>
           <button type="submit" class="btn btn-info" name="submit" value="searchAttendance"><i class="fal fa-file-search"></i> Search</button>
           </form>

           <?php if(isset($_POST['submit']) && $_POST['submit']=="searchAttendance"){
                              $data=getAttendance();
                              if(!empty($data)){
                                  $attendance=$data[0];
                                  $atnInfo=$data[1];  
                              }
                              
                          }
                      ?>
          <form method="POST" action="?pageName=paper&tab=view" class="p-0 m-0">
          <input type="hidden" name="subCode" value="<?php echo $atnInfo['subCode']; ?>">
          <input type="hidden" name="term" value="<?php echo $atnInfo['term']; ?>">            
           <div class="container">
           <table class="table table-hover table-striped text-center table-bordered mt-3">
   					<thead>
   						<tr class="text-white" style="background-color: #9a57f2;">
                <th>Sr#</th>
                <th>Student id</th>
                <th>Name</th>
   							<th>Date</th>
   							<th>Status</th>
                <th>Check Status</th>
                <th>Action</th>
   						</tr>
   					</thead>
   					<?php
   						if(!empty($attendance)){ ?>
                <tbody>
               <?php for ($i=0; $i<count($attendance); $i++) { 
                ?>
   								<tr>
                    <td><?php echo $i+1; ?></td>
                    <td><?php echo $attendance[$i]["student_id"]; ?></td>
                    <td><?php echo $attendance[$i]["name"].' '.$attendance[$i]["lastName"]; ?></td>
                    <td><?php echo $attendance[$i]["date"]; ?></td>
                    <td><?php echo $attendance[$i]["status"]; ?></td>
                    <td class="<?php if($attendance[$i]["check_status"]=='Pending'){ echo 'bg-warning'; }else echo 'bg-success'  ?> text-white"><?php echo $attendance[$i]["check_status"]; ?></td> 
                    <td>
                        <button type="submit" name="id" value="<?php echo $attendance[$i]['student_id']; ?>" class="btn text-danger  p-0 w-100"><u>Delete</u></button>
                    </td>
   								</tr>
   							
              <?php } ?>
               </tbody>
                </table>
               </div>
               <?php }else {
                echo '</table></div> <div class="text-center bg-light">
                    <span>Record not found</span>
                  </div>';
              }
            ?>
         </div>
       </form>
       </div>
     <?php
       }
      ?>

    <?php
      function addCheckPaperHTML(){
      ?>
			<div class="container border p-5">
				<div class="container shadow-lg p-0 pb-3">
					<h3 class="p-4 bg-purple text-white"><i class="far fa-file-check"></i> Select Paper</h3>
					<form class="px-5 pt-5" action="" method="POST" onsubmit="return subTermVerification()">
						<div class="row">
							<div class="form-group col-md-4">
								<label for="subCode" class="mr-sm-2">Select Subject:</label>
                 <select class="form-control mb-2 mr-sm-2 patternSubCode" id="subCode" name="subCode" >
                    <option value="select">select</option>
                    <?php
                     $rawArray=getAssignSubjects();
                    for($i=0;$i<count($rawArray);$i++){ ?>
                      <option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
                  <?php }
                    ?>
                  </select>
							</div>
							<div class="form-group col-md-4">
								<label for="term" class="mr-sm-2">Select Term:</label>
								<select class="form-control patternTerm" id="term" name="term" >
                      <option value="select">select</option>
                    </select>
							</div>
              <div class="form-group col-md-4">
                <label for="stdId" class="mr-sm-2">Enter Student ID:</label>
                <input type="number" class="form-control" id="stdId" name="stdId" autocomplete="off" required>
              </div>
						</div>
					<button type="submit" class="btn btn-info" name="submit" value="searchPaper"><i class="fal fa-file-search"></i> Search</button>
					</form>

            <?php if(isset($_POST['submit']) && $_POST['submit']=="searchPaper"){
                                          $data=getPaperForChecks();
                                         if($data!=false){
                                          $pattern=$data[0];
                                          $paper=$data[1];
                                      
                      ?>
					<h5 class="pl-5 mt-5 text-danger font-italic">Below the selected Paper</h5>
					<form class="px-5 pb-5" action="" method="POST" onsubmit="">
            <input type="hidden" name="subCode" value="<?php echo $pattern['subject_code'];?>">
            <input type="hidden" name="term" value="<?php echo $pattern['term'];?>">
            <input type="hidden" name="student_id" value="<?php echo $pattern['student_id'];?>">
						<div class="row">

							<div class="col-md-4 form-group">
                <label for="" class="mr-sm-2">Student Id:</label>
                <input type="text" name="" value="<?php echo $pattern['student_id'];?>" class="form-control" disabled>
              </div>

							<div class="col-md-4 form-group">
								<label for="" class="mr-sm-2">Student Name:</label>
								<input type="text" name="" value="<?php echo $pattern['name'];?>" class="form-control" disabled>
							</div>
              <div class="col-md-4 form-group">
                <label for="topicName" class="mr-sm-2">Last Name:</label>
                <input type="text" name="" value="<?php echo $pattern['last_name'];?>" class="form-control" disabled>
              </div>

						</div>
            <div class="row">
              <div class="col-md-4 form-group">
                <label for="topicName" class="mr-sm-2">Obtain Marks in mcq's:</label>
                <input type="text" class="form-control"  id="" name="" autocomplete="off" 
                value="<?php echo $pattern['obtain_marks'];?>" disabled>
              </div>
              
              <div class="col-md-4 form-group">
                <label for="" class="mr-sm-2">Term:</label>
                <input type="text" class="form-control"  id="" value="<?php echo $pattern['term'];?>" autocomplete="off" disabled>
              </div>
              <div class="col-md-4 form-group">
                <label for="" class="mr-sm-2">Subject:</label>
                <input type="text" class="form-control"  id="" value="<?php echo $pattern['subject_code'];?>" autocomplete="off" disabled>
              </div>

            </div>

						<div class="row">
							<div class="col-md-2 form-group">
								<label for="" class="mr-sm-2">Total Marks:</label>
								<input type="text" class="form-control"  id="" value="<?php echo $pattern['total_marks'];?>" autocomplete="off" disabled>
							</div>
							<div class="col-md-2 form-group">
								<label for="" class="mr-sm-2">No of Mcq's:</label>
								<input type="text" class="form-control"  id="" value="<?php echo $pattern['n_mcq']; ?>" autocomplete="off" disabled>
							</div>
							<div class="col-md-3 form-group">
								<label for="" class="mr-sm-2">No of Short(3 marks):</label>
								<input type="text" name="" value="<?php echo $pattern['n_short'];?>" class="form-control" disabled>
							</div>
							<div class="col-md-3 form-group">
								<label for="" class="mr-sm-2">No of Long(5 marks):</label>
								<input type="text" name="" value="<?php echo $pattern['n_long'];?>" class="form-control" disabled>
							</div>
							<div class="col-md-2 form-group">
								<label for="" class="mr-sm-2">Time(mintues):</label>
								<input type="text" name="" value="<?php echo $pattern['time'];?>" class="form-control" disabled>
							</div>
						</div>
              <?php for ($i=0; $i<count($paper); $i++) { ?>
                <!--long question checking portion  -->
                <h3><?php echo 'Q.No '.($i+1);?></h3>
            <div class="container my-4 bg-purple text-white py-3">
              <div class="form-group">
                <label for="topicName" class="mr-sm-2">Question Statement:</label>
                <textarea name="name" rows="3" class="form-control" placeholder="type question statement*" disabled><?php echo $paper[$i]['q_statement'];?></textarea>
              </div>
              <div class="form-group">
                <label for="topicName" class="mr-sm-2">Student answer:</label>
                <textarea name="name" rows="3" class="form-control" placeholder="type question statement*" disabled><?php echo $paper[$i]['answer'];?></textarea>
              </div>
              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="topicName" class="mr-sm-2">Total Marks:</label>
                  <input type="number" name="" value="<?php echo ($paper[$i]['q_type']=='3')? '3': '5';?>" class="form-control" disabled>
                </div>
                <div class="col-md-6 form-group">
                  <label for="topicName" class="mr-sm-2">Teacher Remarks:</label>
                  <input type="number" name="<?php echo $paper[$i]['id'];?>" min="0" max="<?php echo $paper[$i]['q_type'];?>" 
                  value="<?php echo $paper[$i]['obtain_marks'];?>"  class="form-control">
                </div>
              </div>
            </div>
              <?php } ?>
						
						<button type="submit" class="btn btn-success mb-2 px-5" value="checkedPaper" name="submit"><i class="far fa-plus-circle"></i> Submit</button>
				</form>
      <?php } } ?>
				</div>
			</div>

    <?php
      }
     ?>
