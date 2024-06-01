<?php
		require_once("business/topic_handler.php");
		require_once("business/quiz_handler.php");
		require_once("business/utilities.php");
?>
<div class="container bg-white py-3">
		<ul class="nav nav-tabs" style="border: none;">
		  <li class="nav-item">
		    <a class="nav-link" href="?pageName=addquiz&tab=topic" id="topicTab"><i class="fad fa-layer-plus text-dark"></i> Manage Topic</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="?pageName=addquiz&tab=addq" id="addQTab"><i class="fas fa-question-circle text-danger"></i> Add Quiz</a>
		  </li>
			<li class="nav-item">
		    <a class="nav-link" href="?pageName=addquiz&tab=upq" id="updateQTab"><i class="far fa-file-check text-warning"></i> Update Quiz</a>
		  </li>
			<li class="nav-item">
				<a class="nav-link" href="?pageName=addquiz&tab=vwq" id="viewQTab"><i class="fal fa-eye text-success"></i> View Quiz</a>
			</li>
		</ul>

			<?php
				if(isset($_GET['tab'])){
					checkPost();
					if ($_GET['tab']=="topic"){
						getActiveTab("topicTab");
					  addTopicHTML();
					}else if ($_GET['tab']=="addq"){
						getActiveTab("addQTab");
						addQuizHTML();
					}else if ($_GET['tab']=="upq"){
						getActiveTab("updateQTab");
						updateQuizHTML();
					}else if ($_GET['tab']=="vwq"){
						getActiveTab("viewQTab");
						viewQuizHTML();
					}
				}
			?>

		</div>

		<?php
			function checkPost(){
				if (isset($_POST['submit'])){
						if($_POST['submit']=="addTopic") {
							addTopic();
						}else if($_POST['submit']=="viewTopics"){
							$GLOBALS['viewTopics']=true;
						}else if($_POST['submit']=="updateTopic"){
								updateTopic();
						}else if($_POST['submit']=="deleteTopic"){
								deleteTopic();
						}else if($_POST['submit']=="addMcq"){
								addMcq();
						}else if ($_POST['submit']=="addSubjective"){
							addSubjective();
						}else if ($_POST['submit']=="updateMcq"){
							updateMcq();
						}else if ($_POST['submit']=="deleteQuiz"){
							deleteQuiz();
						}else if ($_POST['submit']=="updateSubQuiz"){
							updateSubQuiz();
						}
				}
			}
		?>

    <?php
      function addTopicHTML(){
      ?>
      <div class="container border p-5">
        <div class="container shadow-lg p-0">
          <h3 class="p-4 bg-purple text-white"><i class="far fa-folder-plus"></i> Add Topic</h3>
          <form class="form-inline text-center p-5" action="?pageName=addquiz&tab=topic" method="POST" 
          onsubmit="return addTopic()">
            <div class="form-group">
              <label for="enterTopicCourse" class="mr-sm-2">Select Subject Code::</label>
              <select class="form-control mb-2 mr-sm-2 " id="enterTopicCourse" name="subCode">
                <option value="select">select</option>
								<?php
								$rawArray=getAssignSubjects();
								for($i=0;$i<count($rawArray);$i++){ ?>
									<option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
							<?php	}
								?>
              </select>
            </div>
            <div class="form-group">
              <label for="enterTopic" class="mr-sm-2">Topic Name:</label>
              <input type="text" class="form-control mb-2 mr-sm-2" placeholder="enter topic name*" id="enterTopic" name="topicName" autocomplete="off" required>
            </div>
            <button type="submit" class="btn btn-success mb-2 px-5" value="addTopic" name="submit"><i class="far fa-plus-circle"></i> Add</button>
          </form>
        </div>
        <!-- 2nd box -->
        <div class="container shadow-lg p-0 mt-5">
          <h3 class="p-4 bg-purple text-white"><i class="far fa-file-search"></i> Search Topic</h3>
          <form class="form-inline text-center p-5" action="?pageName=addquiz&tab=topic" method="POST"
          onsubmit="return searchTopic()">
            <div class="form-group">
              <label for="srchTopicCourse" class="mr-sm-2">Select Subject Code:</label>
              <select class="form-control mb-2 mr-sm-2" id="srchTopicCourse" name="subCode">
                <option value="select">select</option>
								<?php
								$rawArray=getAssignSubjects();
								for($i=0;$i<count($rawArray);$i++){ ?>
									<option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
							<?php	}
								?>
              </select>
            </div>
            <div class="form-group">
              <label for="searchTopicName" class="mr-sm-2">Topic Name:</label>
              <input type="text" class="form-control mb-2 mr-sm-2" placeholder="enter topic name*" id="searchTopicName" name="topicName" autocomplete="off" required>
            </div>
            <button type="submit" class="btn btn-info mb-2 px-5" name="submit" value="searchTopic"><i class="fal fa-file-search"></i> Search</button>
          </form>
          <!-- search table -->
					<?php if(isset($_POST['submit']) && $_POST['submit']=="searchTopic"){
									$searchedTopic=getTopicOf();
							}
					?>
          <div class="container pb-4">
            <form class="px-5 w-75 m-auto" action="?pageName=addquiz&tab=topic" method="POST" 
            onsubmit="return upTopic()">
							<input type="hidden" name="updateTopicOldTopic" value="<?php if(!empty($searchedTopic)) echo $searchedTopic["topic_name"];?>">
							<input type="hidden" name="updateTopicSubject" value="<?php if(!empty($searchedTopic)) echo $searchedTopic["subCode"];?>">
							<input type="hidden" name="updateTopicID" value="<?php if(!empty($searchedTopic)) echo $searchedTopic["id"];?>">
              <div class="form-group">
                <label for="updateTopicSubject" class="mr-sm-2">Selected Subject:</label>
								<input type="text" class="form-control mb-2 mr-sm-2" placeholder="subject" id="updateTopicSubject" name="updateTopicSubject" autocomplete="off" disabled
								value="<?php if(!empty($searchedTopic)) echo $searchedTopic["subCode"]?>">
              </div>
              <div class="form-group">
                <label for="updateTopicName" class="mr-sm-2">Topic Name:</label>
                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="topic" id="updateTopicName" name="updateTopicName" autocomplete="off" disabled
								value="<?php if(!empty($searchedTopic)) echo $searchedTopic["topic_name"]?>">
              </div>
              <div class="form-group">
                <label for="updateTopicID" class="mr-sm-2">Topic ID:</label>
                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="topic id" id="updateTopicID" name="updateTopicID" autocomplete="off" disabled
								value="<?php if(!empty($searchedTopic)) echo $searchedTopic["id"]?>">
              </div>
              <div class="form-group">
                <label for="updateTopicEnterBy" class="mr-sm-2">Entered By:</label>
                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="entered by" id="updateTopicEnterBy" name="updateTopicEnterBy" autocomplete="off" disabled
								value="<?php if(!empty($searchedTopic)) echo $searchedTopic["entered_by"]?>">
              </div>
              <button type="button" class="btn btn-warning mb-2 px-5" id="updateTopicEditBtn"
							<?php if(empty($searchedTopic)) echo "disabled"?> ><i class="fad fa-edit"></i> Edit</button>
              <button type="submit" class="btn btn-primary mb-2 px-5" name="submit" id="updateTopic" value="updateTopic" disabled ><i class="far fa-file-check"></i> Update</button>
							<button type="submit" class="btn btn-danger mb-2 px-5" name="submit" value="deleteTopic"
							<?php if(empty($searchedTopic)) echo "disabled"?> id="deleteTopic"><i class="fal fa-trash-alt"></i> Delete</button>
            </form>
          </div>

        </div>
              <!-- 3rd -->
              <div class="container shadow-lg p-0 pb-3 mt-5">
                <h3 class="p-4 bg-purple text-white"><i class="far fa-file-search"></i> View Topics</h3>
                <form class="form-inline text-center p-5" action="?pageName=addquiz&tab=topic" method="POST" 
                onsubmit="return viewTopic()">
                  <div class="form-group">
                    <label for="vTSub" class="mr-sm-2">Select Subject Code:</label>
                    <select class="form-control mb-2 mr-sm-2" id="vTSub" name="subCode">
                      <option value="select">select</option>
											<?php
											$rawArray=getAssignSubjects();
											for($i=0;$i<count($rawArray);$i++){ ?>
												<option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
										<?php	}
											?>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-info mb-2 px-5" name="submit" value="viewTopics"><i class="fal fa-file-search"></i> Search</button>
                </form>
                <!-- search table -->
                <div class="container">
                  <table class="table table-hover table-striped text-center table-bordered text-wrap">
                    <thead>
                      <tr class="text-white bg-purple">
                        <th>Topic Id</th>
                        <th>Topic Name</th>
                        <th>Add By</th>
                        <th>Date</th>
                      </tr>
                    </thead>
										<tbody>
                  <?php
                    if(isset($GLOBALS['viewTopics'])){
												$raw=getTopics();
												for($i=0;$i<count($raw);$i++){
													$row=$raw[$i]; ?>
													<tr>
	                          <td><?php echo $row["id"]; ?></td>
	                          <td><?php echo $row["topic_name"]; ?></td>
	                          <td><?php echo $row["entered_by"]; ?></td>
	                          <td><?php echo $row["date"]; ?></td>
	                        </tr>
											<?php	}
											 ?>
                      </tbody>
                      </table>
                    <?php unset($GLOBALS['viewTopics']);}else {
                      echo '</table> <div class="text-center bg-light">
                          <span>Record not found</span>
                        </div>';
                    }
                  ?>
                </div>
              </div>
      </div> <!-- main div -->
    <?php
      }
     ?>

     <?php
       function addQuizHTML(){
       ?>
       <div class="container border p-5">
         <div class="container shadow-lg p-0">
           <h3 class="p-4 bg-purple text-white"><i class="far fa-folder-plus"></i> Add Mcq's</h3>
           <form class=" p-5" action="?pageName=addquiz&tab=addq" method="POST" onsubmit="return addMcqVerif()">
             <div class="row">
               <div class="form-group col-md-6">
                 <label for="addMcqSubject" class="mr-sm-2">Select Subject:</label>
                 <select class="form-control addMcqSubject" id="addMcqSubject" name="addMcqSubject">
                   <option value="select">select</option>
									 <?php
	 								$rawArray=getAssignSubjects();
	 								for($i=0;$i<count($rawArray);$i++){ ?>
	 									<option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
	 							<?php	}
	 								?>
                 </select>

               </div>
               <div class="form-group col-md-6">
                 <label for="addMcqTopic" class="mr-sm-2">Select Topic:</label>
                 <select class="form-control addMcqTopic" id="addMcqTopic" name="addMcqTopic">
                   <option value="select">select</option>
                 </select>
               </div>
             </div>
             <div class="form-group">
               <label for="addMcqStatement" class="mr-sm-2">Question Statement:</label>
               <textarea name="addMcqStatement" rows="3" class="form-control" id="addMcqStatement" placeholder="type question statement*" required></textarea>
             </div>
             <div class="form-group">
               <label for="addMcqOptA" class="mr-sm-2">Option A:</label>
               <input type="text" class="form-control mb-2 mr-sm-2" placeholder="choice A*" id="addMcqOptA" name="addMcqOptA" autocomplete="off" required>
             </div>
             <div class="form-group">
               <label for="addMcqOptB" class="mr-sm-2">Option B:</label>
               <input type="text" class="form-control mb-2 mr-sm-2" placeholder="choice B*" id="addMcqOptB" name="addMcqOptB" autocomplete="off" required>
             </div>
             <div class="form-group">
               <label for="addMcqOptC" class="mr-sm-2">Option C:</label>
               <input type="text" class="form-control mb-2 mr-sm-2" placeholder="choice C*" id="addMcqOptC" name="addMcqOptC" autocomplete="off" required>
             </div>
             <div class="form-group">
               <label for="addMcqOptC" class="mr-sm-2">Option D:</label>
               <input type="text" class="form-control mb-2 mr-sm-2" placeholder="choice D*" id="addMcqOptD" name="addMcqOptD" autocomplete="off" required>
             </div>
             <div class="form-group">
               <label for="addMcqOptCorrect" class="mr-sm-2">Select Correct Option:</label>
               <select class="form-control" id="addMcqOptCorrect" name="addMcqOptCorrect">
                 <option value="select">select</option>
                 <option value="A">A</option>
                 <option value="B">B</option>
                 <option value="C">C</option>
                 <option value="D">D</option>
               </select>
              </div>
             <button type="submit" class="btn btn-success mb-2 px-5" value="addMcq" name="submit"><i class="far fa-plus-circle"></i> Add</button>
           </form>
         </div>
         <!-- 2nd box -->
         <div class="container shadow-lg p-0 mt-5">
           <h3 class="p-4 bg-purple text-white"><i class="far fa-folder-plus"></i> Add Subjective</h3>
           <form class=" p-5" action="?pageName=addquiz&tab=addq" method="POST" onsubmit="return addLongVerif()">
             <div class="row">
               <div class="form-group col-md-6">
                 <label for="addSubjectiveSub" class="mr-sm-2">Select Subject:</label>
                 <select class="form-control addMcqSubject" name="addSubjectiveSub" id="addSubjectiveSub">
                   <option value="select">select</option>
									 <?php
	 								$rawArray=getAssignSubjects();
	 								for($i=0;$i<count($rawArray);$i++){ ?>
	 									<option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
	 							<?php	}
	 								?>
                 </select>
               </div>
               <div class="form-group col-md-6">
                 <label for="addSubjectiveTopic" class="mr-sm-2">Select Topic:</label>
                 <select class="form-control addMcqTopic" name="addSubjectiveTopic" id="addSubjectiveTopic">
                   <option value="select">select</option>
								 </select>
               </div>
             </div>
             <div class="form-group">
               <label for="addSubjectiveStatement" class="mr-sm-2">Question Statement:</label>
               <textarea name="addSubjectiveStatement" rows="3" class="form-control" id="addSubjectiveStatement" placeholder="type question statement*" required></textarea>
             </div>
						 <div class="form-group">
               <label for="addSubjectiveMarks" class="mr-sm-2">Question Type:</label>
							 <select class="form-control" name="addSubjectiveMarks" id="addSubjectiveMarks">
								 <option value="select">select</option>
 								<option value="3">3</option>
								<option value="5">5</option>
 							</select>
             </div>
             <button type="submit" class="btn btn-success mb-2 px-5" value="addSubjective" name="submit"><i class="far fa-plus-circle"></i> Add</button>
           </form>
         </div>
       </div> <!-- main div -->
     <?php
       }
      ?>

			<?php
        function updateQuizHTML(){
        ?>
        <div class="container border p-5">
          <div class="container shadow-lg p-0">
            <h3 class="p-4 bg-purple text-white"><i class="far fa-file-check"></i> Update Mcq's</h3>
						<form class="px-5 pt-5" action="?pageName=addquiz&tab=upq" method="POST" onsubmit="return searchMc()">
							<input type="hidden" name="updateQuizType" value="MCQ">
							<div class="row">
								<div class="form-group col-md-6">
									<label for="updateQuizSubject" class="mr-sm-2">Select Subject:</label>
									<select class="form-control addMcqSubject" id="updateQuizSubject" name="updateQuizSubject" >
										<option value="select">select</option>
										<?php
										$rawArray=getAssignSubjects();
										for($i=0;$i<count($rawArray);$i++){ ?>
											<option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
									<?php	}
										?>
									</select>
								</div>
								<div class="form-group col-md-6">
									<label for="updateQuizTopic" class="mr-sm-2">Select Topic:</label>
									<select class="form-control addMcqTopic" id="updateQuizTopic" name="updateQuizTopic">
										<option value="select">select</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="updateQuizStatement" class="mr-sm-2">Question Statement:</label>
								<textarea name="updateQuizStatement" id="updateQuizStatement" rows="3" class="form-control" placeholder="type question statement*" ></textarea>
							</div>
						<button type="submit" class="btn btn-info" name="submit" value="searchMcq"><i class="fal fa-file-search"></i> Search</button>
						</form>
						<!-- after search from -->
						<?php if(isset($_POST['submit']) && $_POST['submit']=="searchMcq"){
										$searchedMcq=getQuizOf();
								}
						?>
						<h5 class="pl-5 pt-3 text-danger font-italic">Below the result of search</h5>
            <form class="px-5 pb-5" action="?pageName=addquiz&tab=upq" method="POST" 
            onsubmit="return updateMcVerif()">
						<input type="hidden" name="updateQuizOldTopic" value="<?php if(!empty($searchedMcq)) echo $searchedMcq["topicName"];?>">
            <input type="hidden" name="updateQuizOldSub" value="<?php if(!empty($searchedMcq)) echo $searchedMcq["subCode"];?>">
            
						<input type="hidden" name="quizId" value="<?php if(!empty($searchedMcq)) echo $searchedMcq["id"];?>">

              <div class="row">
                <div class="form-group col-md-6">
                  <label for="updateMcqReSub" class="mr-sm-2">Selected Course:</label>
                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="topic name*" id="updateMcqReSub" name="updateMcqReSub" autocomplete="off" disabled
								value="<?php if(!empty($searchedMcq)) echo $searchedMcq["subCode"];?>">
                </div>
                <div class="form-group col-md-6">
                  <label for="updateMcqReTopic" class="mr-sm-2">Selected Topic:</label>
                  <input type="text" class="form-control mb-2 mr-sm-2" placeholder="topic name*" id="updateMcqReTopic" name="updateMcqReTopic" autocomplete="off" disabled
									value="<?php if(!empty($searchedMcq)) echo $searchedMcq["topicName"];?>">
                </div>
              </div>
              <div class="form-group">
                <label for="updateMcqReStatement" class="mr-sm-2">Question Statement:</label>
                <textarea name="updateMcqReStatement" id="updateMcqReStatement" rows="3" class="form-control" placeholder="type question statement*" disabled
								><?php if(!empty($searchedMcq)) echo $searchedMcq["que_statement"];?></textarea>
              </div>
              <div class="form-group">
                <label for="updateMcqReOptA" class="mr-sm-2">Option A:</label>
                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="topic name*" id="updateMcqReOptA" name="updateMcqReOptA" autocomplete="off" disabled
								value="<?php if(!empty($searchedMcq)) echo $searchedMcq["option_a"];?>">
              </div>
              <div class="form-group">
                <label for="updateMcqReOptB" class="mr-sm-2">Option B:</label>
                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="topic name*" id="updateMcqReOptB" name="updateMcqReOptB" autocomplete="off" disabled
								value="<?php if(!empty($searchedMcq)) echo $searchedMcq["option_b"];?>">
              </div>
              <div class="form-group">
                <label for="updateMcqReOptC" class="mr-sm-2">Option C:</label>
                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="topic name*" id="updateMcqReOptC" name="updateMcqReOptC" autocomplete="off" disabled
								value="<?php if(!empty($searchedMcq)) echo $searchedMcq["option_c"];?>">
              </div>
              <div class="form-group">
                <label for="updateMcqReOptD" class="mr-sm-2">Option D:</label>
                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="topic name*" id="updateMcqReOptD" name="updateMcqReOptD" autocomplete="off" disabled
								value="<?php if(!empty($searchedMcq)) echo $searchedMcq["option_d"];?>">
              </div>
              <div class="form-group">
                <label for="updateQuizOptCorrect" class="mr-sm-2">Select Correct Option:</label>
                <select class="form-control" id="updateQuizOptCorrect" name="updateQuizOptCorrect" disabled>
                  <option value="select">select</option>
                  <option value="A" <?php if(!empty($searchedMcq) && $searchedMcq["correct_option"]=="A") echo "selected";?>>A</option>
                  <option value="B" <?php if(!empty($searchedMcq) && $searchedMcq["correct_option"]=="B") echo "selected";?>>B</option>
                  <option value="C" <?php if(!empty($searchedMcq) && $searchedMcq["correct_option"]=="C") echo "selected";?>>C</option>
                  <option value="D" <?php if(!empty($searchedMcq) && $searchedMcq["correct_option"]=="D") echo "selected";?>>D</option>
                </select>
               </div>
							 <button type="button" class="btn btn-warning mb-2 px-5" id="updateMcqEditBtn"
							<?php if(empty($searchedMcq)) echo "disabled"?> ><i class="fad fa-edit"></i> Edit</button>
              <button type="submit" class="btn btn-primary mb-2 px-5" name="submit" id="updateMcq" value="updateMcq" disabled ><i class="far fa-file-check"></i> Update</button>
							<button type="submit" class="btn btn-danger mb-2 px-5" name="submit" value="deleteQuiz"
							<?php if(empty($searchedMcq)) echo "disabled"?> id="deleteMcq"><i class="fal fa-trash-alt"></i> Delete</button>
						</form>
          </div>
          <!-- 2nd box -->
          <div class="container shadow-lg p-0 mt-5">
            <h3 class="p-4 bg-purple text-white"><i class="far fa-file-check"></i> Update Subjective</h3>
						<form class="px-5 pt-5" action="?pageName=addquiz&tab=upq" method="POST" onsubmit="return searchLong()">
							<!-- <input type="hidden" name="updateQuizType" value="Subjective"> -->
							<div class="row">
								<div class="form-group col-md-5">
									<label for="updateLongSubject" class="mr-sm-2">Select Subject:</label>
									<select class="form-control addMcqSubject" id="updateLongSubject" name="updateQuizSubject" >
										<option value="select">select</option>
										<?php
										$rawArray=getAssignSubjects();
										for($i=0;$i<count($rawArray);$i++){ ?>
											<option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
									<?php	}
										?>
									</select>
								</div>
								<div class="form-group col-md-5">
									<label for="updateLongTopic" class="mr-sm-2">Select Topic:</label>
									<select class="form-control addMcqTopic" id="updateLongTopic" name="updateQuizTopic">
										<option value="select">select</option>
									</select>
								</div>
                <div class="form-group col-md-2">
                  <label for="updateSubType" class="mr-sm-2">Type:</label>
                  <select class="form-control" value="Subjective" id="updateSubType" name="updateQuizType">
                    <option value="select">select</option>
                    <option value="3">3</option>
                    <option value="5">5</option>
                  </select>
                </div>
							</div>

								<div class="form-group">
									<label for="updateLongStatement" class="mr-sm-2">Question Statement:</label>
									<textarea name="updateQuizStatement" id="updateLongStatement" rows="3" class="form-control" placeholder="type question statement*" ></textarea>
								</div>
							<button type="submit" class="btn btn-info" name="submit" value="searchSubjective"><i class="fal fa-file-search"></i> Search</button>
						</form>
						<!-- after search from -->
						<?php if(isset($_POST['submit']) && $_POST['submit']=="searchSubjective"){
										$searchedSubjective=getQuizOf();
								}
						?>
						<h5 class="pl-5 pt-3 text-danger font-italic">Below the result of search</h5>
            <form class="px-5 pb-5" action="?pageName=addquiz&tab=upq" method="POST" onsubmit="return updateLongVerif()">
							<input type="hidden" name="updateQuizOldTopic" value="<?php if(!empty($searchedSubjective)) echo $searchedSubjective["topicName"];?>">
              <input type="hidden" name="updateQuizOldSub" value="<?php if(!empty($searchedSubjective)) echo $searchedSubjective["subCode"];?>">
							<input type="hidden" name="quizId" value="<?php if(!empty($searchedSubjective)) echo $searchedSubjective["id"];?>">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="updateSubReSub" class="mr-sm-2">Selected Subject:</label>
									<input type="text" class="form-control mb-2 mr-sm-2" placeholder="subject" id="updateSubReSub" name="updateSubReSub" autocomplete="off" disabled
									value="<?php if(!empty($searchedSubjective)) echo $searchedSubjective["subCode"];?>">
                </div>
                <div class="form-group col-md-6">
                  <label for="updateSubReTopic" class="mr-sm-2">Selected Topic:</label>
									<input type="text" class="form-control mb-2 mr-sm-2" placeholder="topic*" id="updateSubReTopic" name="updateSubReTopic" autocomplete="off" disabled
									value="<?php if(!empty($searchedSubjective)) echo $searchedSubjective["topicName"];?>">
                </div>
              </div>
              <div class="form-group">
                <label for="updateSubReStatement" class="mr-sm-2">Question Statement:</label>
                <textarea name="updateSubReStatement" id="updateSubReStatement" rows="3" class="form-control" placeholder="type question statement*"
								disabled><?php if(!empty($searchedSubjective)) echo $searchedSubjective["que_statement"];?></textarea>
              </div>
							<div class="form-group">
                <label for="updateSubReMarks" class="mr-sm-2">Question Type:</label>
								<select class="form-control" id="updateSubReMarks" name="updateSubReMarks" disabled>
									<option value="select">Select</option>
									<option <?php if(!empty($searchedSubjective) && $searchedSubjective["type"]==3) echo "selected";?>  value="3">3</option>
									<option <?php if(!empty($searchedSubjective) && $searchedSubjective["type"]==5) echo "selected";?>  value="5">5</option>
								</select>
              </div>
							<button type="button" class="btn btn-warning mb-2 px-5" id="updateQuizSubEditBtn"
						 <?php if(empty($searchedSubjective)) echo "disabled"?> ><i class="fad fa-edit"></i> Edit</button>
						 <button type="submit" class="btn btn-primary mb-2 px-5" name="submit" id="updateSubQuiz" value="updateSubQuiz" disabled ><i class="far fa-file-check"></i> Update</button>
						 <button type="submit" class="btn btn-danger mb-2 px-5" name="submit" value="deleteQuiz"
						 <?php if(empty($searchedSubjective)) echo "disabled"?> id="deleteSub"><i class="fal fa-trash-alt"></i> Delete</button>
						</form>
          </div>
        </div> <!-- main div -->
      <?php
        }
       ?>

			 <?php
         function viewQuizHTML(){
         ?>
         <div class="container border p-5">
           <div class="container shadow-lg p-0 pb-3">
             <h3 class="p-4 bg-purple text-white"><i class="far fa-file-check"></i> View Mcq's</h3>
 						<form class="px-5 pt-5" action="?pageName=addquiz&tab=vwq" method="POST" onsubmit="return viewMc()">
							<input type="hidden" name="viewQuizType" value="MCQ">
 							<div class="row">
 								<div class="form-group col-md-6">
 									<label for="viewQuizSubject" class="mr-sm-2">Selected Subject:</label>
 									<select class="form-control addMcqSubject" id="viewQuizSubject" name="viewQuizSubject" >
 										<option value="select">select</option>
										<?php
										$rawArray=getAssignSubjects();
										for($i=0;$i<count($rawArray);$i++){ ?>
											<option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
									<?php	}
										?>
 									</select>
 								</div>
 								<div class="form-group col-md-6">
 									<label for="viewQuizTopic" class="mr-sm-2">Selected Topic:</label>
 									<select class="form-control addMcqTopic" id="viewQuizTopic" name="viewQuizTopic">
 										<option value="select">select</option>
 									</select>
 								</div>
 							</div>
 							<div class="row justify-content-end">
 								<div class="form-group col-md-6 text-right">
 								<button type="submit" class="btn btn-info w-50" name="submit" value="viewMcq"><i class="fal fa-file-search"></i> Search</button>
 								</div>
 							</div>
 						</form>
 						<!-- after search from -->
 						<h5 class="pl-5 text-danger font-italic">Below the result of search</h5>
						<?php if(isset($_POST['submit']) && $_POST['submit']=="viewMcq"){
										$viewMcqs=getQuizesOf();
										if(!empty($viewMcqs)){
										for($i=0; $i<count($viewMcqs); $i++){
											$mcqData=$viewMcqs[$i];
											$qNo=$i+1;
											?>
											<div class="py-2">
													<div class="mx-5 border p-0" >
														<h5 class="m-0 p-3 quiz" style="background-color:#f2f4f7;"> <?php echo "Q.No ".$qNo.": ".$mcqData["que_statement"]; ?> </h5>
															<ol class="list-unstyled ml-4">
																<li>Option A: <?php echo $mcqData["option_a"]; ?> </li>
																<li>Option B: <?php echo $mcqData["option_b"]; ?> </li>
																<li>Option C:<?php echo $mcqData["option_c"]; ?> </li>
																<li>Option D: <?php echo $mcqData["option_d"]; ?> </li>
																<li>Correct Option: <?php echo $mcqData["correct_option"]; ?> </li>
															</ol>
													</div>
											</div>
								<?php
							}
								}else {
								recordNotFound();
								}
							}else {
								recordNotFound();
							}
						?>

           </div>
           <!-- 2nd box -->
           <div class="container shadow-lg p-0 mt-5 pb-3">
             <h3 class="p-4 bg-purple text-white"><i class="far fa-file-check"></i> View Subjective</h3>
 						<form class="px-5 pt-5" action="" method="POST" onsubmit="return viewLong()">
 							<div class="row">
 								<div class="form-group col-md-5">
 									<label for="viewLongSubject" class="mr-sm-2">Select Subject:</label>
 									<select class="form-control addMcqSubject" id="viewLongSubject" name="viewQuizSubject" >
 										<option value="select">select</option>
										<?php
										$rawArray=getAssignSubjects();
										for($i=0;$i<count($rawArray);$i++){ ?>
											<option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
									<?php	}
										?>
 									</select>
 								</div>
 								<div class="form-group col-md-5">
 									<label for="viewLongTopic" class="mr-sm-2">Select Topic:</label>
 									<select class="form-control addMcqTopic" id="viewLongTopic" name="viewQuizTopic">
 										<option value="select">select</option>
 									</select>
 								</div>
								<div class="form-group col-md-2">
									<label for="viewQuizType" class="mr-sm-2">Select type:</label>
									<select class="form-control" id="viewQuizType" name="viewQuizType">
										<option value="select">select</option>
										<option value="3">3</option>
										<option value="5">5</option>
									</select>
								</div>
 							</div>
								<div class="row justify-content-end">
	 								<div class="form-group col-md-6 text-right">
	 								<button type="submit" class="btn btn-info w-50" name="submit" value="viewSubjective"><i class="fal fa-file-search"></i> Search</button>
	 								</div>
	 							</div>
 						</form>
 						<!-- after search from -->
 						<h5 class="pl-5 text-danger font-italic">Below the result of search</h5>
						<?php if(isset($_POST['submit']) && $_POST['submit']=="viewSubjective"){
										$viewSUb=getQuizesOf();
										if(!empty($viewSUb)){
										for($i=0; $i<count($viewSUb); $i++){
											$quizData=$viewSUb[$i];
											$qNo=$i+1;
											?>
											<div class="py-2">
													<div class="mx-5 border p-0" >
														<h5 class="m-0 p-3 quiz" style="background-color:#f2f4f7;"> <?php echo "Q.No ".$qNo.": ".$quizData["que_statement"]; ?> </h5>
													</div>
											</div>
								<?php
							}
								}else {
								recordNotFound();
								}
							}else {
								recordNotFound();
							}
						?>

           </div>
         </div> <!-- main div -->
       <?php
         }
        ?>

	<?php
	function recordNotFound(){
		echo '<div class="text-center bg-light p-2 container">
				<span>Record not found</span>
			</div>';
	}
	?>
