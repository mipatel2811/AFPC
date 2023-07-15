$(".product_video").on("change", function () {
  if ($(this).val() == 1) {
    $(".product_video_wrap").html(`
			  <div class="form-group">
				<label for="images" class="control-label required">Video Title</label>
				<div class="input-group">
				  <div class="custom-file">
					<input name="video_title" type="text" class="form-control" placeholder="Video Title">
				  </div>
				</div>
			  </div>
			  <div class="form-group">
				<label for="video" class="control-label required">Video</label>
				<div class="input-group">
				  <div class="custom-file">
					<input name="video" type="file" class="custom-file-input" id="video" accept="video/mp4,video/x-m4v,video/*">
					<label class="custom-file-label" for="video">Choose file</label>
				  </div>
				</div>
			  </div>
				  `);
    $("input[name=video_title]").rules("add", "required");
    $("input[name=video]").rules("add", "required");
  } else {
    $(".product_video_wrap").html("");
  }
});
$(".technical_specification").on("change", function () {
  if ($(this).val() == 1) {
    var tsCount = $(".technical_specification_wrap").children().length;
    $(".technical_specification_wrap").html(
      '<div class="row justify-content-between ts-remove_'+tsCount+'"> <div class="col-lg-3 col-6"> <div class="form-group"> <label for="images" class="control-label required">Technical Specification Title</label> <div class="input-group"> <div class="custom-file"> <input name="technical_specification_value['+tsCount+'][]" type="text" required="required" data-msg="Please write Custom Build Technical Specification Title" class="form-control technical_specification_title" placeholder="Technical Specification Title"> </div> </div> </div> </div> <div class="col-lg-7 col-6"> <div class="form-group"> <label for="images" class="control-label required">Technical Specification</label> <textarea name="technical_specification_value['+tsCount+'][]" required="required" data-msg="Please write Custom Build Technical Specification" class="form-control summernoteTechnicalSpecification" rows="10" cols="50"></textarea> </div> </div> <div class="col-lg-2 col-6"> <a href="javascript:void(0)" class="btn btn-primary add_ts"  data-andcount="'+tsCount+'" style="margin-top: 32px;"><i class="fas fa-plus-square"></i></a> <a href="javascript:void(0)" class="btn btn-danger delete" data-andcount="'+tsCount+'" style="margin-top: 32px;"><i class="fas fa-minus-square"></i></a> </div> </div>'
    );
    $("input[class*=technical_specification_title]").rules("add", "required");
    $("input[class*=summernoteTechnicalSpecification]").rules(
      "add",
      "required"
    );
    $(".summernoteTechnicalSpecification").summernote();
  } else {
    $(".technical_specification_wrap").html("");
  }
});
$(".technical_specification_wrap").on("click",".add_ts",function(e){
	var tsCount = $(".technical_specification_wrap").children().length;
	$(".technical_specification_wrap").append(
		'<div class="row justify-content-between ts-remove_'+tsCount+'"> <div class="col-lg-3 col-6"> <div class="form-group"> <label for="images" class="control-label required">Technical Specification Title</label> <div class="input-group"> <div class="custom-file"> <input name="technical_specification_value['+tsCount+'][]" type="text" required="required" data-msg="Please write Custom Build Technical Specification Title" class="form-control technical_specification_title" placeholder="Technical Specification Title"> </div> </div> </div> </div> <div class="col-lg-7 col-6"> <div class="form-group"> <label for="images" class="control-label required">Technical Specification</label> <textarea name="technical_specification_value['+tsCount+'][]" required="required" data-msg="Please write Custom Build Technical Specification" class="form-control summernoteTechnicalSpecification" rows="10" cols="50"></textarea> </div> </div> <div class="col-lg-2 col-6"> <a href="javascript:void(0)" class="btn btn-primary add_ts"  data-andcount="'+tsCount+'" style="margin-top: 32px;"><i class="fas fa-plus-square"></i></a> <a href="javascript:void(0)" class="btn btn-danger delete" data-andcount="'+tsCount+'" style="margin-top: 32px;"><i class="fas fa-minus-square"></i></a> </div> </div>'
	  );
	  $("input[class*=technical_specification_title]").rules("add", "required");
	  $("input[class*=summernoteTechnicalSpecification]").rules(
		"add",
		"required"
	  );
	  $(".summernoteTechnicalSpecification").summernote();
});
$('.technical_specification_wrap').on('click','.delete',function(e){
    var id = $(this).data('andcount');
    e.preventDefault();
    $(".ts-remove_"+ id).remove();
	// setTimeout(() => {
		if($(".technical_specification_wrap").children().length === 0){
			// alert($(".technical_specification_wrap").children().length);
			$('#technical_specification2').trigger('click');
		}
	// }, 500);
});