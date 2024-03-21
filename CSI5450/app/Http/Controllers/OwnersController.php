<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owners;
class OwnersController extends Controller
{
    //
    public function index(){
        $owners=Owners::all();
        return view('owners_list',compact('owners'));
    }
    public function addNewOwners($id=null){
        $owner = $id ? Owners::findOrFail($id) : new Owners;

        return view('add_new_owners',compact('owner'));
    }
    public function addorupdateNewOwnerForm(Request $request)
    {
        // $owners = new Owners;
        // $data=array();
        // $data=array(
        //     'Name'=>$request->name, 
        //     'SSN'=>$request->ssn,
        //     'Familymember'=>$request->familymember, 
        //     'Income'=>$request->income,
        //     'Age'=>$request->age,
        //     'Profession'=>$request->profession
        // ); 

        // if(Owners::create($data)){
        //     return redirect()->to('owners')->with('success', 'New Owners added!');

        // }


        if ($request->id) {
            // Update existing owner
            $owner = Owners::find($request->id);
            $owner->Name = $request->name;
            $owner->SSN = $request->ssn;
            $owner->Familymember = $request->familymember;
            $owner->Income = $request->income;
            $owner->Age = $request->age;
            $owner->Profession = $request->profession;
            $owner->save();
            $message = 'Owner updated successfully!';
        } else {
            // Add new owner
            $data = [
                'Name' => $request->name, 
                'SSN' => $request->ssn,
                'Familymember' => $request->familymember, 
                'Income' => $request->income,
                'Age' => $request->age,
                'Profession' => $request->profession
            ];
            Owners::create($data);
            $message = 'New owner added successfully!';
        }
    
        return redirect()->to('owners')->with('success', $message);
      
    }
}
