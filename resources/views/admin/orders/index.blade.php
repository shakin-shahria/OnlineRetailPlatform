@extends('admin.layouts.admin_template')

@section('content')
<!-- Datatable -->
<link rel="stylesheet" href="{{ asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Order Management</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Order Management</li>
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
            <h3 class="card-title">Order Management</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            <table id="order_table" class="table table-bordered table-striped">
              <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Order Number</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
              </thead>
              <tbody>  
                @foreach($all_orders as $order)
                <tr>            
                  <td>{{ $order->id }}</td> 
                  <td>{{ $order->order_number }}</td>
                  <td>{{ $order->total_amount }}</td>
                  <td>{{ $order->status }}</td>


                  <td>
                    <!-- Processing Button -->
                    <form action="{{ route('orders.updateStatus', ['order' => $order->id, 'status' => 'processing']) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-primary">Processing</button>
                    </form>
                
                    <!-- Complete Button -->
                    <form action="{{ route('orders.updateStatus', ['order' => $order->id, 'status' => 'completed']) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-success">Complete</button>
                    </form>
                    
                
                    <!-- Delete Button -->
                    {{-- <form id="deleteOrder_{{$order->id}}" action="{{ url('/')}}/admin/orders/{{$order->id}}" style="display: inline;" method="POST">
                        {{ method_field('DELETE') }}
                        @csrf
                        <input class="btn btn-sm btn-danger deleteLink" order_id="{{ $order->id }}" data-toggle="modal" data-target="#order-delete-modal" value="Delete" style="width: 100px; margin-top: -8px;">
                    </form> --}}
                   




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

<div class="modal modal-danger fade" id="order-delete-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Order</h4>
      </div>
      <div class="modal-body">
        <p>Do you really want to delete order with ID <b class="orderid"></b>?</p>
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
      $('#order_table').DataTable({
      	"order": [],
      });

      $('.deleteLink').click(function(){
      	var order_id = $(this).attr('order_id');
      	$('#order-delete-modal .orderid').text(order_id);
      	$('#order-delete-modal .submitDeleteModal').attr('order_id', order_id);
      });

      $('.submitDeleteModal').click(function(){
      	var order_id = $(this).attr('order_id');
      	$('#deleteOrder_' + order_id).submit();
      });
  });
</script>
@endsection
