<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Attribute;

use Illuminate\Support\Facades\DB;

class AttributesController extends Controller
{
    

    public function __construct()
    {
        $this->middleware('auth:admin'); 
    
        // General permissions required to access index and store actions
        $this->middleware('permission:attribute-list|attribute-create|attribute-edit|attribute-delete', ['only' => ['index', 'store']]);
    
        // Specific permissions for individual actions
        $this->middleware('permission:attribute-list', ['only' => ['index']]);
        $this->middleware('permission:attribute-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:attribute-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:attribute-delete', ['only' => ['destroy']]);
    }
    




    public function index()
    {
        $all_attributes = Attribute::all();
        //dd($all_attributes);
        return view('admin.attributes.index', compact('all_attributes'));
    }

    








    public function create()
    {
        return view('admin.attributes.create');
    }

   











    public function store(Request $request)
    {
        //dd($request);
        //dd(Auth::guard('admin')->user()->id);

        $validated = $request->validate([
            'attribute_name' => 'required',
        ]);

        $attribute_model = new Attribute();
        $attribute_model->attribute_name = $request->input('attribute_name');
        $attribute_model->attribute_value = json_encode($request->input('attribute_values'));
        $attribute_model->created_by = Auth::guard('admin')->user()->id;

        $attribute_model->save();

        // Alert::success('Attribute Created Successfully!', 'success');
        return redirect()->route('attributes.create');
    }

    












    public function show(string $id)
    {
        //
    }

    









    public function edit(string $id)
    {
        // Fetch the specific attribute using Eloquent
        $attribute = Attribute::find($id);

        // Check if the attribute exists
        if (!$attribute) {
            return redirect()->route('attributes.index')->with('error', 'Attribute not found.');
        }

        // Optionally fetch all attributes (if needed for some other logic)
        $all_attributes = Attribute::all();

        // Pass the data to the edit view
        return view('admin.attributes.edit', [
            'attribute' => $attribute,
            'all_attributes' => $all_attributes,
        ]);
    }
    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function update(Request $request, $id)
{
    // Validate the incoming request data
    $validated = $request->validate([
        'attribute_name' => 'required',
    ]);

    // Find the attribute by its primary key
    $attribute_model = Attribute::findOrFail($id);

    // Update the attribute's fields
    $attribute_model->attribute_name = $request->input('attribute_name');
    $attribute_model->attribute_value = json_encode($request->input('attribute_values'));
    $attribute_model->updated_at = now();  // Optionally update the 'updated_at' field

    // Save the updated attribute
    $attribute_model->save();

    // Redirect back with a success message
    return redirect()->route('attributes.index')->with('success', 'Attribute updated successfully!');
}


    


















    public function destroy(string $id)
    {
        //
    }
}
