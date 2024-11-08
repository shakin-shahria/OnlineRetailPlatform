@extends('admin.layouts.admin_template')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>User Details</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">User Details</li>
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
            <h3 class="card-title">User: {{ $user->name }}</h3>
          </div>
          <div class="card-body">
            <h5>User Information:</h5>
            <ul>
              <li><strong>Name:</strong> {{ $user->name }}</li>
              <li><strong>Email:</strong> {{ $user->email }}</li>
            </ul>
            <a href="{{ route('users.index') }}" class="btn btn-primary">Back to Users</a>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection
