<?php
    require_once("business/paper_handler.php");
    require_once("business/utilities.php");

?>
<div class="container bg-white p-0  shadow-lg mb-3">
    <h3 class="p-4 bg-purple text-white"><i class="far fa-folder-plus"></i> Take Paper</h3>
    
    <?php
     if (isset($_POST['submit'])){
            if($_POST['submit']=="start") {
                  $data=createPaper();
                  if($data!=false){
                  $paper=$data[1];
                  $paperInfo=$data[0];
                  echo displayPaper($paper,$paperInfo);  
                  }else{
                      echo takePaperHtml();
                  }
                }
        }else if(isset($_POST['paper']) && $_POST['paper']=="attempted") {
                        if(savePaper()){
                          displayStatus("Your paper has been successfully submitted. Thank you!");
                        }else{
                          displayStatus("Ooops! Due to some error your paper is not submitted. Please contact your teacher.");
                        }
        }
        else {
            echo takePaperHtml();
        }
?>
<div>

<?php
  function takePaperHtml(){ ?>
  <form class=" p-5" action="" method="POST" onsubmit="return subTermVerification()">
      <section class="">
            <div class="row">
            <div class="form-group col-md-6">
              <label for="subCode" class="mr-sm-2">Select Subject:</label>
              <select class="form-control mb-2 mr-sm-2 patternSubCode" id="subCode" name="subCode" >
                    <option value="select">select</option>
                    <?php
                    $rawArray=getSubjects();
                    for($i=0;$i<count($rawArray);$i++){ ?>
                      <option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
                  <?php }
                    ?>
                  </select>
            </div>
            <div class="form-group col-md-6">
              <label for="term" class="mr-sm-2">Select Term:</label>
               <select class="form-control patternTerm" id="term" name="term" >
                      <option value="select">select</option>
                    </select>
            </div>
          </div>
          <button type="submit" class="btn btn-success mb-2 px-5"  value="start" name="submit"><i class="fal fa-play"></i> Start</button>
      </section>
      
    </form>
  <?php }
?>

<?php
  function displayPaper($paper,$paperInfo){  ?>
    <section class="policies p-3">
        <ol>
          <li class="font-weight-bold font-italic">Answer will accepted within a given time.</li>
          <li class="font-weight-bold font-italic">Answer will accepted within a given time.</li>
          <li class="font-weight-bold font-italic">Answer will accepted within a given time.</li>
          <li class="font-weight-bold font-italic">Answer will accepted within a given time.</li>
        </ol>
         <button type="submit" class="btn btn-success mb-2 px-5" id="startPaper" 
         onclick="CountDown(<?php echo $paperInfo['time']*60; ?>)" 
          ><i class="fal fa-play"></i> Agree</button>
      </section>
      
      <form action="" method="POST" class="p-4 startSection d-none" id="paperForm" name="paperForm">
        <input type="hidden" name="subCode" value="<?php echo $paperInfo['subCode']; ?>">
        <input type="hidden" name="term" value="<?php echo $paperInfo['term']; ?>">
        <input type="hidden" name="paper" value="attempted">
        <!-- paper header -->
        <div class="container my-3">
        <table class="table table-hover table-striped table-bordered">
          <tr>
            <td class="text-right">Subject:</td>
            <td class="text-left"><?php echo $paperInfo['subCode']; ?></td>
          </tr>
          <tr>
            <td class="text-right">Term:</td>
            <td class="text-left"><?php echo $paperInfo['term']; ?></td>
          </tr>
          <tr>
            <td class="text-right">Total Marks:</td>
            <td class="text-left"><?php echo $paperInfo['total_marks']; ?></td>
          </tr>
        </table>
      </div>
      <div class="container text-right text-danger">
        Remaining Time: <span id="time"></span>
      </div>
      <!-- paper header finishing -->
    <?php  for ($i=0; $i<count($paper); $i++) { ?>
      <!-- <div class="questionMainSection"> -->
        <section class="container questionSections " style="<?php if($i!=0) echo 'display:none;'; ?>">
          <h5>
          <span class="float-left"><?php echo "Q.No ".($i+1);  ?> </span>
          <span class="float-right"><?php echo ' Marks: '; echo ($paper[$i]['q_type']=='MCQ')? '1': $paper[$i]['q_type']; ?> </span>  
          </h5>
          <h4 class="pl-2 pt-3" style="clear: both;"> <?php echo $paper[$i]['q_statement'];?> </h4>
          <?php if ($paper[$i]['q_type']=='MCQ') { ?>
            <div class="container pl-5 mb-2">
              <input type="radio" name="<?php echo $paper[$i]['id']; ?>" value="A">
            <label for="male"><?php echo $paper[$i]['option_a']; ?></label>
            <br>
            <input type="radio" name="<?php echo $paper[$i]['id']; ?>" value="B">
            <label for="male"><?php echo $paper[$i]['option_b']; ?></label>
            <br>
            <input type="radio" name="<?php echo $paper[$i]['id']; ?>" value="C">
            <label for="male"><?php echo $paper[$i]['option_c']; ?></label>
            <br>
            <input type="radio" name="<?php echo $paper[$i]['id']; ?>" value="D">
            <label for="male"><?php echo $paper[$i]['option_d']; ?></label>
            </div>
         <?php }else { ?>
            <!-- input area -->
            <textarea type="text" class="p-2 mt-3 mb-3" name="<?php echo $paper[$i]['id']; ?>" rows="4" style="width:100%;"></textarea>
            <br>
         <?php } ?>
                   <?php if($i==0){ ?>
                  <button type="button" class="btn mb-2 nextQue" ><i class="fas fa-caret-circle-right display-4"></i></button>
                   <?php }else if(($i+1)==count($paper)) { ?>
                   <button type="button" class="btn mb-2 prevQue"><i class="fas fa-caret-circle-left display-4"></i></button>
                  <?php } else{?>
                   <button type="button" class="btn mb-2 prevQue"><i class="fas fa-caret-circle-left display-4"></i></button>
                   <button type="button" class="btn mb-2 nextQue" ><i class="fas fa-caret-circle-right display-4"></i></button>
                  <?php } ?>
        </section>
    <!-- </div> -->
<?php } ?>
     <!-- <button type="button" class="btn btn-success mb-2 px-5" id="nextQue"><i class="fal fa-play"></i> Next</button> -->
     <div class="text-right">
     <button type="button" class="btn btn-danger mb-2 px-5" onclick="SubmitFunction()" >Submit</button>
     </div>
      </form>
 <?php }
?>
<?php function displayStatus($status){ ?>
    <div>
      <h3 class="text-danger font-italic p-5"><?php echo $status; ?></h3>
    </div>
<?php }?>