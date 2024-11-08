<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function __construct()
{
    $this->middleware('auth:admin'); 

    $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index', 'store']]);
    $this->middleware('permission:permission-list', ['only' => ['index']]); 
    $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:permission-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
}









    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $permissions = Permission::get();
        //dd($permissions);
        return view('admin.permission.index', ['permissions' => $permissions]);

        
    


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        // $request->validate([
        //     'name' => [
        //         'required',
        //         'string',
        //         'unique:permissions,name'
        //     ]
        // ]);

        foreach ($request['permission_name'] as $key => $value) {
            Permission::create([
                'name' => $value,
                'guard_name' => 'admin'
            ]);
        }
        

        return redirect()->route('permissions.index')->with('status','Permission Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id); // Find the permission by ID
        return view('admin.permission.edit', compact('permission')); // Load the edit view
    }

    /**
     * Update the specified resource in storage.
     */
    


    public function update(Request $request, $id)
  {
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $permission = Permission::findOrFail($id);
    $permission->name = $request->input('name');
    $permission->save();

    return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
 }



 public function destroy($id)
 {
     $permission = Permission::findOrFail($id); // Find the permission by ID
     $permission->delete(); // Delete the permission from the database
 
     return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully');
 }
 































}
