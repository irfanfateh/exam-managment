<div class="container shadow-lg rounded-lg">
  <?php
    $home=getHome();
  ?>
  <div class="row container">
    <div class="col-md-6 p-4 justify-content-between d-flex dashboard">
      <h3>Available Subjects :</h3>
      <h3 class="<?php if($home['totalSubjects']!=0)echo 'text-danger';?>"><?php echo $home['totalSubjects'] ?></h3>
    </div>
    <div class="col-md-6 p-4 justify-content-between d-flex dashboard">
      <h3>Available Teachers :</h3>
      <h3 class="<?php if($home['totalTeacher']!=0)echo 'text-danger';?>"><?php echo $home['totalTeacher'] ?></h3>
    </div>
  </div>

  <div class="row container">
    <div class="col-md-6 p-4 justify-content-between d-flex dashboard">
      <h3>Assign Subjects to Teachers :</h3>
      <h3 class="<?php if($home['assignSubjects']!=0)echo 'text-danger';?>"><?php echo $home['assignSubjects'] ?></h3>
    </div>
    <div class="col-md-6 p-4 justify-content-between d-flex dashboard">
      <h3>Free Teachers :</h3>
      <h3 class="<?php if($home['freeTeachers']!=0)echo 'text-danger';?>"><?php echo $home['freeTeachers'] ?></h3>
    </div>
  </div>

  <div class="row container">
    <div class="col-md-6 p-4 justify-content-between d-flex dashboard">
      <h3>Unassign Subjects :</h3>
      <h3 class="<?php if($home['unAssignSubjects']!=0)echo 'text-danger';?>"><?php echo $home['unAssignSubjects'] ?></h3>
    </div>
    <div class="col-md-6 p-4 justify-content-between d-flex dashboard">
      <h3>Teachers having Subjects :</h3>
      <h3 class="<?php if($home['havingSubjectTchrs']!=0)echo 'text-danger';?>"><?php echo $home['havingSubjectTchrs'] ?></h3>
    </div>
  </div>
  <div class="row container">
    <div class="col-md-6 p-4 justify-content-between d-flex dashboard">
      <h3>Approved Students :</h3>
      <h3 class="<?php if($home['totalStudents']!=0)echo 'text-danger';?>"><?php echo $home['totalStudents'] ?></h3>
    </div>
    <div class="col-md-6 p-4 justify-content-between d-flex dashboard">
      <h3>Unapproved Students :</h3>
      <h3 class="<?php if($home['unApprovedStudents']!=0)echo 'text-danger';?>"><?php echo $home['unApprovedStudents'] ?></h3>
    </div>
  </div>

</div>
