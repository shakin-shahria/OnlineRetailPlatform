<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Common;
use App\Models\Attribute;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderProduct;


class ApiController extends Controller
{
    public function getCategories(){
        $common_model = new Common();      
        $all_categories = $common_model->allCategories();

        $category_array = array();
        foreach ($all_categories as $category_data) {
            $cid = $category_data->category_row_id;
            
            if($category_data->parent_id == 0){
                $category_array[$cid]['category_name'] = $category_data->category_name;
                $category_array[$cid]['category_image'] = $category_data->category_image;
                
            } else {
                $pcount = Product::where('category_id', $cid)->count();

                $category_array[$category_data->parent_id]['subcategory'][$cid]['category_name'] = $category_data->category_name;
                $category_array[$category_data->parent_id]['subcategory'][$cid]['category_image'] = $category_data->category_image;
                $category_array[$category_data->parent_id]['subcategory'][$cid]['product_count'] = $pcount;
            }
        }

        if(isset($category_array)){
			return response()->json($category_array);	
		} else {
			return response()->json(['error' => 'No Categories Found'], 500);
		}
    }







    public function getProductsByCategoryId($cid){
        if(is_numeric($cid) && $cid > 0){

            $products = Product::with('product_images', 'product_inventory', 'product_attribute', 'getCategory')->where('category_id', $cid)->get();

            if(isset($products)){
                return response()->json($products);  
            } else {
                return response()->json(['error' => 'Wrong Category ID provided'], 500);
            }
            
        } else {
            return response()->json(['error' => 'Category ID is not valid, ID should be numeric'], 500);
        }
    }





    //IN thi we are getting the Filtered Product details which we will need in Frontend.
    public function getProductsById($pid){

    	if(is_numeric($pid) && $pid > 0){
            $product_full_details = array();
    		$product_details = Product::with('product_images', 'product_inventory', 'product_attribute', 'getCategory')->where('product_id', $pid)->first();
            $product_full_details['product_details'] = $product_details;
            $product_attributes = $product_details->product_attribute;
            //dd($product_attributes);
            $size_array = array();
            $size_numeric_array = array();
            $color_array = array();
            $other_array = array();
            $main_array = array();
            $all_attributes = Attribute::all(); 
       
            foreach ($all_attributes as $key => $value) {
            if($value->attribute_name == 'Size'){
                $main_array['size'] = json_decode($value->attribute_value, true);
            } elseif($value->attribute_name == 'Color'){
                $main_array['color'] = json_decode($value->attribute_value, true);
            } elseif($value->attribute_name == 'Size (Numeric)'){
                $main_array['size_numeric'] = json_decode($value->attribute_value, true);
            } else {
                $main_array['other'] = json_decode($value->attribute_value, true);
            }
            }

            //dd($product_attributes);

            foreach ($product_attributes as $pakey => $pavalue) {
                $parray = explode("+", $pavalue['attribute_title']);
                foreach ($parray as $key => $value) {
                //echo $value.'<br>';
                if(in_array(trim($value), $main_array['size'])){
                    $size_array[] = trim($value); 
                } elseif(in_array(trim($value), $main_array['color'])){
                    $color_array[] = trim($value);
                } elseif(in_array(trim($value), $main_array['size_numeric'])){
                    $size_numeric_array[] = trim($value);
                } else {
                    $other_array[] = trim($value);
                }
                }
                
            }
            $size_data = array_unique($size_array);
            $color_data = array_unique($color_array);
            $size_numeric_data = array_unique($size_numeric_array);

            $product_full_details['size_data'] = $size_data;
            $product_full_details['color_data'] = $color_data;
            $product_full_details['size_numeric_data'] = $size_numeric_data;


    		if(isset($product_details)){
    			return response()->json($product_full_details);	
    		} else {
    			return response()->json(['error' => 'Wrong Product ID provided'], 500);
    		}
    		
    	} else {
    		return response()->json(['error' => 'Product ID is not valid, ID should be numeric'], 500);
    	}

    }








    public function getAllFeaturedCategory(){

        $featured_category = Category::where('is_featured', 1)->withCount('total_products')->get();
        if(isset($featured_category)){
            return response()->json($featured_category);  
        } else {
            return response()->json(['error' => 'No featured category found'], 500);
        }
    }





// The product Searching option in the Frontend
    public function search(Request $request){
        // Validate the search query
        $request->validate([
            'query' => 'required|string|min:1'
        ]);

        // Search products based on the query
        $query = $request->input('query');

        $products = Product::where('product_title', 'like', "%$query%")
                           ->orWhere('short_description', 'like', "%$query%")
                           ->get();

        return response()->json($products);
    }




    public function submitOrderDetails(Request $request){

        // create new user using order information
        $name = $request->firstname.' '.$request->lastname;
        $username = strtolower($request->firstname).strtolower($request->lastname);
        $email = $request->email;
        $mobile_number = $request->mobileNumber;
        $cartTotal = $request->cartTotal;
        $cartItems = $request->cartItems;
        $order_information = array();

        $user = User::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'phone' => $mobile_number,
            'role' => 'site-user'
        ]);

        $order_information['user_data'] = $user;

        $order_db = new Order();
        $order_db->order_number = 'ORD-'.date('ymdhi').mt_rand(1000,9999);
        $order_db->total_amount = $cartTotal;
        $order_db->status = 'pending';
        $order_db->description = '';
        $order_db->user_id = $user->id;
        $order_db->save();

        $order_information['order_data'] = $order_db;

        foreach($cartItems as $key=>$data){
            //return response()->json($data);
            $orderproduct_db = new OrderProduct();
            $orderproduct_db->order_id = $order_db->id;
            $orderproduct_db->product_id = $data['product_id'];
            $orderproduct_db->quantity = $data['quantity'];
            $orderproduct_db->price = $data['product_price'] * $data['quantity'];
            $orderproduct_db->save();
        }


        return response()->json($order_information);
        //return response()->json([$request->all()]);

    }




    public function getAllOrders()
    {
        // Fetch all orders from the database
        $orders = Order::all();

        // Return orders as JSON response
        return response()->json($orders);
    }
   


    public function getOrderById($id)
    {
        // Fetch the order by ID
        $order = Order::find($id);

        // If the order is not found, return a 404 error response
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Return the order data as JSON response
        return response()->json($order);
    }



    public function getLatestOrder()
    {
        // Fetch the latest order based on created_at, order by latest first
        $latestOrder = Order::orderBy('updated_at', 'desc')->first();
    
        // If no order is found, return a 404 error response
        if (!$latestOrder) {
            return response()->json(['message' => 'No orders found'], 404);
        }
    
        // Return the latest order data as JSON response
        return response()->json($latestOrder);
    }
    




}



























































































































// namespace App\Http\Controllers;

// use Illuminate\Http\Request; 
// use App\Models\Category;
// use App\Models\Product;
// use App\Models\Common;

// class ApiController extends Controller
// {
//     public function getCategories(){
//         $common_model = new Common();      
//         $all_categories = $common_model->allCategories();

//         $category_array = array();
//         foreach ($all_categories as $category_data) {
//             $cid = $category_data->category_row_id;
            
//             if($category_data->parent_id == 0){
//                 $category_array[$cid]['category_name'] = $category_data->category_name;
//                 $category_array[$cid]['category_image'] = $category_data->category_image;
                
//             } else {
//                 $pcount = Product::where('category_id', $cid)->count();

//                 $category_array[$category_data->parent_id]['subcategory'][$cid]['category_name'] = $category_data->category_name;
//                 $category_array[$category_data->parent_id]['subcategory'][$cid]['category_image'] = $category_data->category_image;
//                 $category_array[$category_data->parent_id]['subcategory'][$cid]['product_count'] = $pcount;
//             }
//         }

//         if(isset($category_array)){
// 			return response()->json($category_array);	
// 		} else {
// 			return response()->json(['error' => 'No Categories Found'], 500);
// 		}
//     }

//     public function getProductsByCategoryId($cid){
//         if(is_numeric($cid) && $cid > 0){

//             $products = Product::with('product_images', 'product_inventory', 'product_attribute', 'getCategory')->where('category_id', $cid)->get();

//             if(isset($products)){
//                 return response()->json($products);  
//             } else {
//                 return response()->json(['error' => 'Wrong Category ID provided'], 500);
//             }
            
//         } else {
//             return response()->json(['error' => 'Category ID is not valid, ID should be numeric'], 500);
//         }
//     }

//     public function getProductsById($pid){

//     	if(is_numeric($pid) && $pid > 0){
//     		$product_details = Product::with('product_images', 'product_inventory', 'product_attribute', 'getCategory')->where('product_id', $pid)->first();
//     		if(isset($product_details)){
//     			return response()->json($product_details);	
//     		} else {
//     			return response()->json(['error' => 'Wrong Product ID provided'], 500);
//     		}
    		
//     	} else {
//     		return response()->json(['error' => 'Product ID is not valid, ID should be numeric'], 500);
//     	}

//     }
// }
