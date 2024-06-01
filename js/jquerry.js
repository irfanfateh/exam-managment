jQuery(document).ready(function($) {
	$("#menuToggler").click(function(event) {
		if ($("#togglerIcon").hasClass('fa-align-right')) {
			$("#togglerIcon").removeClass('fa-align-right');
			$("#togglerIcon").addClass('fas fa-align-left');
			$(".menuBtnsText").hide();
			$("#sideBar").addClass('col-1');
			$("#sideBar").removeClass('col-2');
			$("#mainBar").addClass('col-11');
			$("#mainBar").removeClass('col-10');
			$(".sideBarLinksSection ul li a").removeClass("text-left");
			$(".sideBarLinksSection ul li a").addClass("text-center");

		} else {

			$("#togglerIcon").addClass('fa-align-right');
			$("#togglerIcon").removeClass('fas fa-align-left');
			$(".menuBtnsText").show();
			$("#sideBar").removeClass('col-1');
			$("#sideBar").addClass('col-2');
			$("#mainBar").removeClass('col-11');
			$("#mainBar").addClass('col-10');
			$(".sideBarLinksSection ul li a").removeClass("text-center");
			$(".sideBarLinksSection ul li a").addClass("text-left");
		}
	});


});

$(document).ready(function() {
	$(".announcementHover").click(function(event) {
		$(this).siblings("p").toggle();
	});
});

$(document).ready(function() {
	$(".iconMouse").mouseover(function(event) {
		if ($("#togglerIcon").hasClass('fas fa-align-left')){
		$(this).children('span').show();
		}
	});
	$(".iconMouse").mouseleave(function(event) {
		if ($("#togglerIcon").hasClass('fas fa-align-left')){
		$(this).children('span').hide();
		}
	});
});
// teacher js filterjq
jQuery(document).ready(function($){

	  $("#updateTopicEditBtn").click(function(event) {
    $("#deleteTopic").prop('disabled', true);
    $("#updateTopic").prop('disabled', false);
    $("#updateTopicName").prop('disabled', false);
	});

  $("#updateMcqEditBtn").click(function(event) {
		$("#deleteMcq").prop('disabled', true);
    $("#updateMcq").prop('disabled', false);
    $("#updateMcqReStatement").prop('disabled', false);
    $("#updateMcqReOptA").prop('disabled', false);
    $("#updateMcqReOptB").prop('disabled', false);
    $("#updateMcqReOptC").prop('disabled', false);
    $("#updateMcqReOptD").prop('disabled', false);
    $("#updateQuizOptCorrect").prop('disabled', false);
  });
  $("#updateQuizSubEditBtn").click(function(event) {
		$("#deleteSub").prop('disabled', true);
		$("#updateSubQuiz").prop('disabled', false);
    $("#updateSubReStatement").prop('disabled', false);
    $("#updateSubReMarks").prop('disabled', false);
  });

  $(".addMcqSubject").change(function(event) {
    var subject=$(this).val();
    $('.addMcqTopic').empty();
                $.ajax({
                        url: 'business/offline_handler.php',
                        type: 'POST',
                        data: {subject: subject
                        },

                        success: function(data){
                            $('.addMcqTopic').append(data);
                            // alert(data);
                        }
                      })
                      .done(function() {

                      })
                      .fail(function() {
                        jQuery(document).ready(function($) {
                          $("#error").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                                        +'<strong>Error!</strong> System failed to load topics of the selected subject.'
                                       +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                                          +'<span aria-hidden="true">&times;</span>'
                                       +'</button>'
                                      +'</div>');
                        });
                      })
                      .always(function() {
                        console.log("complete");
                      });
  });

	$(".quiz").click(function(event) {
		$(this).siblings("ol").toggle();
	});

	$("#updateAnnounceEditBtn").click(function(event) {
		$("#deleteAnnouncement").prop('disabled', true);
		$("#updateAnnouncement").prop('disabled', false);
		$("#updateAnnouncementDetail").prop('disabled', false);
		$("#updateAnnouncementDate").prop('disabled', false);
		$("#updateAnnouncementTitle").prop('disabled', false);
	});

});
// jquerry 2nd.js
jQuery(document).ready(function($){
	$("#reEntersubjectForm").hide();
	$("#updateSubject").click(function(event) {
		$("#reEntersubjectForm").show();
	});
});
jQuery(document).ready(function($) {
	$(".custom-file-input").on("change", function() {
	var fileName = $(this).val().split("\\").pop();
	$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});


	$("#updateTchrForm").hide();
	$("#updateTeacher").click(function(event) {
		$("#updateTchrForm").show();
	});
});

jQuery(document).ready(function($) {
  $(".patternSubCode").change(function(event) {
    var subject=$(this).val();
    $('.patternTerm').empty();
                $.ajax({
                        url: 'business/offline_handler.php',
                        type: 'POST',
                        data: {subCode: subject
                        },

                        success: function(data){
                            $('.patternTerm').append(data);
                            // alert(data);
                        }
                      })
                      .done(function() {
                      })
                      .fail(function() {
                        jQuery(document).ready(function($) {
                          $("#error").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                                        +'<strong>Error!</strong> System failed to load terms of the selected subject.'
                                       +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                                          +'<span aria-hidden="true">&times;</span>'
                                       +'</button>'
                                      +'</div>');
                        });
                      })
                      .always(function() {
                        console.log("complete");
                      });
  });

 $("#patternEdit").click(function(event) {
    $("#deletePattern").prop('disabled', true);
    $("#updatePattern").prop('disabled', false);
    $("#updateTerm").prop('disabled', false);
    $("#updatePatternOpDate").prop('disabled', false);
    $("#updatePatternLDate").prop('disabled', false);
    $("#updatePatternTMarks").prop('disabled', false);
    $("#updatePatternNMcq").prop('disabled', false);
    $("#updatePatternNShort").prop('disabled', false);
    $("#updatePatternNLong").prop('disabled', false);
    $("#updatePatternTime").prop('disabled', false);
  });

});

jQuery(document).ready(function($) {
  $("#startPaper").click(function(event){
    $(".policies").hide();
    $(".startSection").removeClass('d-none');
  });

  $(".nextQue").click(function(event){
    $(this).parent().hide().next().show();
  });

  $('.prevQue').click(function(){
   $(this).parent().hide().prev().show();
  });
});