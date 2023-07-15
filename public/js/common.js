$(document).ready(function(event) {
    // Add minus icon for collapse element which is open by default
    $(".collapse.show").each(function() {
        $(this)
            .prev(".card-header")
            .find(".fa")
            .addClass("fa-minus")
            .removeClass("fa-plus");
    });

    // Toggle plus minus icon on show hide of collapse element
    $(".collapse")
        .on("show.bs.collapse", function(e) {
            $(this)
                .prev(".card-header")
                .find(".fa")
                .removeClass("fa-plus")
                .addClass("fa-minus");
        })
        .on("hide.bs.collapse", function(e) {
            var id = e.target.id.split("-")[1];
            $("#com-header_" + id)
                .find(".fa")
                .removeClass("fa-minus")
                .addClass("fa-plus");
        });

    $(".component-status").change(function(e) {
        e.preventDefault();
        var classId = $(this).data("componentid");
        if ($(this).val() == 1) {
            $("#com-header_com" + classId)
                .removeClass("bg-secondary")
                .addClass("bg-primary");
        } else {
            $("#com-header_com" + classId)
                .removeClass("bg-primary")
                .addClass("bg-secondary");
        }
    });
});

$(".product_video").on("change", function() {
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
$(".technical_specification").on("change", function() {
    if ($(this).val() == 1) {
        var tsCount = $(".technical_specification_wrap").children().length;
        $(".technical_specification_wrap").html(
            '<div class="row justify-content-between ts-remove_' +
                tsCount +
                '"> <div class="col-lg-3 col-6"> <div class="form-group"> <label for="images" class="control-label required">Technical Specification Title</label> <div class="input-group"> <div class="custom-file"> <input name="technical_specification_value[' +
                tsCount +
                '][]" type="text" required="required" data-msg="Please write Custom Build Technical Specification Title" class="form-control technical_specification_title" placeholder="Technical Specification Title"> </div> </div> </div> </div> <div class="col-lg-7 col-6"> <div class="form-group"> <label for="images" class="control-label required">Technical Specification</label> <textarea name="technical_specification_value[' +
                tsCount +
                '][]" required="required" data-msg="Please write Custom Build Technical Specification" class="form-control summernoteTechnicalSpecification" rows="10" cols="50"></textarea> </div> </div> <div class="col-lg-2 col-6"> <a href="javascript:void(0)" class="btn btn-primary add_ts"  data-andcount="' +
                tsCount +
                '" style="margin-top: 32px;"><i class="fas fa-plus-square"></i></a> <a href="javascript:void(0)" class="btn btn-danger delete" data-andcount="' +
                tsCount +
                '" style="margin-top: 32px;"><i class="fas fa-minus-square"></i></a> </div> </div>'
        );
        $("input[class*=technical_specification_title]").rules(
            "add",
            "required"
        );
        $("input[class*=summernoteTechnicalSpecification]").rules(
            "add",
            "required"
        );
        $(".summernoteTechnicalSpecification").summernote();
    } else {
        $(".technical_specification_wrap").html("");
    }
});
$(".technical_specification_wrap").on("click", ".add_ts", function(e) {
    var tsCount = $(".technical_specification_wrap").children().length;
    $(".technical_specification_wrap").append(
        '<div class="row justify-content-between ts-remove_' +
            tsCount +
            '"> <div class="col-lg-3 col-6"> <div class="form-group"> <label for="images" class="control-label required">Technical Specification Title</label> <div class="input-group"> <div class="custom-file"> <input name="technical_specification_value[' +
            tsCount +
            '][]" type="text" required="required" data-msg="Please write Custom Build Technical Specification Title" class="form-control technical_specification_title" placeholder="Technical Specification Title"> </div> </div> </div> </div> <div class="col-lg-7 col-6"> <div class="form-group"> <label for="images" class="control-label required">Technical Specification</label> <textarea name="technical_specification_value[' +
            tsCount +
            '][]" required="required" data-msg="Please write Custom Build Technical Specification" class="form-control summernoteTechnicalSpecification" rows="10" cols="50"></textarea> </div> </div> <div class="col-lg-2 col-6"> <a href="javascript:void(0)" class="btn btn-primary add_ts"  data-andcount="' +
            tsCount +
            '" style="margin-top: 32px;"><i class="fas fa-plus-square"></i></a> <a href="javascript:void(0)" class="btn btn-danger delete" data-andcount="' +
            tsCount +
            '" style="margin-top: 32px;"><i class="fas fa-minus-square"></i></a> </div> </div>'
    );
    $("input[class*=technical_specification_title]").rules("add", "required");
    $("input[class*=summernoteTechnicalSpecification]").rules(
        "add",
        "required"
    );
    $(".summernoteTechnicalSpecification").summernote();
});
$(".technical_specification_wrap").on("click", ".delete", function(e) {
    var id = $(this).data("andcount");
    e.preventDefault();
    $(".ts-remove_" + id).remove();
    if ($(".technical_specification_wrap").children().length === 0) {
        $("#technical_specification2").trigger("click");
    }
});

$(".restore-default").click(function(event) {
    event.preventDefault();
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, restore it!"
    }).then(result => {
        if (result.isConfirmed) {
            var id = $(this).attr("data-id");
            var cateId = $(this).attr("data-cateId");

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            $.ajax({
                url: "/restore-default" + "/" + cateId + "/" + id,
                method: "get",
                success: function(data) {
                    if (data.visibilityHtml != 0) {
                        $(".parent_wrap_" + id).html(data.visibilityHtml);
                        $(".js-example-tags").select2({
                            allowClear: true,
                            placeholder: "Select Component Visibility",
                            tags: true
                        });
                    }
                    $(".regular_price-" + id).val(data.com_data.regular_price);
                    $(".special_price-" + id).val(data.com_data.special_price);
                    if (data.com_data.is_active == 1) {
                        $(".is_enable1-" + id).attr("checked", true);
                    }
                    if (data.com_data.is_active == 0) {
                        $(".is_enable2-" + id).attr("checked", true);
                    }
                }
            });
        }
    });
});
$(".restore-default-cate").click(function(event) {
    event.preventDefault();
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, restore it!"
    }).then(result => {
        if (result.isConfirmed) {
            var cateId = $(this).attr("data-cateId");

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            $.ajax({
                url: "/category-restore-default" + "/" + cateId,
                method: "get",
                success: function(data) {
                    var myObject = Object.assign({}, data);
                    $.each(data, function(indexInArray, valueOfElement) {
                        var divElement = $("#childSort_" + valueOfElement)[0]
                            .outerHTML;
                        $("#childSort_" + valueOfElement).remove();
                        $("#collapseOne-component" + cateId).append(divElement);
                    });
                    $("#childSortId_" + cateId).val(JSON.stringify(myObject));
                }
            });
        }
    });
});
$(".sort-enabled").click(function(event) {
    var cateId = $(this).attr("data-cateId");
    var firstChildId = $("div#collapseOne-component" + cateId).children()[0].id;
    $("div#collapseOne-component" + cateId + " input[type=radio]:checked").each(
        function() {
            if ($(this).val() == 1) {
                var classId = $(this).data("componentid");
                $("#childSort_" + classId).insertBefore($("#" + firstChildId));
            } else {
                var classId = $(this).data("componentid");
                $("#childSort_" + classId).insertAfter($("#" + firstChildId));
            }
        }
    );
    var componentIds = [];
    i = 0;
    $("div#collapseOne-component" + cateId)
        .children()
        .each(function() {
            if ($(this)[0].id.indexOf("childSort_") != -1) {
                componentIds[i++] = $(this)[0].id.split("_")[1];
            }
        });
    var myObject = Object.assign({}, componentIds);
    $("#childSortId_" + cateId).val(JSON.stringify(myObject));
});

function checkMarkAs(id) {
    var arr = [];
    var i = 0;
    $(".mark_as_" + id).each(function() {
        if ($(this).is(":checked")) {
            arr = ["mark_as"];
        } else {
            $(this)
                .parents(".icheck-primary")
                .addClass("displayNone");
        }
        i++;
    });

    if (arr.length == 0) {
        $(".mark_as_" + id).each(function() {
            $(this)
                .parents(".icheck-primary")
                .removeClass("displayNone");
        });
    }
    var arrR = [];
    var iR = 0;
    $(".mark_as_recom_" + id).each(function() {
        if ($(this).is(":checked")) {
            arrR = ["mark_as_recom"];
        } else {
            $(this)
                .parents(".icheck-primary")
                .addClass("displayNone");
        }
        iR++;
    });

    if (arrR.length == 0) {
        $(".mark_as_recom_" + id).each(function() {
            $(this)
                .parents(".icheck-primary")
                .removeClass("displayNone");
        });
    }
}
