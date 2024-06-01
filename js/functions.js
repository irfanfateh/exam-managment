function getAddSubjectValidation(){
var subName=$("#subName").val();
var subCode=$("#subCode").val();
if (subName=="" || subCode=="") {
  $("#error").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                +'<strong>Error!</strong> please fill all the fields to enter new subject.'
               +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                  +'<span aria-hidden="true">&times;</span>'
               +'</button>'
              +'</div>');
              return false;
} else if(/\s+/.test(subCode)){
  $("#error").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                +'<strong>Error!</strong> subjcet code can not hold whitespace.'
               +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                  +'<span aria-hidden="true">&times;</span>'
               +'</button>'
              +'</div>');
              return false;
}else{
  return true;
}
}

function getSearchSubValidation(){
  var subCode=$("#searchSubCode").val();
  if(/\s+/.test(subCode)){
    $("#error").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                  +'<strong>Error!</strong> subjcet code can not hold whitespace.'
                 +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                    +'<span aria-hidden="true">&times;</span>'
                 +'</button>'
                +'</div>');
                return false;
  }else{
    return true;
  }
}

function getAssignSubjectValidation() {
  var selectedSubject = $("#subjectAssigned").children("option:selected").val();
  var selectedTeacher = $("#teacherAssigned").children("option:selected").val();
  if (selectedSubject=="select" || selectedTeacher=="select") {
    $("#error").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                  +'<strong>Error!</strong> invalid selection* please select subject & teacher then hit assign button.'
                 +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                    +'<span aria-hidden="true">&times;</span>'
                 +'</button>'
                +'</div>');
                return false;
  }else{
                return true;
  }
}

function getUnassignSubjectValidation() {
  var subjectUnassigned = $("#subjectUnassigned").children("option:selected").val();
  if (subjectUnassigned=="select") {
    $("#error").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                  +'<strong>Error!</strong> invalid selection* please select subject and then hit unassign button.'
                 +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                    +'<span aria-hidden="true">&times;</span>'
                 +'</button>'
                +'</div>');
                return false;
  }else{
                return true;
  }
}



function getAddTchrValid(){

    if(!getTeacherImageValidation()){
      return false;
    }
    if(!getTeacherStateValidation()){
      return false;
    }

    return true;
}
function getTeacherStateValidation() {
  var tchrState=$("#tchrState").children("option:selected").val();
  if (tchrState=="select") {
    $("#error").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                  +'<strong>Error!</strong> please select state of the teacher.'
                 +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                    +'<span aria-hidden="true">&times;</span>'
                 +'</button>'
                +'</div>');
                return false;
  }
  return true;
}
function getTeacherImageValidation() {
  var image_name=$("#customFile").val();
  if (image_name=="") {
    $("#error").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                  +'<strong>Error!</strong> please select image & image must be jpg ,png ,jpeg or gif.'
                 +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                    +'<span aria-hidden="true">&times;</span>'
                 +'</button>'
                +'</div>');
    return false;
  }
  else {
    var extention=image_name.split('.').pop().toLowerCase();
    if (jQuery.inArray(extention, ['gif','png','jpeg','jpg'])== -1) {
      $("#imageLabel").html("Choose file");
      $("#error").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                    +'<strong>Error!</strong> invalid image file* image must be jpg ,png ,jpeg or gif.'
                   +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                      +'<span aria-hidden="true">&times;</span>'
                   +'</button>'
                  +'</div>');
      return false;
    }
  }
  return true;
}

function getAdminPassValidation(){
  var oldpwd=$("#oldpwd").val();
  var newpwd=$("#newpwd").val();
  if (oldpwd=="" || newpwd=="") {
    $("#error").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                  +'<strong>Error!</strong> Please fill all the fields.'
                 +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                    +'<span aria-hidden="true">&times;</span>'
                 +'</button>'
                +'</div>');
    return false;
  }else if (oldpwd.length<8 || newpwd.length<8) {
    $("#error").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                  +'<strong>Error!</strong> password must be at least 8 character.'
                 +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                    +'<span aria-hidden="true">&times;</span>'
                 +'</button>'
                +'</div>');
    return false;
  }
  return true;
}

function getAddStdValid(){

    if(!getStdImage()){
      return false;
    }
    if(!getStdStateValidation()){
      return false;
    }
    var pass=$("#stdPassword").val();
    if (pass.length<8) {
      $("#stdError").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                    +'<strong>Error!</strong> password must be at least 8 character.'
                   +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                      +'<span aria-hidden="true">&times;</span>'
                   +'</button>'
                  +'</div>');
      return false;
    }

    return true;
}
function getStdImage() {
  var image_name=$("#customFile").val();
  if (image_name=="") {
    $("#stdError").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                  +'<strong>Error!</strong> please select image & image must be jpg ,png ,jpeg or gif.'
                 +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                    +'<span aria-hidden="true">&times;</span>'
                 +'</button>'
                +'</div>');
    return false;
  }
  else {
    var extention=image_name.split('.').pop().toLowerCase();
    if (jQuery.inArray(extention, ['gif','png','jpeg','jpg'])== -1) {
      $("#imageLabel").html("Choose file");
      $("#stdError").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                    +'<strong>Error!</strong> invalid image file* image must be jpg ,png ,jpeg or gif.'
                   +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                      +'<span aria-hidden="true">&times;</span>'
                   +'</button>'
                  +'</div>');
      return false;
    }
  }
  return true;
}

function getStdStateValidation() {
  var tchrState=$("#stdState").children("option:selected").val();
  if (tchrState=="select") {
    $("#stdError").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                  +'<strong>Error!</strong> please select state.'
                 +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                    +'<span aria-hidden="true">&times;</span>'
                 +'</button>'
                +'</div>');
                return false;
  }
  return true;
}

function CountDown(duration) {
              var display = document.getElementById('time');
                        var timer = duration, minutes, seconds;

                      var interVal=  setInterval(function () {
                            minutes = parseInt(timer / 60, 10);
                            seconds = parseInt(timer % 60, 10);

                            minutes = minutes < 10 ? "0" + minutes : minutes;
                            seconds = seconds < 10 ? "0" + seconds : seconds;
                    display.innerHTML ="<b>" + minutes + "m : " + seconds + "s" + "</b>";
                            if (timer > 0) {
                               --timer;
                            }else{
                       clearInterval(interVal)
                                SubmitFunction();
                             }

                       },1000);

                }

function SubmitFunction(){
  document.getElementById('paperForm').submit();

 }
 function subTermVerification(){
  var subCode=$(".patternSubCode").children("option:selected").val();
  var term=$(".patternTerm").children("option:selected").val();
  if (subCode=="select" || term=="select") {
    $("#error").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                  +'<strong>Error!</strong> please select subject code and term.'
                 +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                    +'<span aria-hidden="true">&times;</span>'
                 +'</button>'
                +'</div>');
    
                return false;
  }
  return true; 
 }
 function addTopic(){
  var subCode=$("#enterTopicCourse").children("option:selected").val();
  var topic=$("#enterTopic").val();
  return topicVerification(subCode,topic);
 }
 function viewTopic(){
  var subCode=$("#vTSub").children("option:selected").val();
  return topicVerification(subCode,'NA');
 }
 function searchTopic(){
  var subCode=$("#srchTopicCourse").children("option:selected").val();
  var topic=$("#searchTopicName").val();
  return topicVerification(subCode,topic);
 }
 function topicVerification(subCode,topic){
  try{
    if (subCode=="select") throw 'Subject code must be select';
    if (!/^\S((?!.*  ).*\S)?$/.test(topic)) throw 'Topic name can not start & end with space';
  }catch(error){
    printMessage(error);
    return false;  
  }
  
  return true; 
 }
 function printMessage(message){
  
  $("#error").html('<div class="alert alert-danger container alert-dismissible fade show" role="alert">'
                    +'<strong>Error!</strong> '+ message
                   +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                      +'<span aria-hidden="true">&times;</span>'
                   +'</button>'
                  +'</div>');
    
}
function upTopic(){
  var topic=$("#updateTopicName").val();
  return topicVerification('NA',topic);
}
function quizVerification(subCode,topic,qui){
  try{
    if (subCode=="select") throw 'Subject code must be select';
    if (topic=="select") throw 'Topic must be select';
    if (!/^\S((?!.*  ).*\S)?$/.test(qui)) throw 'Question statement can not start & end with space';
  }catch(error){
    printMessage(error);
    return false;  
  }
  
  return true; 
 }
 function quizOptVerification(a,b,c,d,cor){
  try{
    if (cor=="select") throw 'Please select the correct answer';
    if (!/^\S((?!.*  ).*\S)?$/.test(a)) throw 'Option A can not start & end with space';
    if (!/^\S((?!.*  ).*\S)?$/.test(b)) throw 'Option B can not start & end with space';
    if (!/^\S((?!.*  ).*\S)?$/.test(c)) throw 'Option C can not start & end with space';
    if (!/^\S((?!.*  ).*\S)?$/.test(d)) throw 'Option D can not start & end with space';
  }catch(error){
    printMessage(error);
    return false;  
  }
  
  return true; 
 }
function addMcqVerif(){
  var subCode=$("#addMcqSubject").children("option:selected").val();
  var topic=$("#addMcqTopic").children("option:selected").val();
  var qui=$("#addMcqStatement").val();
  var a=$("#addMcqOptA").val();
  var b=$("#addMcqOptB").val();
  var c=$("#addMcqOptC").val();
  var d=$("#addMcqOptD").val();
  var cor=$("#addMcqOptCorrect").children("option:selected").val();
  if (quizVerification(subCode,topic,qui) && quizOptVerification(a,b,c,d,cor)) {
    return true;
  }
  return false;
}
function addLongVerif(){
  var subCode=$("#addSubjectiveSub").children("option:selected").val();
  var topic=$("#addSubjectiveTopic").children("option:selected").val();
  var qui=$("#addSubjectiveStatement").val();
  var type=$("#addSubjectiveMarks").children("option:selected").val();
  if (quizVerification(subCode,topic,qui)) {
      if (type=="select"){printMessage('Question type must be select.'); return false;}
      return true;
  }
  return false;
}
function searchMc(){
 var subCode=$("#updateQuizSubject").children("option:selected").val();
  var topic=$("#updateQuizTopic").children("option:selected").val();
  var qui=$("#updateQuizStatement").val();
  return quizVerification(subCode,topic,qui);
}
function searchLong(){
 var subCode=$("#updateLongSubject").children("option:selected").val();
  var topic=$("#updateLongTopic").children("option:selected").val();
  var type=$("#updateSubType").children("option:selected").val();
  var qui=$("#updateLongStatement").val();
  if(quizVerification(subCode,topic,qui)){
   if (type=="select"){printMessage('Question type must be select.'); return false;}
      return true;   
  }
  return false;
}
function updateMcVerif(){
  var qui=$("#updateMcqReStatement").val();
  var a=$("#updateMcqReOptA").val();
  var b=$("#updateMcqReOptB").val();
  var c=$("#updateMcqReOptC").val();
  var d=$("#updateMcqReOptD").val();
  var cor=$("#updateQuizOptCorrect").children("option:selected").val();
  if (quizVerification('NA','NA',qui) && quizOptVerification(a,b,c,d,cor)) {
      return true;
  }
  return false;
}
function updateLongVerif(){
  var qui=$("#updateSubReStatement").val();
  var type=$("#updateSubReMarks").children("option:selected").val();
  if (quizVerification('NA','NA',qui)) {
      if (type=="select"){printMessage('Question type must be select.'); return false;}
      return true;
  }
  return false;
}
function viewMc(){
  var subCode=$("#viewQuizSubject").children("option:selected").val();
  var topic=$("#viewQuizTopic").children("option:selected").val();
  return quizVerification(subCode,topic,'NA');
}
function viewLong(){
  var subCode=$("#viewLongSubject").children("option:selected").val();
  var topic=$("#viewLongTopic").children("option:selected").val();
  var type=$("#viewQuizType").children("option:selected").val();
  if (quizVerification(subCode,topic,'NA')) {
      if (type=="select"){printMessage('Question type must be select.'); return false;}
      return true;
  }
  return false;
}
function notiVer(title,description){
  try{
    if (!/^\S((?!.*  ).*\S)?$/.test(title)) throw 'Title can not contain space at begining and end or double space';
    if (!/^\S((?!.*  ).*\S)?$/.test(description)) throw 'Description can not contain double space or blank';
    if (description.length>299) throw 'Description can not more than 300 words';
  }catch(error){printMessage(error);return false;}
  return true;
}
function addNoti(){
  var title=$("#announcementTitle").val();
  var description=$("#announcementDetail").val();
  return notiVer(title,description);
  }

function srchNoti(){
  var title=$("#searchAnnouncementTitle").val();
  return notiVer(title,'NA');
  }
function upNoti(){
  var title=$("#updateAnnouncementTitle").val();
  var description=$("#updateAnnouncementDetail").val();
  return notiVer(title,description);
}
function resultVer(sub,term){
  try{
    if (sub=='select') throw 'Subject code must be select.';
    if (term=='select') throw 'Term must be select.';
  }catch(error){printMessage(error);return false;}
  return true;
}

function decResult(){
  var subCode=$("#resultSubCode").val();
  var term=$("#resultTerm").val();
  return resultVer(subCode,term);
}

function unDecResult(){
  var subCode=$("#updateResultSubCode").val();
  var term=$("#updateResultTerm").val();
  return resultVer(subCode,term);
}
function patternVer(sub,term,total,noMcq,noShort,noLong,time){
  try{
    if (sub=='select') throw 'Subject code must be select.';
    if (!/^\S((?!.*  ).*\S)?$/.test(term)) throw 'Term can not contain space at begining & end or double space.';
    var temp=noMcq*1;
    temp=temp+(noShort*3);
    temp=temp+(noLong*5);
    if (total!=temp) throw 'Some of the questions not equal to the total marks.';
  }catch(error){printMessage(error);return false;}
  return true;
}
function pattern(){
  var subCode=$("#subCode").val();
  var term=$("#paperTerm").val();
  var total=$("#paperTMarks").val();
  var mcq=$("#paperNMcq").val();
  var short=$("#paperNShort").val();
  var long=$("#paperNLong").val();
  var time=$("#paperTime").val();
  return patternVer(subCode,term,total,mcq,short,long,time);
}
function upPattern(){
  var term=$("#updateTerm").val();
  var total=$("#updatePatternTMarks").val();
  var mcq=$("#updatePatternNMcq").val();
  var short=$("#updatePatternNShort").val();
  var long=$("#updatePatternNLong").val();
  var time=$("#updatePatternTime").val();
  return patternVer('NA',term,total,mcq,short,long,time);
}