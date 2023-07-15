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
            <h1>All Components</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Components</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row mb-2 justify-content-between">
                  <!-- <div class="col-sm-2">
                    <div class="form-group input-daterange">
                      <label><strong>Filter By Date :</strong></label>
                      <input type="date" class="form-control" name="date" id="date">
                    </div>
                  </div> -->

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Filter By Date:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                        <input type="text" class="form-control float-right" id="reservation" readonly autocomplete="off" placeholder="Please Select Date">
                      </div>
                      <!-- /.input group -->
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label><strong>Filter By Category :</strong></label>
                      <select id='cat_id' class="form-control js-example-tags">
                        <option value="">Select Component Category</option>
                        @foreach ($componentCategories as $id => $title)
                          <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-2">
                    <a href="{{ route('components.create') }}" class="btn btn-block btn-outline-primary">Add New</a>
                  </div>
                </div>
                {{-- <div class="col-sm-2 clearFilter" > --}}
                <a href="javascript:;" class="clearFilter" style="display:none;" onclick="clearFilter()">Clear Filter</a>
                {{-- </div> --}}
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="component-table" class="table table-bordered table-hover" style="width: 100%;">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Component Title</th>
                      {{-- <th>Component Desciption</th> --}}
                      <th>Component Category</th>
                      <th>Component Brand</th>
                      <th>Image</th>
                      <th>Price</th>
                      <th>Stock</th>
                      <th>Sku</th>
                      <th>Is Active</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
          </div>

          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->
  @include('includes.footer')
@endsection
@section('scripts')
  @parent

  <script type="text/javascript">
    var AppBridge = window['app-bridge'];
    var actions = AppBridge.actions;
    var TitleBar = actions.TitleBar;
    var Button = actions.Button;
    var Redirect = actions.Redirect;
    var titleBarOptions = {
      title: 'Components',
    };
    var myTitleBar = TitleBar.create(app, titleBarOptions);

  </script>
  <script>
    $(function() {
            $('#reservation').daterangepicker();
            $("#reservation").val('');

      var s1 = $(".js-example-tags").select2({
        allowClear: true,
        placeholder: "Select Component Category",
        tags: true,
      });
      s1.val([' ']).trigger("change");
      var dataTable = $('#component-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '{!! route('get.components') !!}',
          data: function(d) {
            d.date = $('#reservation').val(),
            d.cat_id = $('#cat_id').val()
          },
          type: 'post'
        },
        columns: [{
            data: null,
            searchable: false,
            sortable: false
          },
          {
            data: 'title',
            name: 'title',
            "width": "15%"
          },
          //   {
          //     data: 'description',
          //     name: 'description',
          //   },
          {
            data: 'category_title',
            name: 'cc.title',
            "width": "15%"
          },
          {
            data: 'brand_title',
            name: 'cb.title',
            "width": "15%"
          },
          {
            data: 'image',
            name: 'image',
          },
          {
            data: 'regular_price',
            name: 'regular_price'
          },
          {
            data: 'stock',
            name: 'stock'
          },
          {
            data: 'sku',
            name: 'sku'
          },
          {
            data: 'is_active',
            name: 'is_active'
          },
          {
            data: 'created_at',
            name: 'created_at',
            "width": "10%"
          },
          {
            data: 'actions',
            name: 'actions',
            searchable: false,
            sortable: false,
            "width": "10%"
          }
        ],
        order: [
          [9, "desc"]
        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex) {
          $("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
          return nRow;
        }
      });
      $('#reservation').change(function() {
        $('.clearFilter').show();
        dataTable.draw();
      });

      $('#cat_id').change(function() {
        $('.clearFilter').show();
        dataTable.draw();
      });

    });


    function clearFilter() {
      $(".js-example-tags").val([' ']).trigger("change");
      $('#reservation').val('');
      $('#component-table').DataTable().draw();
      $('.clearFilter').hide();
    }

    function deleteRecorded(id) {
      var url = $('.delete_' + id).data('url');
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: url,
            data: {
              _method: 'DELETE'
            },
            dataType: "json",
            success: function(response) {
              Swal.fire({
                title: 'Deleted!',
                text: "Yours has been deleted.",
                icon: 'success',
              }).then((result) => {
                window.location.reload();
              });
            }
          });
        }
      })
    }

  </script>
@endsection
