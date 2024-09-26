@extends('admin.layouts.admin_template')

@section('content')
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Attribute</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Edit Attribute</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" action="{{ route('attributes.update', $attribute->attribute_row_id) }}" method="POST">
            @csrf
            @method('PUT') <!-- This method ensures the form uses a PUT request -->
            <div class="card-body">

              <div class="form-group">
                <label for="attribute_name">Attribute Name</label>
                <input type="text" class="form-control" id="attribute_name" name="attribute_name" 
                  value="{{ old('attribute_name', $attribute->attribute_name) }}" placeholder="Enter Attribute Name">
              </div>
              
              <div class="col-md-12 form_sec_outer_task border ">
                <div class="row">
                  <div class="col-md-12 bg-light p-2 mb-3">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-md-6">
                            <h4 class="frm_section_n">Attribute Values</h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 p-0">
                  <div class="col-md-12 form_field_outer p-0">
                    @php
                      $attribute_values = json_decode($attribute->attribute_value);
                    @endphp

                    @foreach($attribute_values as $value)
                      <div class="row form_field_outer_row">
                        <div class="form-group col-md-6">
                          <input type="text" class="form-control w_90" name="attribute_values[]" placeholder="Enter values" value="{{ $value }}" />
                        </div>
                        <div class="form-group col-md-2 add_del_btn_outer">
                          <button class="btn_round remove_node_btn_frm_field" type="button">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </div>
                      </div>
                    @endforeach

                    <button class="btn btn-outline-lite py-0 add_new_frm_field_btn" type="button" style="color: #fff;">
                      <i class="fas fa-plus add_icon" style="color: #fff;"></i> Add More
                    </button>
                  </div>
                </div>
              </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <input type="submit" value="Update Attributes" class="btn btn-success">
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div>
      <!--/.col (right) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<script type="text/javascript">
  $(document).ready(function(){
    // Add new attribute value input
    $("body").on("click", ".add_new_frm_field_btn", function () { 
      var index = $(".form_field_outer").find(".form_field_outer_row").length + 1;
      $(".form_field_outer").append(`
        <div class="row form_field_outer_row">
          <div class="form-group col-md-6">
            <input type="text" class="form-control w_90" name="attribute_values[]" placeholder="Enter values" />
          </div>
          <div class="form-group col-md-2 add_del_btn_outer">
            <button class="btn_round remove_node_btn_frm_field" type="button">
              <i class="fas fa-trash-alt"></i>
            </button>
          </div>
        </div>
      `);
    });

    // Remove the attribute value input field
    $("body").on("click", ".remove_node_btn_frm_field", function () {
      $(this).closest(".form_field_outer_row").remove();
    });
  });
</script>

@endsection
