@extends('admin.layouts.admin_template')

@section('content')
<!-- Datatable -->
<link rel="stylesheet" href="{{ asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Category Management</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Category Management</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Category Management</h3>
          </div>
          <div class="card-body">

            <!-- Display Success and Error Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <table id="category_table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Category Name</th>
                  <th>Category Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data['all_records'] as $row)
                <tr>
                  <td>
                    @if($row->level == 0) <b> @endif
                    @if($row->level == 1) &nbsp; - @endif
                    @if($row->level == 2) &nbsp; &nbsp; - - @endif
                    @if($row->level == 3) &nbsp; &nbsp; &nbsp; - - - @endif
                    @if($row->level == 4) &nbsp; &nbsp; &nbsp; &nbsp; - - - - @endif
                    @if($row->level == 5) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - - - @endif
                    @if($row->level > 5) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - - - @endif
                    {{ $row->category_name }}
                    @if($row->level == 0) </b> @endif
                  </td>
                  <td align="center">
                    @if($row->category_image)
                    <img src="{{ asset('uploads/category/thumbnail').'/'.$row->category_image }}" alt="" width="80px">
                    @else
                    <img src="{{ asset('uploads/category/no_category.png') }}" alt="" width="50px" height="50px">
                    @endif
                  </td>
                  <td align="center">
                    <!-- Edit Button -->
                    <button onclick="window.location='{{ url('/')}}/admin/category/{{$row->category_row_id}}/edit'" class="btn btn-warning mb-2" style="margin-top: 8px;">Edit</button>

                    <!-- Delete Form -->
                    <form id="deleteCategory_{{$row->category_row_id}}" action="{{ route('category.destroy', $row->category_row_id) }}" method="POST" style="display: inline;">
                      @csrf
                      @method('DELETE')
                      <!-- Directly submit the form on button click -->
                      <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?');">
                        Delete
                      </button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="{{ asset('admin_files/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_files/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#category_table').DataTable({
      "order": [],
    });
  });
</script>
@endsection
