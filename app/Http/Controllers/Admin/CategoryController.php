<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Common;
use Intervention\Image\Facades\Image; // Corrected import for Image
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $common_model = new Common();      
        $data['all_records'] = $common_model->allCategories(); // Retrieve the categories with parent-child relation
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
            $parent_cat_info = DB::table('categories')
                ->where('category_row_id', $category_model->parent_id)
                ->first();
            $category_model->level = $parent_cat_info->level + 1;
        }

        if ($request->hasFile('category_image')) {
            $category_image = $request->file('category_image');
            $filename = time() . '_' . $category_image->getClientOriginalName();
            $category_image->move(public_path('uploads/category/original/'), $filename);
    
            // Corrected path and method for image resizing
            $image_resize = Image::make(public_path('uploads/category/original/' . $filename));
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

        if ($category_model->parent_id && $parent_cat_info->has_child != 1) {
            DB::table('categories')
                ->where('category_row_id', $request->parent_id)
                ->update(['has_child' => 1]);
        }

        return Redirect::route('category.index')->with('success', 'Category Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // This method is currently empty
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $common_model = new Common();       
        $data['all_records'] = $common_model->allCategories();
        $data['single_info'] = DB::table('categories')
            ->where('category_row_id', $id)
            ->first();

        return view('admin.category.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category_model = Category::find($request->category_row_id); // Fetch the model for the update
        $category_model->category_name = $request->category_name;
        $category_model->parent_id = $request->parent_id;

        // Check if the parent_id has changed
        $parent_id_changed = false;
        $prev_parent_id = DB::table('categories')->where('category_row_id', $request->category_row_id)->first()->parent_id;
        if ($request->parent_id != $prev_parent_id) {
            $parent_id_changed = true;
        }

        // Set the level, which is the parent's level + 1
        $category_model->level = 0;
        if ($category_model->parent_id) {
            $parent_cat_info = DB::table('categories')
                ->where('category_row_id', $category_model->parent_id)
                ->first();
            $category_model->level = $parent_cat_info->level + 1;
        }

        if ($request->hasFile('category_image')) {
            $category_image = $request->file('category_image');
            $filename = time() . '_' . $category_image->getClientOriginalName();
            $category_image->move(public_path('uploads/category/original/'), $filename);

            $image_resize = Image::make(public_path('uploads/category/original/' . $filename));
            $image_resize->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_resize->save(public_path('uploads/category/thumbnail/' . $filename));

            $category_model->category_image = $filename;
        } else {
            // Keep the previous image if not updating
            $prev_category_image = DB::table('categories')
                ->where('category_row_id', $request->category_row_id)
                ->first()->category_image;
            $category_model->category_image = $prev_category_image ?? null;
        }

        $category_model->save();

        // Update has_child status of the current parent
        if ($category_model->parent_id && $parent_cat_info->has_child != 1) {
            DB::table('categories')
                ->where('category_row_id', $request->parent_id)
                ->update(['has_child' => 1]);
        }

        // Update has_child status of the previous parent if changed
        if ($parent_id_changed) {
            $total_child_count = DB::table('categories')
                ->where('parent_id', $prev_parent_id)
                ->count();
            if ($total_child_count == 0) {
                DB::table('categories')
                    ->where('category_row_id', $prev_parent_id)
                    ->update(['has_child' => 0]);
            }
        }

        return Redirect::route('category.index')->with('success', 'Category Updated Successfully!');
    }



    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            // Delete associated image if exists
            if ($category->category_image && file_exists(public_path('uploads/category/' . $category->category_image))) {
                unlink(public_path('uploads/category/' . $category->category_image));
            }

            $category->delete();

            return Redirect::route('category.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }

    
    
}
