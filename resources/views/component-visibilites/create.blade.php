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
            <h1>Add Component Visibility</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Add Component Visibility</li>
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
              {{--
              <div class="card-header">
                <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
              </div>
              --}}
              <!-- /.card-header -->
              <!-- form start -->
              {{ Form::open(['route' => 'component-visibilites.store', 'role' => 'form', 'method' => 'post', 'id' => 'create-visibility', 'files' => true]) }}
              @include("component-visibilites.form")
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
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


<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->

<script>
$(document).ready(function() {
    $(".card-body").on("click",".add_form_field",function(e){
            var  andcount=$(this).data('andcount');
            <?php
                $addOptions='';
                foreach($componentCategories as $key=>$component){
                    $addOptions .= '<option value="'.$key.'">'.$component.'</option>';
                }
            ?>
            $('.add-row_'+andcount).append('<div class="form-group condition-row">{{ Form::label("select_condition_to_display", "Select Condition to display", ["class" => "control-label required"]) }}<div class="row"><div class="col-lg-4 col-4"><div class="form-group"> {{ Form::text(null, null, ["class" => "form-control", "placeholder" => "Component", "readonly"]) }}</div></div><div class="col-lg-2 col-2"><div class="form-group"> {{ Form::text(null, null, ["class" => "form-control", "placeholder" => "is equal to", "readonly"]) }}</div></div><div class="col-lg-4 col-4"> <select class="form-control js-example-tags" name="conditions['+andcount+'][]" aria-invalid="false">{!! $addOptions !!}</select></div><div class="col-lg-2 col-2"> <a href="javascript:void(0)" class="btn btn-primary add_form_field"  data-andcount="'+andcount+'"> And </a>  <a href="javascript:void(0)" class="btn btn-danger delete" data-andcount="'+andcount+'"> - </a></div></div>');

      var s1 = $(".js-example-tags").select2({
            allowClear: true,
            placeholder: "Select Component Visibility",
            tags: true,
        });

        // s1.val([' ']).trigger("change");

    });

    $(".card-body").on("click",".rule-group",function(e){
        if($('.add-rowrulegroup').children().length==0){
            $('.add-rowrulegroup').append('<div class="add-row_0"><div class="form-group condition-row">{{ Form::label("select_condition_to_display", "Select Condition to display", ["class" => "control-label required"]) }}<div class="row"><div class="col-lg-4 col-4"><div class="form-group"> {{ Form::text(null, null, ["class" => "form-control", "placeholder" => "Component", "readonly"]) }}</div></div><div class="col-lg-2 col-2"><div class="form-group"> {{ Form::text(null, null, ["class" => "form-control", "placeholder" => "is equal to", "readonly"]) }}</div></div><div class="col-lg-4 col-4"> {{ Form::select("conditions[0][]", $componentCategories, null, ["class" => "form-control js-example-tags"]) }} @if ($errors->has("conditions")) <span class="text-danger">{{ $errors->first("conditions") }}</span> @endif</div><div class="col-lg-2 col-2"> <a href="javascript:void(0)" class="btn btn-primary add_form_field"  data-andcount="0"> And </a>  <a href="javascript:void(0)" class="btn btn-danger delete" data-andcount="0"> - </a></div></div></div>');

        }else{
            var childCount = $('.add-rowrulegroup').children().length;
            <?php
                $options='';
                foreach($componentCategories as $key=>$component){
                    $options .= '<option value="'.$key.'">'.$component.'</option>';
                }
            ?>
            $('.add-rowrulegroup').append('<div class="add-row_'+childCount+'"><div class="form-group">{{ Form::label("select_condition_to_display", "Or", ["class" => "control-label required"]) }}</div><div class="form-group condition-row">{{ Form::label("select_condition_to_display", "Select Condition to display", ["class" => "control-label required"]) }}<div class="row"><div class="col-lg-4 col-4"><div class="form-group"> {{ Form::text(null, null, ["class" => "form-control", "placeholder" => "Component", "readonly"]) }}</div></div><div class="col-lg-2 col-2"><div class="form-group"> {{ Form::text(null, null, ["class" => "form-control", "placeholder" => "is equal to", "readonly"]) }}</div></div><div class="col-lg-4 col-4"> <select class="form-control js-example-tags" name="conditions['+childCount+'][]" aria-invalid="false">{!! $options !!}</select></div><div class="col-lg-2 col-2"> <a href="javascript:void(0)" class="btn btn-primary add_form_field"  data-andcount="'+childCount+'"> And </a>  <a href="javascript:void(0)" class="btn btn-danger delete" data-andcount="'+childCount+'"> - </a></div></div></div>');


        }

      var s1 = $(".js-example-tags").select2({
            allowClear: true,
            placeholder: "Select Component Visibility",
            tags: true,
        });
    //   s1.val([' ']).trigger("change");

    });

});
$('.add-rowrulegroup').on('click','.delete',function(e){
    var id = $(this).data('andcount');
    var child = $(".add-row_"+ id).children('.condition-row').length;
    e.preventDefault();
    if(child == 1){
        $(".add-row_"+ id).remove();
    }else{
        $(this).parents(".form-group").remove();
    }
});

    $(function() {
      var s1 = $(".js-example-tags").select2({
        allowClear: true,
        placeholder: "Select Component Visibility",
        tags: true,
      });
      s1.val([' ']).trigger("change");

      $('#create-visibility').validate({
        rules: {
          component_id: {
            required: true,
          },
          description: {
            required: true,
          },
          message_on_disable: {
            required: true,
          },
        },
        messages: {
          component_id: {
            required: "Please enter Component title",
          },
          description: {
            required: "Please enter Component Visibility description",
          },
          message_on_disable: {
            required: "Please enter message on disable",
          },
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
          form.submit();
        }
      });


            /* Summernote Validation */
      var summernoteForm = $('#create-categoy');
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
      title: 'Add Component Visibility',
    };
    var myTitleBar = TitleBar.create(app, titleBarOptions);

  </script>
@endsection
