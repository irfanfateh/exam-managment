<?php
      require_once("business/utilities.php");
      $announcement=getAnnouncement();
?>
<div class="container shadow-lg p-3 bg-white">
  <?php
    if (!empty($announcement)) {
      foreach ($announcement as $value) { ?>
        <selection>
              <div class="container announcementHover mt-1">
                <div class="row border p-3">
                  <div class="col-7 col-sm-9">
                    <h5><i class="fad fa-bullhorn font-italic"></i> <span class="ml-2 font-weight-normal"><?php echo $value['title'];?></span></h5>
                  </div>
                  <div class="col-5 col-sm-3 text-right">
                    <span class="mr-auto"><?php echo $value['date'];?></span>
                    <span class="ml-2"><i class="far fa-plus text-secondary"></i></span>
                  </div>
                </div>
              </div>
              <p class="border p-3"><?php echo $value['description'];?></p>
        </selection>

    <?php  }
    } else {
      echo '<p class="border p-3">There is no announcement yet!</p>';
    }

  ?>
</div>
