<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homes;
use App\Models\Location;
use App\Models\Appliances;

class HomesController extends Controller
{
    // Get all the home list
    // public function index(){
    //     $homes=Homes::getHomeDetails();
    //     $type='all';
    //     return view('homes_list',compact('homes','type'));
    // }
    // public function forSale(){
    //     $type='for_sale';
    //     $homes=Homes::getHomeDetailsByAvailability($type);
        
    //     return view('homes_list',compact('homes','type'));
    // }
    // public function owned(){
    //     $type='owned';
    //     $homes=Homes::getHomeDetailsByAvailability($type);
        
    //     return view('homes_list',compact('homes','type'));
    // }
// Add new home and corresponding home
    // public function addNewHomes($id=null){
    //     $homes = $id ? Homes::getHome($id) : new Homes;
    //     $location=$id? Location::getLocation($homes->LocationId): new Location;
    //     return view('add_new_homes',compact('homes','location'));
    // }
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


    public function index(){
        $homesModel = new Homes();
        $homes = $homesModel->getHomeDetails();
        $type = 'all';
        return view('homes_list', compact('homes', 'type'));
    }
    
    public function forSale(){
        $homesModel = new Homes();
        $type = 'for_sale';
        $homes = $homesModel->getHomeDetailsByAvailability($type);
        return view('homes_list', compact('homes', 'type'));
    }
    
    public function owned(){
        $homesModel = new Homes();
        $type = 'owned';
        $homes = $homesModel->getHomeDetailsByAvailability($type);
        return view('homes_list', compact('homes', 'type'));
    }
    public function addNewHomes($id = null){
        $homesModel = new Homes();
        $locationModel = new Location();
        $homes = $id ? $homesModel->getHome($id) : new Homes;
        $location = $id ? $locationModel->getLocation($homes->LocationId) : new Location;
        return view('add_new_homes', compact('homes', 'location'));
    }
    
    
// Add home information to collection
//     public function addorupdateNewHomeForm(Request $request)
//     {
//         $type=$this->homeType($request->LandSize,$request->FloorSpace,$request->Floors);
//         $data_location = [
            
//             'Street' => $request->Street, 
//             'City' => $request->City,
//             'State' => $request->State, 
//             'County' => $request->County,
//             'Zip' => $request->Zip,           
//             'Apt' => $request->Apt,
            
//         ];
//         $data = [
            
//             'FloorSpace' => $request->FloorSpace, 
//             'Floors' => $request->Floors,
//             'BedRooms' => $request->BedRooms, 
//             'BathRooms' => $request->BathRooms,
//             'LandSize' => $request->LandSize,
//             'YearConstructed' => $request->YearConstructed,
//             'Type' => $type,
//             'Status' => $request->home_status
            
//         ];
//         if ($request->id) {

          
//             // Update existing Home
            
//             $homes = Homes::getHome($request->id);

//             //Location update
//             $locations = Location::getLocation($homes->LocationId);
           
//             Location::updateLocation($locations->_id,$data_location);
          
//             Homes::updateHome($request->id,$data);
//             $message = 'Homes updated successfully!';
//         } else {
           
//             // Add new Home & location
//             $home_id=time().rand(1,100);
//             $location_id_temp=time().rand(101,200);
           
//             $data_location['HomeID'] = $home_id;
//             $data_location['LocationID']=$location_id_temp;
// //add function
//             $location_id=Location::addLocation($data_location)->getInsertedId();

           
//             $data['HomeID'] = $home_id;
//             $data['LocationId'] = $location_id;
//             Homes::addHome($data);
//             $message = 'New Homes added successfully!';
//         }

    
//         return redirect()->to('homes')->with('success', $message);
      
//     }

    //Change the status
    // public function statuschange($id=null, $status=null){
    //     $data=array();
    //     $data = [
            
    //         'Status' => $status  
    //     ];
        
    //     Homes::updateHome($id,$data);
    //     if($status=="owned"){
    //         $message = 'Homes moved to owner successfully!';
    //         return redirect()->to('homes/owned')->with('success', $message);
    //     }else{
    //         $message = 'Home available for sale!';
    //         return redirect()->to('homes/forSale')->with('success', $message);
    //     }
        
        
    // }


    public function addorupdateNewHomeForm(Request $request)
{
    $type = $this->homeType($request->LandSize, $request->FloorSpace, $request->Floors);
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
        // 更新现有的 Home
        $homesModel = new Homes();
        $homes = $homesModel->getHome($request->id);

        $locationModel = new Location();
        $locations = $locationModel->getLocation($homes->LocationId);
        
        $locationModel->updateLocation($locations->_id, $data_location);
        $homesModel->updateHome($request->id, $data);
        $message = 'Homes updated successfully!';
    } else {
        // 添加新的 Home & location
        $locationModel = new Location();

        $result = $locationModel->addLocation($data_location);
        $location_id = $result->getInsertedId(); // 假设这是添加地点并返回结果的方式

        $data['HomeID'] = time() . rand(1, 100); // 确保这是你想要的 ID 生成方式
        $data['LocationId'] = $location_id;

        $homesModel = new Homes();
        $homesModel->addHome($data);
        $message = 'New Homes added successfully!';
    }

    return redirect()->to('homes')->with('success', $message);
}

    public function statuschange($id = null, $status = null){
        $homesModel = new Homes();
        $data = ['Status' => $status];
        $homesModel->updateHome($id, $data);
        if($status=="owned"){
            $message = 'Homes moved to owner successfully!';
            return redirect()->to('homes/owned')->with('success', $message);
        }else{
            $message = 'Home available for sale!';
            return redirect()->to('homes/forSale')->with('success', $message);
        }
    }

    public function addAppliancesToHome($id = null){
        $homesModel = new Homes();
        $appliancesModel = new Appliances();
        $homes = $homesModel->getHome($id);
        $appliances = $appliancesModel->getAppliancesDetails();
        $existed_appliances = [];
        if (isset($homes->Appliances)) {
            foreach ($homes->Appliances as $existed_appliance_) {
                // Convert each BSONDocument to an array
                $existed_appliances[] = json_decode(json_encode($existed_appliance_), true)['ModelName'];
            }
        }

        return view('add_appliances_to_home',compact('homes','appliances','existed_appliances'));
    }
    
    public function addorupdateNewApplianceForm(Request $request){
        $homesModel = new Homes();
        
        $homesModel->addAppliancesToHome($request->id, $appliances);
        return redirect()->to('homes')->with('success', 'Appliances added successfully');
            // print_r($request->appliances);
    }
    
    
//Add appliances to Home
    // public function addAppliancesToHome($id=null){
    //     $homes=Homes::getHome($id);
    //     $appliances=Appliances::getAppliancesDetails();

    //     $existed_appliances = [];
    //     if (isset($homes->Appliances)) {
    //         foreach ($homes->Appliances as $existed_appliance_) {
    //             // Convert each BSONDocument to an array
    //             $existed_appliances[] = json_decode(json_encode($existed_appliance_), true)['ModelName'];
    //         }
    //     }
    //     // print_r($appliances);
    //     // $appliances=Appliances::getAppliancesDetails();
    //     // return view('add_appliances_to_home',compact('homes','appliances'));

    //     return view('add_appliances_to_home',compact('homes','appliances','existed_appliances'));

    // }
//     public function addorupdateNewApplianceForm(Request $request){
//             $id=$request->id;
//             // $appliances=$request->appliances;
//             $appliances = array_map(function($modelName) {
//                 return ['ModelName' => $modelName];
//             }, $request->appliances);
//             // print_r($appliances);

//            $added_appliances=Homes::addAppliancesToHome($id,$appliances);
//            return redirect()->to('homes')->with('success', 'Appliances added successfully');
//             // print_r($request->appliances);
//     }
}
