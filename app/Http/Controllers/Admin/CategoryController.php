<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Common;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Correct import
use Illuminate\Support\Facades\Redirect; // Correct import

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = []; // Initialize the array
        return view('admin.category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $common_model = new Common();      
        $data['all_records'] = $common_model->allCategories();
        return view('admin.category.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category_model = new Category();
        $category_model->category_name = $request->category_name;  
        $category_model->parent_id = $request->parent_id;
        $category_model->level = 0;

        if ($category_model->parent_id) {
            $parent_cat_info = DB::table('categories')->where('category_row_id', $category_model->parent_id)->first();
            $category_model->level = $parent_cat_info->level + 1;
        }

        if ($request->hasFile('category_image')) {
            $category_image = $request->file('category_image');
            $filename = time() . '_' . $category_image->getClientOriginalName();
            $category_image->move(public_path('uploads/category/original/'), $filename);
    
            // Corrected path and method
            $image_resize = Image::read(public_path('uploads/category/original/' . $filename));
            //$image_resize = \Intervention\Image\ImageManagerStatic::make(public_path('uploads/category/original/' . $filename));
            $image_resize->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_resize->save(public_path('uploads/category/thumbnail/' . $filename));
            $category_model->category_image = $filename;
        } else {
            $category_model->category_image = null;    
        }

        $category_model->category_description = $request->long_desc;
        $category_model->is_featured = $request->is_featured ? 1 : 0;

        $category_model->save();

        if ($category_model->parent_id) {
            if ($parent_cat_info->has_child != 1) { 
                DB::table('categories')
                  ->where('category_row_id', $request->parent_id)
                  ->update(['has_child' => 1]);
            }
        }

        // Redirect to the category index with success message
        return Redirect::route('admin.category.index')->with('success', 'Category Created Successfully!');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
