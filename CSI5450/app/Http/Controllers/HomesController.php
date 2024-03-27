<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homes;
use App\Models\Location;
use App\Models\Appliances;

class HomesController extends Controller
{
    // Get all the home list
    public function index(){
        $homes=Homes::getHomeDetails();
        $type='all';
        return view('homes_list',compact('homes','type'));
    }
    public function forSale(){
        $type='for_sale';
        $homes=Homes::getHomeDetailsByAvailability($type);
        
        return view('homes_list',compact('homes','type'));
    }
    public function owned(){
        $type='owned';
        $homes=Homes::getHomeDetailsByAvailability($type);
        
        return view('homes_list',compact('homes','type'));
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
            'Status' => $request->home_status
            
        ];
        if ($request->id) {

          
            // Update existing Home
            
            $homes = Homes::getHome($request->id);

            //Location update
            $locations = Location::getLocation($homes->LocationId);
           
            Location::updateLocation($locations->_id,$data_location);
          
            Homes::updateHome($request->id,$data);
            $message = 'Homes updated successfully!';
        } else {
           
            // Add new Home & location
            $home_id=time().rand(1,100);
            $location_id_temp=time().rand(101,200);
           
            $data_location['HomeID'] = $home_id;
            $data_location['LocationID']=$location_id_temp;
//add function
            $location_id=Location::addLocation($data_location)->getInsertedId();

           
            $data['HomeID'] = $home_id;
            $data['LocationId'] = $location_id;
            Homes::addHome($data);
            $message = 'New Homes added successfully!';
        }
    
        return redirect()->to('homes')->with('success', $message);
      
    }

    //Change the status
    public function statuschange($id=null, $status=null){
        $data=array();
        $data = [
            
            'Status' => $status  
        ];
        
        Homes::updateHome($id,$data);
        if($status=="owned"){
            $message = 'Homes moved to owner successfully!';
            return redirect()->to('homes/owned')->with('success', $message);
        }else{
            $message = 'Home available for sale!';
            return redirect()->to('homes/forSale')->with('success', $message);
        }
        
        
    }
//Add appliances to Home
    public function addAppliancesToHome($id=null){
        $homes=Homes::getHome($id);
        $appliances=Appliances::getAppliancesDetails();

        $existed_appliances = [];
        if (isset($homes->Appliances)) {
            foreach ($homes->Appliances as $existed_appliance_) {
                // Convert each BSONDocument to an array
                $existed_appliances[] = json_decode(json_encode($existed_appliance_), true)['ModelName'];
            }
        }
        // print_r($appliances);
        // $appliances=Appliances::getAppliancesDetails();
        // return view('add_appliances_to_home',compact('homes','appliances'));

        return view('add_appliances_to_home',compact('homes','appliances','existed_appliances'));

    }
    public function addorupdateNewApplianceForm(Request $request){
            $id=$request->id;
            // $appliances=$request->appliances;
            $appliances = array_map(function($modelName) {
                return ['ModelName' => $modelName];
            }, $request->appliances);
            // print_r($appliances);

           $added_appliances=Homes::addAppliancesToHome($id,$appliances);
           return redirect()->to('homes')->with('success', 'Appliances added successfully');
            // print_r($request->appliances);
    }
}
