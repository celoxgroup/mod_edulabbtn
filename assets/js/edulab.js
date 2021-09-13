jQuery(document).ready(function($){

    var eduUrlOption = $("input[name='edu_url_option']:checked").val();
    if(eduUrlOption == "edu_labid"){
      $("#fitem_id_lab_id").show();
    }else{
      $("#fitem_id_lab_id").hide();
    }
    $("input[name='edu_url_option']").click(function(){
      var onlabId = $("input[name='edu_url_option']:checked").val();
      if(onlabId == "edu_labid"){
        $("#fitem_id_lab_id").show();
      }else{
        $("#fitem_id_lab_id").hide();
      }
    });
  });