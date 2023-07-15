@extends('shopify-app::layouts.default')
@section('content')
@include('includes.top-nav')
@include('includes.sidebar')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Custom Build</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Add Custom Build</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              {{-- <div class="card-header">
                <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
              </div> --}}
              <!-- /.card-header -->
              <!-- form start -->
              {{ Form::open(['route' => 'custom-build.store', 'role' => 'form', 'method' => 'post', 'id' => 'custom-build', 'files' => true]) }}

              @include("custom-build.form")
              <div class="card-footer">
                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
              </div>
              {!! Form::close() !!}
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


@include('includes.footer')
@endsection
@section('scripts')
<script>
function  addRow(andcount,cat_id,com_id) {
          var parentClass = $('.add-row_'+andcount).parent()[0].classList[1];
          var parentClassId = parentClass.replace('parent_wrap_', '');
            <?php
                $addOptions='';
                foreach($componentSelect as $key=>$component){
                    $addOptions .= '<option value="'.$key.'">'.$component.'</option>';
                }
            ?>
            $('.add-row_'+andcount).append('<div class="form-group condition-row">{{ Form::label("select_condition_to_display", "Select Condition to display", ["class" => "control-label required"]) }}<div class="row"><div class="col-lg-4 col-4"><div class="form-group"> {{ Form::text(null, null, ["class" => "form-control", "placeholder" => "Component", "readonly"]) }}</div></div><div class="col-lg-2 col-2"><div class="form-group"> {{ Form::text(null, null, ["class" => "form-control", "placeholder" => "is equal to", "readonly"]) }}</div></div><div class="col-lg-4 col-4"> <select class="form-control js-example-tags" name="customBuild['+cat_id+']['+com_id+'][conditions]['+andcount+'][]" aria-invalid="false">{!! $addOptions !!}</select></div><div class="col-lg-2 col-2"> <a href="javascript:void(0)" class="btn btn-primary add_form_field"  data-andcount="'+andcount+'" onclick="addRow('+andcount+')"> And </a>  <a href="javascript:void(0)" class="btn btn-danger delete" data-andcount="'+andcount+'" onclick="deleteRow('+andcount+','+parentClassId+')"> - </a></div></div>');
        $(".js-example-tags").select2({
            allowClear: true,
            placeholder: "Select Component Visibility",
            tags: true,
        });
  }
function deleteRow(deleteCount,classWrap) {
  $('.parent_wrap_'+classWrap+' .add-row_'+deleteCount).on('click','.delete',function(e){
     var child = $('.parent_wrap_'+classWrap+' .add-row_'+deleteCount).children('.condition-row').length;
         e.preventDefault();
         if(child == 1){
        $('.parent_wrap_'+classWrap+' .add-row_'+deleteCount).remove();
    }else{
        $(this).closest('.form-group').remove();
      }

    });
}
function exitOrAddRow(cat_id,com_id) {
          var exitCount = $('.parent_wrap_'+com_id).children().length;
          <?php
                $options='';
                foreach($componentSelect as $key=>$component){
                    $options .= '<option value="'.$key.'">'.$component.'</option>';
                }
            ?>
            if(exitCount==0){
            $('.parent_wrap_'+com_id).append('<div class="add-row_'+exitCount+'"><div class="form-group condition-row">{{ Form::label("select_condition_to_display", "Select Condition to display", ["class" => "control-label required"]) }}<div class="row"><div class="col-lg-4 col-4"><div class="form-group"> {{ Form::text(null, null, ["class" => "form-control", "placeholder" => "Component", "readonly"]) }}</div></div><div class="col-lg-2 col-2"><div class="form-group"> {{ Form::text(null, null, ["class" => "form-control", "placeholder" => "is equal to", "readonly"]) }}</div></div><div class="col-lg-4 col-4"> <select class="form-control js-example-tags" name="customBuild['+cat_id+']['+com_id+'][conditions]['+exitCount+'][]" aria-invalid="false">{!! $options !!}</select></div><div class="col-lg-2 col-2"> <a href="javascript:void(0)" class="btn btn-primary add_form_field"  data-andcount="'+exitCount+'" onclick="addRow('+exitCount+')"> And </a>  <a href="javascript:void(0)" class="btn btn-danger delete" data-andcount="'+exitCount+'" onclick="deleteRow('+exitCount+','+com_id+')"> - </a></div></div></div>');
          }else{
             $('.parent_wrap_'+com_id).append('<div class="add-row_'+exitCount+'"><div class="form-group">{{ Form::label("select_condition_to_display", "Or", ["class" => "control-label required"]) }}</div><div class="form-group condition-row">{{ Form::label("select_condition_to_display", "Select Condition to display", ["class" => "control-label required"]) }}<div class="row"><div class="col-lg-4 col-4"><div class="form-group"> {{ Form::text(null, null, ["class" => "form-control", "placeholder" => "Component", "readonly"]) }}</div></div><div class="col-lg-2 col-2"><div class="form-group"> {{ Form::text(null, null, ["class" => "form-control", "placeholder" => "is equal to", "readonly"]) }}</div></div><div class="col-lg-4 col-4"> <select class="form-control js-example-tags" name="customBuild['+cat_id+']['+com_id+'][conditions]['+1+'][]" aria-invalid="false">{!! $options !!}</select></div><div class="col-lg-2 col-2"> <a href="javascript:void(0)" class="btn btn-primary add_form_field"  data-andcount="'+exitCount+'" onclick="addRow('+exitCount+')"> And </a>  <a href="javascript:void(0)" class="btn btn-danger delete" data-andcount="'+exitCount+'" onclick="deleteRow('+exitCount+','+com_id+')"> - </a></div></div></div>');
          }

      }

</script>


  <script>
    $(function() {
      $("#accordionExample").sortable({
        stop: function (e, ui) {
            var data = $(this).sortable('serialize');
            var obj={};
            $.each(data.split("&"), function (indexInArray, valueOfElement) {
                obj[indexInArray] = valueOfElement.split("=")[1];
            });
            $('#customBuildCatSortId').val(JSON.stringify(obj));
        },
      });
      $(".component-sorting").sortable({
        stop: function (e, ui) {
            var id = ui.item[0].classList[2].split("_")[1];
            var data = $(this).sortable('serialize');
            var obj={};
            $.each(data.split("&"), function (indexInArray, valueOfElement) {
                if(valueOfElement.split("=")[0]!='childSortId[]'){
                    obj[indexInArray] = valueOfElement.split("=")[1];
                }
            });
            $('#childSortId_'+id).val(JSON.stringify(obj));
        },
      });
      var s1 = $(".js-example-tags").select2({
        allowClear: true,
        placeholder: "Add Custom Build tags",
        tags: true,
      });
      s1.val([' ']).trigger("change");
      var s3 = $(".overwrite-component").select2({
        allowClear: true,
        placeholder: "Select Component",
        // tags: true,
      });
      var s2 = $(".custom-build-category").select2({
        allowClear: true,
        placeholder: "Please select Custom Build Category",
      });
      s2.val([' ']).trigger("change");
      $('#custom-build').validate({
        rules: {
          title: {
            required: true,
          },
          description: {
            required: true,
          },
          custom_build_category_id: {
            required: true,
          },
          sku: {
            required: true,
          },
          'tags[]': {
            required: true,
          },
          product_video: {
            required: true,
          },
          technical_specification: {
            required: true,
          },
          is_active: {
            required: true,
          },
        },
        messages: {
          title: {
            required: "Please enter Custom Build title",
          },
          description: {
            required: "Please enter Custom Build description",
          },
          custom_build_category_id: {
            required: "Please select Custom buildcategory",
          },
          sku: {
            required: "Please enter Custom Build sku",
          },
          product_video: {
            required: "Please select Custom Build Product video",
          },
          technical_specification: {
            required: "Please select Technical Specification",
          },
          image: {
            required: "Please select Custom Build image",
          },
          components_helper2: {
            required: "Please select Components",
          },
          is_active: {
            required: "Please select components Status",
          },
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          if (element.prop("type") === "radio") {
            $('.js-error_' + element[0].name).append(error);
          } else {
            element.closest('.form-group').append(error);
          }
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
        $('.submit-btn').prop('disabled', true);
        $(".submit-btn p").remove();
        $(".submit-btn").html("Please wait...");
          form.submit();
        }
      });
      /* Summernote Validation */
      var summernoteForm = $('#custom-build');
      var summernoteElement = $('#summernote');
      var summernoteValidator = summernoteForm.validate({
        errorElement: "div",
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        ignore: ':hidden:not(#summernote),.note-editable.card-block',
        errorPlacement: function(error, element) {
          // Add the `help-block` class to the error element
          error.addClass("invalid-feedback");
          if (element.prop("type") === "checkbox") {
            error.insertAfter(element.siblings("label"));
          } else if (element.has("summernote")) {
            $('#summernotediv').append(error);
            error.insertAfter(element.siblings(".note-editor"));
          } else {
            error.insertAfter(element);
          }
        }
      });
      summernoteElement.summernote({
        height: 300,
        callbacks: {
          onChange: function(contents, $editable) {
            summernoteElement.val(summernoteElement.summernote('isEmpty') ? "" : contents);
            summernoteValidator.element(summernoteElement);
          }
        }
      });

    });

  </script>
  @parent

  <script type="text/javascript">
    var AppBridge = window['app-bridge'];
    var actions = AppBridge.actions;
    var TitleBar = actions.TitleBar;
    var Button = actions.Button;
    var Redirect = actions.Redirect;
    var titleBarOptions = {
      title: 'Add Custom Build',
    };
    var myTitleBar = TitleBar.create(app, titleBarOptions);

  </script>
@endsection
