@extends('admin.layouts.admin_template')

@section('content')
<!-- Datatable -->

<link rel="stylesheet" href="{{ asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Roles Management</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Roles Management</li>
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
            <h3 class="card-title">Roles Management</h3>
            <div class="pull-right" style="float:right">
              <a class="btn btn-success mb-2" href="{{ route('roles.create') }}"><i class="fa fa-plus"></i> Create New Role</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="product_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>SL.</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php $count = 1; @endphp
                @foreach ($roles as $role)
                <tr>
                  <td>{{ $count }}</td>
                  <td>{{ $role->name }}</td>
                  <td>
                    <a class="btn btn-warning" href="{{ url('admin/roles/'.$role->id.'/give-permissions') }}">Add / Edit Role Permission</a>
                    <a class="btn btn-info btn-sm" href="{{ route('roles.show',$role->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                    <a class="btn btn-primary btn-sm" href="{{ route('roles.edit',$role->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <form method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display:inline" onsubmit="return confirmDelete();">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                    </form>
                  </td>
                </tr>
                @php $count++; @endphp
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->

<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function() {
      $('#product_table').DataTable({
        "order": [],
      });
  });

  function confirmDelete() {
      return confirm('Are you sure you want to delete this role?');
  }
</script>
@endsection
