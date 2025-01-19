@extends('admin.layouts.admin_template')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="d-flex justify-content-between align-items-center py-3">
        <h1 class="text-primary font-weight-bold">Dashboard Overview</h1>
        <div>
            <button class="btn btn-sm btn-primary shadow-sm me-2">Refresh</button>
            <button class="btn btn-sm btn-outline-secondary">Settings</button>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="content">
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-header bg-gradient-primary text-white">
            <h5 class="mb-0">Welcome to the Admin Dashboard</h5>
        </div>
        <div class="card-body">
            <p class="text-muted mb-3">
                Here you can manage your application settings, users, and analytics. Use the menu on the left to navigate through the dashboard features.
            </p>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card bg-light text-center shadow-sm">
                        <div class="card-body">
                            <h6>Total Users</h6>
                            <h3 class="font-weight-bold">1,234</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-light text-center shadow-sm">
                        <div class="card-body">
                            <h6>Active Sessions</h6>
                            <h3 class="font-weight-bold">567</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-light text-center shadow-sm">
                        <div class="card-body">
                            <h6>Pending Tasks</h6>
                            <h3 class="font-weight-bold">42</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
