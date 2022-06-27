<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Items;
use App\Models\Categories;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ItemController extends Controller
{
  
    public function index()
    {
       // $category = Categories::where('id',$category_id)->first();
$records=Items::where('available',1)->paginate(10);

//$result['items'][] = array('id' => $records[1]['id'], 'name' => $records[1]['name'], 'description' => $records[1]['description'], 'image' => $records[1]['image'], 'price' => $records[1]['price'],'category_id' => $records[1]['category_id'],'created_at' => $records[1]['created_at'],'available' => $records[1]['available'],'has_variants' => $records[1]['has_variants'],'icon' => $records[1]['icon'],); 

       // $records = $category->items->orderBy('id','desc')->where('available',1)->paginate(20)->withQueryString();
        $response = [
            //'success' => true,
            'data'    => $records,
            //'message' => 'Success',
        ];
        return response()->json($response,200);
    }

    public function search_by_name($name)
    {
        $records= Items::where('name', 'like', '%' . $name . '%')->get();
        if(count($records) > 0)
        {
        $response = [
            'status' => true,
            'data'    => $records,
            'message' => 'Success',
        ];
        return response()->json($response,200);
    }
    else
    {
        return response()->json([
            //'data' => Order::where('client_id', auth()->user()->id)->orderBy('id', 'DESC')->limit(50)->with(['restorant', 'status', 'items', 'address', 'driver'])->get(),
     
            'status' => false,
            'message' => '',
        ]);  
    }

    }
    public function indexByCategory($id)
    {
       // $category = Categories::where('id',$category_id)->first();
$records=Items::where('available',1)->where('category_id',$id)->paginate(10);
       // $records = $category->items->orderBy('id','desc')->where('available',1)->paginate(20)->withQueryString();
        $response = [
            'success' => true,
            'data'    => $records,
            'message' => 'Success',
        ];
        return response()->json($response,200);
    }

    public function getitembyID($id)
    {
       // $category = Categories::where('id',$category_id)->first();
       $records=Items::where('available',1)->where('id',$id)->first();
       // $records = $category->items->orderBy('id','desc')->where('available',1)->paginate(20)->withQueryString();
        $response = [ 
            'id' => $records->id,
            'image' => $records->image,
            'price' => $records->price,
            'name' => $records->name,
            'description' => $records->description,
           
            'available' => $records->available,
            'created_at' => $records->created_at,

  
        ];
            
        return response()->json($response,200);
    }
}
