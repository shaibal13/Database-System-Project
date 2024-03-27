<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appliances;
use App\Models\Homes;
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
    public function findHomebyMaker(Request $request){
        $maker=Appliances::get_unique_maker_list(); 
        if ($request->isMethod('get'))
        {
            return view('find_appliances_home',compact('maker'));
        }
        if ($request->isMethod('post'))
        {
            $maker_name=$request->appliances_maker;
         
            $homes=Homes::findAllHomesUsedBySameMaker($maker_name);
           
            return view('find_appliances_home',compact('maker','maker_name','homes'));
        }
        
    }
}
