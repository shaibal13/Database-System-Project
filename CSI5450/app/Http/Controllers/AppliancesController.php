<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appliances;
class AppliancesController extends Controller
{
    //
    public function index(){
        $appliances=Appliances::all();
        return view('appliances_list',compact('appliances'));
    }
    public function addNewAppliances($id=null){
        $appliances = $id ? Appliances::findOrFail($id) : new Appliances;

        return view('add_new_appliances',compact('appliances'));
    }
    public function addorupdateNewApplianceForm(Request $request)
    {
       
        if ($request->id) {
            // Update existing owner
            $appliances = Appliances::find($request->id);
            
            $appliances->ModelName = $request->ModelName;
            $appliances->Year = $request->Year;
            $appliances->Maker = $request->Maker;
            $appliances->Name = $request->Name;
            $appliances->Price = $request->Price;

            $appliances->save();
            $message = 'Appliances updated successfully!';
        } else {
            // Add new owner
            $data = [
                'ModelName' => $request->ModelName, 
                'Year' => $request->Year,
                'Maker' => $request->Maker, 
                'Name' => $request->Name,
                'Price' => $request->Price,
            ];
            Appliances::create($data);
            $message = 'New Aappliances added successfully!';
        }
    
        return redirect()->to('appliances')->with('success', $message);
      
    }
}
