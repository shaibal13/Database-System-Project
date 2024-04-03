<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owners;
use App\Models\Homes;
use App\Models\Saleshistory;
class OwnersController extends Controller
{

    public function index(){
        $ownersModel = new Owners();
        $owners = $ownersModel->getOwnersDetails();
        return view('owners_list', compact('owners'));
    }
    

    public function addNewOwners($id = null){
        $ownersModel = new Owners();
        $owner = $id ? $ownersModel->getOwners($id) : new Owners();
    
        return view('add_new_owners', compact('owner'));
    }
    


    public function addorupdateNewOwnerForm(Request $request) 
    { 
    $ownersModel = new Owners(); 
    $data = [
        'Name' => $request->name, 
        'SSN' => $request->ssn,
        'Familymember' => $request->familymember, 
        'Income' => $request->income,
        'Age' => $request->age,
        'Profession' => $request->profession
    ];
    
    if ($request->id) {
        // updateowner
        $ownersModel->updateOwners($request->id, $data);
        $message = 'Owner updated successfully!';
    } else {
        // add new owner
        $ownersModel->addOwners($data);
        $message = 'New owner added successfully!';
    }

    return redirect()->to('owners')->with('success', $message);
    }
    public function previousOwner(Request $request){
        $homesModel=new Homes();
        $homes=$homesModel->getHomeDetails();
       
        if ($request->isMethod('get'))
        {
            $home_id='';
            $home_details=array();
            $owners=array();
           
        }
        if ($request->isMethod('post'))
        {
            $saleshistoryModel = new Saleshistory();
            $home_id=$request->home_id;
            $home_details=$homesModel->getHome($home_id);
           
            $owners=$saleshistoryModel->findThePreviousOwner($home_details->OwnerId,$home_id);
           
           
            
    }
    return view('find_previous_owner',compact('homes','owners','home_id','home_details'));
    }
}
