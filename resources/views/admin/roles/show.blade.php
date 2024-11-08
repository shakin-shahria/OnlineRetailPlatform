@extends('admin.layouts.admin_template')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Role Details</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Role Details</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ $role->name }} Role</h3>
          </div>
          <div class="card-body">
            <h5>Permissions:</h5>
            <ul>
              @forelse ($role->permissions as $permission)
                <li>{{ $permission->name }}</li>
              @empty
                <li>No permissions assigned to this role.</li>
              @endforelse
            </ul>
            <a href="{{ route('roles.index') }}" class="btn btn-primary">Back to Roles</a>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection
