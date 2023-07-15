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
            <h1>Update Accessory</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Update Accessory</li>
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
              {!! Form::model($accessory, ['route' => ['accessories.update', $accessory->id], 'role' => 'form', 'method' => 'PATCH', 'files' => true, 'id' => 'edit-Accessory']) !!}
              @include("accessories.form")
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
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
      var s1 = $(".js-example-tags").select2({
        allowClear: true,
        placeholder: "Select Accessory Category",
        tags: true,
      });
      @if (isset($accessory) && $accessory->category_id == null)
        s1.val([' ']).trigger("change");
      @endif
      var s2 = $(".js-brand-tags").select2({
        allowClear: true,
        placeholder: "Select Accessory Brand",
        tags: true,
      });
      @if (isset($accessory) && $accessory->brand_id == null)
        s2.val([' ']).trigger("change");
      @endif
      $('#edit-Accessory').validate({
        rules: {
          title: {
            required: true,
          },
          description: {
            required: true,
          },
          regular_price: {
            required: true,
            number: true
          },
          special_price: {
            number: true
          },
          sku: {
            required: true,
          },
          stock: {
            required: true,
            number: true
          },
          is_active: {
            required: true,
          },
        },
        messages: {
          title: {
            required: "Please enter Accessory title",
          },
          description: {
            required: "Please enter Accessory description",
          },
          image: {
            required: "Please select Accessory image",
          },
          is_active: {
            required: "Please select Accessory Status",
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
      var summernoteForm = $('#edit-Accessory');
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
      title: 'Edit Accessory',
    };
    var myTitleBar = TitleBar.create(app, titleBarOptions);

  </script>
@endsection
