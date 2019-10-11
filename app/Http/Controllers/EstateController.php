<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estate;
use App\Http\Resources\Estate as EstateResource;

class EstateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estates = Estate::all();
        $allestates = EstateResource::collection($estates); //Use Resource to format Output 
        $res['message'] = 'All Estates';
        $res['Estates'] = $allestates;
        return response()->json($res, 200);
    }
   

    // Display Estates by City 

    public function showCity($city)
    {
        
        $estates = Estate::where('city', $city)->get();
        if ($estates ->isEmpty()){
           //Error Handling
            $res['Error']    = "No Estates found";
            return response()->json($res, 404);  
            
        }else
            $allestates = EstateResource::collection($estates); //Use Resource to format Output 
            return response()->json($allestates);  
    }
    
    // Display Estates by Country 

    public function showCountry($country)
    {   
        $estates = Estate::where('country', $country)->get();
        if ($estates ->isEmpty()){
           // Error Handling
            $res['Error']    = "No Estates found";
            return response()->json($res, 404);  
        }else
            
            $allestates = EstateResource::collection($estates); //Use Resource to format Output 
            return response()->json($allestates);  
    }
    


public function store(Estate $request)
{
    $data =$request->all();
    if($request->create($data)){
        return response()->json($data);
    }

    $res['Error']    = "Something went wrong please";
    return response()->json($res, 400);


}

public function update(Estate $estate)
{
    $data =request()->all();
    if(empty($data['estate_name'])){
        $estate->estate_name = $data['estate_name'];
    }
    else if(empty($data['city'])){
        $estate->city = $data['city'];
    }
    else if (empty($data['country'])){
        $estate->country = $data['country'];
    }
    $data= $estate->update();
    return response()->json($data, 'User updated successfully');

}

// Delete Estates by id 
    
public function deleteEstate($id)
{   
    $estates = Estate::where('estate_id', $id)->get();
    $estates->delete();
    
    // Success message
    $res['message']    = "Estate deleted";
    return response()->json($res, 200);  
}
    
}
