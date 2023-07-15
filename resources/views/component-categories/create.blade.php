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
            <h1>Add Component Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Add Component Category</li>
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
              {{ Form::open(['route' => 'component-categories.store', 'role' => 'form', 'method' => 'post', 'id' => 'create-categoy', 'files' => true]) }}
              @include("component-categories.form")
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
  <script>
    $(function() {
      //Bootstrap Duallistbox
      $('.duallistbox').bootstrapDualListbox()
      $('#create-categoy').validate({
        rules: {
          title: {
            required: true,
          },
          description: {
            required: true,
          },
        //   image: {
        //     required: true,
        //   },
          //   components_helper2: {
          //     required: true,
          //   },
          is_active: {
            required: true,
          },
        },
        messages: {
          title: {
            required: "Please enter Component Category title",
          },
          description: {
            required: "Please enter Component Category description",
          },
          image: {
            required: "Please select Component Category image",
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
            $('.js-error').append(error);
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
      title: 'Add Component Categories',
    };
    var myTitleBar = TitleBar.create(app, titleBarOptions);

  </script>
@endsection
