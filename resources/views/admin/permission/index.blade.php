@extends('admin.layouts.admin_template')

@section('content')
<!-- Datatable -->
<link rel="stylesheet" href="{{ asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Permission Management</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Permission Management</li>
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
            <h3 class="card-title">Permission Management</h3>
            <a class="btn btn-primary float-end" style="float:right" href="{{ route('permissions.create') }}">Add New Permission</a>
          </div>
          <div class="card-body">
            <table id="attribute_table" class="table table-bordered table-striped">
              <thead>
                  <tr>
                    <th>Sl.</th>
                    <th>Permission Name</th>
                    <th>Action</th>
                  </tr>
              </thead>
              <tbody>  
                    @foreach($permissions as $row)  
                    <tr>            
                      <td>{{ $row['id'] }}</td> 
                      <td align="center">{{ $row['name'] }}</td>
                      <td>
                         <a href="{{ route('permissions.edit', $row['id']) }}" class="btn btn-sm btn-warning mb-2">Edit</a>

                        <!-- Delete Form with Data Attributes -->
                        <form id="deleteCategory_{{ $row['id'] }}" action="{{ route('permissions.destroy', $row['id']) }}" style="display: inline;" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="button" 
                                  class="btn btn-sm btn-danger deleteLink" 
                                  data-toggle="modal" 
                                  data-target="#category-delete-modal"
                                  data-category-name="{{ $row['name'] }}" 
                                  data-category-row-id="{{ $row['id'] }}">
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

<!-- Delete Confirmation Modal -->
<div class="modal modal-danger fade" id="category-delete-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete Permission</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Do you really want to delete <b class="catname"></b> permission?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline submitDeleteModal">Delete</button>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function() {
      $('#attribute_table').DataTable({
          "order": []
      });

      // Open modal and set permission details
      $('.deleteLink').click(function(){
          var category_name = $(this).data('category-name');
          var category_row_id = $(this).data('category-row-id');
          $('#category-delete-modal .catname').text(category_name);
          $('.submitDeleteModal').data('category-row-id', category_row_id);
      });

      // Submit delete form on modal confirmation
      $('.submitDeleteModal').click(function(){
          var category_row_id = $(this).data('category-row-id');
          $('#deleteCategory_' + category_row_id).submit();
      });
  });
</script>
@endsection
