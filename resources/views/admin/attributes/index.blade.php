@extends('admin.layouts.admin_template')

@section('content')
<!-- Datatable -->

<link rel="stylesheet" href="{{ asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Attribute Management</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Attribute Management</li>
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
            <h3 class="card-title">Attribute Management</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            <table id="attribute_table" class="table table-bordered table-striped">
              <thead>
                  <tr>
                    <th>Attribute Name</th>
                    <th>Attribute Values</th>
                    <th>Action</th>
                  </tr>
              </thead>
              <tbody>  
                    @foreach($all_attributes as $row)
                    @php
                      $attribute_values = json_decode($row->attribute_value);
                      //print_r($attribute_values);
                    @endphp   
                    <tr>            
                      <td>{{ $row->attribute_name }}</td> 
                      <td align="center">
                        @foreach($attribute_values as $values)
                          <button class="btn btn-sm btn-primary" style="margin:0 5px;">{{ $values }}</span>
                        @endforeach
                      </td>
                      <td>
                        <button onclick="window.location='{{ url('/')}}/admin/category/{{$row->attribute_row_id }}/edit'" class="btn btn-sm btn-warning mb-2">Edit</button>
                        <form id="deleteCategory_{{$row->attribute_row_id }}" action="{{ url('/')}}/admin/category/{{$row->attribute_row_id }}" style="display: inline;" method="POST">
                          {{ method_field('DELETE') }}
                          @csrf
                          <input class="btn btn-sm btn-danger deleteLink" category_name="{{ $row->category_name }}" attribute_row_id ="{{$row->attribute_row_id }}" data-toggle="modal" data-target="#category-delete-modal" deleteID="{{$row->attribute_row_id }}" value="Delete" style="width: 100px; margin-top: -8px;">
                        </form>
                      </td>                        
                    </tr>
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


<div class="modal modal-danger fade" id="category-delete-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Category</h4>
      </div>
      <div class="modal-body">
        <p>Do you really want to delete <b class="catname"></b> category?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline submitDeleteModal">Submit</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script src="{{ asset('admin_files/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_files/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function() {
      $('#example1').DataTable({
      	"order": [],
      });

      $('.deleteLink').click(function(){
      	var category_name = $(this).attr('category_name');
      	var category_row_id = $(this).attr('category_row_id');
      	console.log(category_name);
      	$('#category-delete-modal .catname').empty();
      	$('#category-delete-modal .catname').append(category_name);
      	$('#category-delete-modal .submitDeleteModal').attr('category_row_id', category_row_id);
      });

      $('.submitDeleteModal').click(function(){
      	var category_row_id = $(this).attr('category_row_id');
        console.log(category_row_id);
      	$('#deleteCategory_'+category_row_id).submit();
      });
  });
</script>
@endsection