<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homes;
use App\Models\Location;
use App\Models\Appliances;
use App\Models\Companies;
use App\Models\Owners;

class HomesController extends Controller
{
    // Get all the home list
    public function index()
    {
        $homesModel = new Homes();
        $homes = $homesModel->getHomeDetails();
        //$homes=Homes::getHomeDetails();
        $companiesModel = new Companies();
        $companies = $companiesModel->getCompaniesDetails();
        //$companies=Companies::getCompaniesDetails();
        $ownersModel = new Owners();
        $owners = $ownersModel->getOwnersDetails();
        //$owners=Owners::getOwnersDetails();
        $type = 'all';
        // Get the locations in a single call if possible
        $locations = [];
        foreach ($homes as $home) {
            if (isset($home->LocationId)) {
                $locationModel = new Location();
                $locations[$home->_id] = $locationModel->getLocation($home->LocationId);
            }
        }
        return view('homes_list', compact('homes', 'locations', 'type', 'companies', 'owners'));
        //return view('homes_list', compact('homes', 'type', 'companies', 'owners'));
    }
    public function forSale()
    {
        $type = 'for_sale';
        $homesModel = new Homes();
        $homes = $homesModel->getHomeDetailsByAvailability($type);
        //$homes=Homes::getHomeDetailsByAvailability($type);
        $companiesModel = new Companies();
        $companies = $companiesModel->getCompaniesDetails();
        //$companies = Companies::getCompaniesDetails();
        $ownersModel = new Owners();
        $owners = $ownersModel->getOwnersDetails();
        //$owners = Owners::getOwnersDetails();
        return view('homes_list', compact('homes', 'type', 'companies', 'owners'));
    }
    public function owned()
    {
        $type = 'owned';
        $homesModel = new Homes();
        $homes = $homesModel->getHomeDetailsByAvailability($type);
        //$homes=Homes::getHomeDetailsByAvailability($type);
        $companiesModel = new Companies();
        $companies = $companiesModel->getCompaniesDetails();
        //$companies=Companies::getCompaniesDetails();
        $ownersModel = new Owners();
        $owners = $ownersModel->getOwnersDetails();
        //$owners=Owners::getOwnersDetails();
        return view('homes_list', compact('homes', 'type', 'companies', 'owners'));
    }
    // Add new home and corresponding home
    public function addNewHomes($id = null)
    {
        // Instantiate the Homes model
        $homesModel = new Homes();
        $homes = $id ? $homesModel->getHome($id) : $homesModel;
        //$homes = $id ? Homes::getHome($id) : new Homes;
        $locationModel = new Location();
        // Retrieve location based on the home's LocationId or create a new instance
        $location = $id && isset($homes->LocationId) ? $locationModel->getLocation($homes->LocationId) : $locationModel;
        //$location = $id ? Location::getLocation($homes->LocationId) : new Location;
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
            //$location_id = Location::addLocation($data_location)->getInsertedId();


            $data['HomeID'] = $home_id;
            $data['LocationId'] = $location_id;

            //$homesModel = new Homes(); // <-- New instance created here
            $homesModel->addHome($data);
            //Homes::addHome($data);
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

        Homes::updateHome($id, $data);
        $message = 'Home available for sale!';
        return redirect()->to('homes/forSale')->with('success', $message);
    }
    public function saledetails($id = null)
    {
        $homes = Homes::getHome($id);
        return response()->json($homes);
    }
    //Change the status
    public function statuschange($id = null, $status = null)
    {
        $data = array();
        $data = [

            'Status' => $status
        ];

        Homes::updateHome($id, $data);
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
        $homes = Homes::getHome($id);
        $appliances = Appliances::getAppliancesDetails();

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

        $added_appliances = Homes::addAppliancesToHome($id, $appliances);
        return redirect()->to('homes')->with('success', 'Appliances added successfully');
        // print_r($request->appliances);
    }
}
