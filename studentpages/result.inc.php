<div class="container bg-white shadow-lg p-0 mb-3">
    <h3 class="p-4 bg-purple text-white"><i class="far fa-poll btn-lg"></i> Check Result</h3>
    <?php if (isset($_POST['submit']) && $_POST['submit']=='checkResult') {
        require_once("business/paper_handler.php");
             $result=getResult();
             if($result!=false){ ?>
             <div class="container ">
              <h4 class="mt-5 pl-5">Your result: </h4>
                <div class="row justify-content-center">
                  <div class="col-md-3 text-center mt-5 mt-md-0">
                    <span>
                      <i class="fad fa-book-alt display-1 text-info"></i>
                      <h5> <span class="text-gray-dark">Subject:</span> <?php echo $result['subject']; ?> </h5>
                    </span>
                  </div>
                  <div class="col-md-3 text-center mt-5 mt-md-0">
                    <span>
                      <i class="fad fa-sticky-note display-1 text-info"></i>
                      <h5> <span class="text-gray-dark">Term:</span> <?php echo $result['term']; ?> </h5>
                    </span>
                  </div>
                </div><div class="row justify-content-center">
                  <div class="col-md-3 text-center mt-5">
                    <span>
                      <i class="fal fa-lightbulb-exclamation display-1 text-success"></i>
                      <h5> <span class="text-gray-dark">Obtain Marks:</span> <?php echo $result['obtain_marks']; ?> </h5>
                    </span>
                  </div>
                  <div class="col-md-3 text-center mt-5">
                    <span>
                      <i class="fal fa-lightbulb display-1 text-warning"></i>
                      <h5> <span class="text-gray-dark">Total Marks:</span> <?php echo $result['total_marks']; ?> </h5>
                    </span>
                  </div>
                </div>
             </div>
       <?php      }
    } ?>
    <form class=" p-5" action="" method="POST" onsubmit="return subTermVerification()">
      <div class="row">
        <div class="form-group col-md-6">
          <label for="selectCourse" class="mr-sm-2">Select Term:</label>
          <select class="form-control mb-2 mr-sm-2 patternSubCode" id="subCode" name="subCode" >
                    <option value="select" selected="">select</option>
                    <?php
                    $rawArray=getSubjects();
                    for($i=0;$i<count($rawArray);$i++){ ?>
                      <option value="<?php echo $rawArray[$i]["subject_code"];?>"><?php echo $rawArray[$i]["subject_code"];?></option>
                  <?php }
                    ?>
                  </select>
        </div>
        <div class="form-group col-md-6">
          <label for="selectCourse" class="mr-sm-2">Select Subject:</label>
          <select class="form-control patternTerm" id="term" name="term" >
                      <option value="select" selected="">select</option>
                    </select>
        </div>
      </div>
      <button type="submit" class="btn btn-info" name="submit" value="checkResult"><i class="fal fa-file-search"></i> Check</button>
    </form>
<div>
