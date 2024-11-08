@extends('admin.layouts.admin_template')

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Edit Permission</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="permission_name">Permission Name</label>
                <input type="text" name="name" id="permission_name" class="form-control" value="{{ $permission->name }}" required>
              </div>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
