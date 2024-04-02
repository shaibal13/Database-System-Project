<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appliances;
use App\Models\Homes;
class AppliancesController extends Controller
{
    //
    public function index(){
        $appliances_object=new Appliances();
        $appliances=$appliances_object->getAppliancesDetails();
        return view('appliances_list',compact('appliances'));
    }
    public function addNewAppliances($id=null){
        $appliances_object=new Appliances();
        $appliances = $id ? $appliances_object->getAppliances($id) : new Appliances;

        return view('add_new_appliances',compact('appliances'));
    }
    public function addorupdateNewApplianceForm(Request $request)
    {
        $appliances_object=new Appliances();
        $data = [
            'ModelName' => $request->ModelName, 
            'Year' => $request->Year,
            'Maker' => $request->Maker, 
            'Name' => $request->Name,
            'Price' => $request->Price,
        ];
        if ($request->id) {
 
            $appliances_object->updateAppliances($request->id,$data);
            // $appliances->save();
            $message = 'Appliances updated successfully!';
        } else {
        
            $appliances_object->addAppliances($data);
            $message = 'New Aappliances added successfully!';
        }
    
        return redirect()->to('appliances')->with('success', $message);
      
    }
    public function findHomebyMaker(Request $request){
        $appliances_object=new Appliances();
        $maker=$appliances_object->get_unique_maker_list(); 
        if ($request->isMethod('get'))
        {
            $homes=array();
            return view('find_appliances_home',compact('maker','homes'));
        }
        if ($request->isMethod('post'))
        {
            $maker_name=$request->appliances_maker;
            $homes_ob=new Homes();
            $homes=$homes_ob->findAllHomesUsedBySameMaker($maker_name);
           
            return view('find_appliances_home',compact('maker','maker_name','homes'));
        }
        
    }
}
