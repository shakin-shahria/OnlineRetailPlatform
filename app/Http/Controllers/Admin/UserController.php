<?php
    
namespace App\Http\Controllers\Admin;
    
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

    
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $data = Admin::latest()->paginate(5);
  
        return view('admin.users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $roles = Role::pluck('name','name')->all();

        return view('admin.users.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = Admin::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($id): View
     {
        $user = Admin::find($id);

         return view('admin.users.show',compact('user'));
    }



    

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //  public function destroy($id): RedirectResponse
    //  {
    //      User::find($id)->delete();
    //      return redirect()->route('users.index')
    //                      ->with('success','User deleted successfully');
    // }


//     public function destroy($id)
// {
//     //try {
//         // Find the user by ID
//         $admin = Admin::findOrFail($id);

//         // Delete the user
//         $admin->delete();

//         // Redirect back with a success message
//      //   return redirect()->route('users.index')->with('success', 'User deleted successfully.');
//    // } catch (\Exception $e) {
//         // Handle the error if the user could not be deleted
//        return redirect()->route('users.index')->with('error', 'Failed to delete user.');
//     //}
// }


public function destroy($id)
{
    // Find the user by ID
    $admin = Admin::find($id);

    // Check if user exists
    if ($admin) {
        // Delete the user
        $admin->delete();

        // Redirect with success message
        return redirect()->route('users.index');
    }

    // If user not found, redirect with error message
    return redirect()->route('users.index');
}













    public function edit($id)
{
    // Retrieve the user by ID
    $user = Admin::findOrFail($id);

    // Return the edit view with user data
    return view('admin.users.edit', compact('user'));
}

public function update(Request $request, $id)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id, // Ignore current user email for uniqueness
        'password' => 'nullable|min:8' // Password is optional
    ]);

    // Find the user by ID
    $admin = Admin::findOrFail($id);

    // Update user fields
    $admin->name = $request->input('name');
    $admin->email = $request->input('email');
    if ($request->filled('password')) {
        $admin->password = bcrypt($request->input('password'));
    }

    // Save changes
    $admin->save();

    // Redirect with success message
    return redirect()->route('users.index')->with('success', 'User updated successfully');
}

















}
