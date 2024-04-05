<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homes;
use App\Models\Location;
use App\Models\Appliances;
use App\Models\Companies;
use App\Models\Owners;
use App\Models\Saleshistory;

class HomesController extends Controller
{
    // Get all the home list
    public function index(Request $request)
    {
        $homesModel = new Homes();
        $companiesModel = new Companies();
        $ownersModel = new Owners();
        $locationModel = new Location();
        $cities=$locationModel->get_unique_maker_list();
        $bedrooms=$homesModel->get_unique_maker_list('BedRooms'); //BedRooms
        $bathrooms=$homesModel->get_unique_maker_list('BathRooms'); //BedRooms
        $owners = $ownersModel->getOwnersDetails();
        $companies = $companiesModel->getCompaniesDetails();
        $homes=collect();
        // For getting the output
        $city_select='';
        $owner_select='';
        $price='';
        $no_of_bedroom='';
        $no_of_bathroom='';
        $home_status='';
        if ($request->isMethod('get'))
        {
                 
            $homes = $homesModel->getHomeDetails();
            $type = 'all'; 

        }
        if($request->isMethod('POST')) {

            $city_select=$request->city;
            $owner_select=$request->owner;
            $price=$request->price;
            
            $no_of_bedroom=$request->no_of_bedroom;
           
            $no_of_bathroom=$request->no_of_bathroom;
            $home_status=$request->home_status;
            
            if($city_select!='all') {
                
                $homes = $homesModel->filterHomeListForCustomLocation($city_select,$owner_select, $price, $no_of_bedroom,$no_of_bathroom, $home_status);
                
            }else{
                $homes = $homesModel->filterHomeListForAll($owner_select, $price, $no_of_bedroom,$no_of_bathroom, $home_status);
            }
            
           
            $type = 'all'; 
            
        }
        return view('homes_list', compact('homes', 'type', 'companies', 'owners','cities','bedrooms','bathrooms','city_select','owner_select','price','no_of_bedroom','no_of_bathroom','home_status'));

      
    }
    public function forSale()
    {
        $type = 'for_sale';
        $homesModel = new Homes();
        $homes = $homesModel->getHomeDetailsByAvailability($type);
        
        $companiesModel = new Companies();
        $companies = $companiesModel->getCompaniesDetails();
        
        $ownersModel = new Owners();
        $owners = $ownersModel->getOwnersDetails();
       
        return view('owned_sale_list', compact('homes', 'type', 'companies', 'owners'));
    }
    public function owned()
    {
        $type = 'owned';
        $homesModel = new Homes();
        $homes = $homesModel->getHomeDetailsByAvailability($type);
       
        $companiesModel = new Companies();
        $companies = $companiesModel->getCompaniesDetails();
       
        $ownersModel = new Owners();
        $owners = $ownersModel->getOwnersDetails();
        
        return view('owned_sale_list', compact('homes', 'type', 'companies', 'owners'));
    }
    // Add new home and corresponding home
    public function addNewHomes($id = null)
    {
        // Instantiate the Homes model
        $homesModel = new Homes();
        $homes = $id ? $homesModel->getHome($id) : $homesModel;
        
        $locationModel = new Location();
        // Retrieve location based on the home's LocationId or create a new instance
        $location = $id && isset($homes->LocationId) ? $locationModel->getLocation($homes->LocationId) : $locationModel;
       
        return view('add_new_homes', compact('homes', 'location'));
    }
    // Type of homes
    public function homeType($landsize, $floorspace, $floors)
    {
        if ($floorspace > 6000 && $landsize / 43560 > 2) {
            $type = 'Mansion';
        } elseif ($floors > 1) {
            $type = 'Apartment';
        } elseif ($landsize == $floorspace) {
            $type = 'Condo';
        } else {
            $type = 'Townhome';
        }
        return $type;
    }
    // Add home information to collection
    public function addorupdateNewHomeForm(Request $request)
    {
        $homesModel = new Homes();
        $locationModel = new Location();

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
            // 'Status' => $request->home_status

        ];
        if ($request->id) {
            // Update existing Home
            $homes = $homesModel->getHome($request->id);
            //$homes = Homes::getHome($request->id);

            //Location update
            $locations = $locationModel->getLocation($homes->LocationId);
            $locationModel->updateLocation($locations->_id, $data_location);
            //$locations = Location::getLocation($homes->LocationId);

            //Location::updateLocation($locations->_id, $data_location);
            $homesModel->updateHome($request->id, $data);
            //Homes::updateHome($request->id, $data);
            $message = 'Homes updated successfully!';
        } else {

            // Add new Home & location
            $home_id = time() . rand(1, 100);
            $location_id_temp = time() . rand(101, 200);

            $data_location['HomeID'] = $home_id;
            $data_location['LocationID'] = $location_id_temp;
            //add function
            $locationModel = new Location();
            $location_id = $locationModel->addLocation($data_location)->getInsertedId();
           

            $data['HomeID'] = $home_id;
            $data['LocationId'] = $location_id;

           
            $homesModel->addHome($data);
           
            $message = 'New Homes added successfully!';
        }

        return redirect()->to('homes')->with('success', $message);
    }
    public function addtosale(Request $request)
    {
        $id = $request->home_id;
        $data = array();
        $data = [
            'AgentId' => $request->agent,
            'companyId' => $request->company,
            'Status' => 'for_sale',
            'price' => $request->price

        ];
        $home = Homes::find($id);
        if ($home) {
            // call the method
            $home->updateHome($id,$data);
            $message = 'Home available for sale!';
        } else {
            $message = 'Home not found!';
        }
        // Homes::updateHome($id, $data);
        // $message = 'Home available for sale!';
        return redirect()->to('homes/forSale')->with('success', $message);
    }
    public function saledetails($id = null)
    {
        $homes_ob=new Homes();
        $homes = $homes_ob->getHome($id);
        return response()->json($homes);
    }
    //Change the status
    public function statuschange($id = null, $status = null)
    {
        $data = array();
        $data = [

            'Status' => $status
        ];
        $homes_ob=new Homes();
        $homes_ob->updateHome($id, $data);
        if ($status == "owned") {
            $message = 'Homes moved to owner successfully!';
            return redirect()->to('homes/owned')->with('success', $message);
        } else {
            $message = 'Home available for sale!';
            return redirect()->to('homes/forSale')->with('success', $message);
        }
    }
    //Add appliances to Home
    public function addAppliancesToHome($id = null)
    {
        $homes_ob=new Homes();
        $homes =$homes_ob->getHome($id);
        $appliances_object=new Appliances();
        $appliances =$appliances_object->getAppliancesDetails();

        $existed_appliances = [];
        if (isset($homes->Appliances)) {
            foreach ($homes->Appliances as $existed_appliance_) {
                // Convert each BSONDocument to an array
                $existed_appliances[] = json_decode(json_encode($existed_appliance_), true)['ModelName'];
            }
        }

        return view('add_appliances_to_home', compact('homes', 'appliances', 'existed_appliances'));
    }
    public function addorupdateNewApplianceForm(Request $request)
    {
        $id = $request->id;
        // $appliances=$request->appliances;
        $appliances = array_map(function ($modelName) {
            return ['ModelName' => $modelName];
        }, $request->appliances);
        // print_r($appliances);
        $homes_ob=new Homes();
        $added_appliances =  $homes_ob->addAppliancesToHome($id, $appliances);
        return redirect()->to('homes')->with('success', 'Appliances added successfully');
        // print_r($request->appliances);
    }
    public function findExpensiveHome(Request $request){
       
        $selectedOwner = $request->input('appliances_maker');
       
        
        

        $ownersModel = new Owners();
        $ownerDetail= $ownersModel->getOwnersDetails();
        $ownerId = $ownersModel->getOwnerByName($selectedOwner);


        $owner = [];
        foreach ($ownerDetail as $doc) {
            $owner[] = $doc['Name']; 
    
        }

        if ($request->isMethod('get'))
        {
            $homes=array();
            return view('expensive_home',compact('owner','homes','selectedOwner'));
        }
        if ($request->isMethod('post'))
        {
            
            $homes_ob=new Saleshistory();
            $homes=$homes_ob->findMostExpensiveHome($ownerId);
           
           
            return view('expensive_home',compact('owner','homes','selectedOwner'));
        }
        
    }
    
    //q9
    public function expensiveHomes(Request $request){
        $locationModel = new Location();
        $homeModel=new Homes();
        $cities=$locationModel->get_unique_maker_list();
        if($request->isMethod('get')){
            $city_select='';
            $owners_list=collect();
        }
        if($request->isMethod('post')){

            $city_select=$request->city;
            $owners_list=$homeModel->findExpensiveHomeOwner($city_select);

        }
        return view('expensive_homes_city', compact('city_select', 'cities','owners_list'));
    }
}
