<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appliances;
class AppliancesController extends Controller
{
    //
    public function index(){
        $appliances=Appliances::getAppliancesDetails();
        return view('appliances_list',compact('appliances'));
    }
    public function addNewAppliances($id=null){
        $appliances = $id ? Appliances::getAppliances($id) : new Appliances;

        return view('add_new_appliances',compact('appliances'));
    }
    public function addorupdateNewApplianceForm(Request $request)
    {
        $data = [
            'ModelName' => $request->ModelName, 
            'Year' => $request->Year,
            'Maker' => $request->Maker, 
            'Name' => $request->Name,
            'Price' => $request->Price,
        ];
        if ($request->id) {
 
            Appliances::updateAppliances($request->id,$data);
            // $appliances->save();
            $message = 'Appliances updated successfully!';
        } else {
        
            Appliances::addAppliances($data);
            $message = 'New Aappliances added successfully!';
        }
    
        return redirect()->to('appliances')->with('success', $message);
      
    }
}
