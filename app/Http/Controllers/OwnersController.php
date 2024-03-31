<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owners;
class OwnersController extends Controller
{
    //
    public function index(){
        $owners=Owners::getOwnersDetails();
        return view('owners_list',compact('owners'));
    }

    public function addNewOwners($id=null){
        $owner = $id ? Owners::getOwners($id) : new Owners;

        return view('add_new_owners',compact('owner'));
    }
    
    public function addorupdateNewOwnerForm(Request $request)
    {
        $data = [
            'Name' => $request->name, 
            'SSN' => $request->ssn,
            'Familymember' => $request->familymember, 
            'Income' => $request->income,
            'Age' => $request->age,
            'Profession' => $request->profession
        ];
        if ($request->id) {
            // Update existing owner     
            Owners::updateOwners($request->id,$data);
            $message = 'Owner updated successfully!';
        } else {
            // Add new owner        
            Owners::addOwners($data);
            $message = 'New owner added successfully!';
        }
    
        return redirect()->to('owners')->with('success', $message);
      
    }
}
