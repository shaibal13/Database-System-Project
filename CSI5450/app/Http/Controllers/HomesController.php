<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homes;
use App\Models\Location;

class HomesController extends Controller
{
    // Get all the home list
    public function index(){
        $homes=Homes::getHomeDetails();
        
        return view('homes_list',compact('homes'));
    }
// Add new home and corresponding home
    public function addNewHomes($id=null){
        $homes = $id ? Homes::getHome($id) : new Homes;
        $location=$id? Location::getLocation($homes->LocationId): new Location;
        return view('add_new_homes',compact('homes','location'));
    }
// Type of homes
    public function homeType($landsize,$floorspace,$floors){
        if($floorspace>6000 && $landsize/43560>2){
            $type='Mansion';
        }elseif($floors>1){
            $type='Apartment';
        }elseif($landsize==$floorspace){
            $type='Condo';
        }else{
            $type='Townhome';
        }
        return $type;
    }
// Add home information to collection
    public function addorupdateNewHomeForm(Request $request)
    {
        $type=$this->homeType($request->LandSize,$request->FloorSpace,$request->Floors);
        $data_location = [
            
            'Street' => $request->Street, 
            'City' => $request->City,
            'State' => $request->State, 
            'County' => $request->County,
            'Zip' => $request->Zip,           
            'Apt' => $request->Apt,
        ];
        $data = [
            
            'FloorSpace' => $request->FloorSpace, 
            'Floors' => $request->Floors,
            'BedRooms' => $request->BedRooms, 
            'BathRooms' => $request->BathRooms,
            'LandSize' => $request->LandSize,
            'YearConstructed' => $request->YearConstructed,
            'Type' => $type,
            
        ];
        if ($request->id) {

            // $type=$this->homeType($request->LandSize,$request->FloorSpace,$request->Floors);
            // Update existing Home
            
            $homes = Homes::getHome($request->id);

            //Location update
            $locations = Location::getLocation($homes->LocationId);
            // $locations->HomeID = $homes->HomeID;
            // $locations->LocationID = $locations->LocationID;
            // $data_location['HomeID'] = $homes->HomeID;
            // $data_location['LocationID']=$locations->LocationID;
            Location::updateLocation($request->id,$data_location);
            // $locations->Street = $request->Street;
            // $locations->City = $request->City;
            // $locations->State = $request->State;
            // $locations->Zip = $request->Zip;
            // $locations->Apt = $request->Apt;
            // $locations->save();
//End location
            // $homes->FloorSpace = $request->FloorSpace;
            // $homes->Floors = $request->Floors;
            // $homes->BedRooms = $request->BedRooms;
            // $homes->BathRooms = $request->BathRooms;
            // $homes->LandSize = $request->LandSize;
            // $homes->YearConstructed = $request->YearConstructed;
            // $homes->Type =$type;
            // $homes->save();
            Homes::updateHome($request->id,$data);
            $message = 'Homes updated successfully!';
        } else {
           
            // Add new Home & location
            $home_id=time().rand(1,100);
            $location_id_temp=time().rand(101,200);
            // $data_location = [
            //     'HomeID' => $home_id,
            //     'LocationID'=>$location_id_temp,
            //     'Street' => $request->Street, 
            //     'City' => $request->City,
            //     'State' => $request->State, 
            //     'Zip' => $request->Zip,
            //     'Apt' => $request->Apt,
            // ];
            $data_location['HomeID'] = $home_id;
            $data_location['LocationID']=$location_id_temp;
//add function
            $location_id=Location::addLocation($data_location)->getInsertedId();

            // $location_id = Location::orderBy('created_at', 'desc')->first()->_id;
          
           
           
            // $data = [
            //     'HomeID' => $home_id,
            //     'FloorSpace' => $request->FloorSpace, 
            //     'Floors' => $request->Floors,
            //     'BedRooms' => $request->BedRooms, 
            //     'BathRooms' => $request->BathRooms,
            //     'LandSize' => $request->LandSize,
            //     'YearConstructed' => $request->YearConstructed,
            //     'Type' => $type,
            //     'LocationId'=>$location_id
            // ];
            $data['HomeID'] = $home_id;
            $data['LocationId'] = $location_id;
            Homes::addHome($data);
            $message = 'New Homes added successfully!';
        }
    
        return redirect()->to('homes')->with('success', $message);
      
    }
}
