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
            <h1>All Promotions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active">Promotions</li>
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
                  <div class="col-sm-5"></div>
                  <div class="col-sm-5"></div>
                  <div class="col-sm-2">
                    <a href="{{ route('promotion.create') }}" class="btn btn-block btn-outline-primary">Add New</a>
                  </div>
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="promotions-table" class="table table-bordered table-hover" style="width: 100%;">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Title</th>
                      <th>Image</th>
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
      title: 'Promotions',
    };
    var myTitleBar = TitleBar.create(app, titleBarOptions);

  </script>
  <script>
    $(function() {
      var dataTable = $('#promotions-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '{!! route('get.promotion') !!}',
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
          {
            data: 'image',
            name: 'image',
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
          [4, "desc"]
        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex) {
          $("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
          return nRow;
        }
      });

    });

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
                $('#promotions-table').DataTable().draw();
              });
            }
          });
        }
      })
    }

  </script>
@endsection
