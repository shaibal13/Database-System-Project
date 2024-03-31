<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homes;
use App\Models\Location;
use App\Models\Appliances;
use App\Models\Companies;
use App\Models\Saleshistory;
use App\Models\Owners;
class SaleshistoryController extends Controller
{
    //
    public function index(){
        $sales_details=Saleshistory::getSaleHistoryDetails();
        return view('sales_history',compact('sales_details'));
    }
    public function addSale(Request $request){
        $owner=$request->owner;
        $price=$request->price_;
        $home_id=$request->home_id_;
        $home_details=Homes::getHome($home_id);
        $company_details=Companies::getCompanies($home_details->companyId);
        $agent_commision=( $home_details->price*$company_details->Percentage)/100;
        $data_sale=array();
        $data_sale=[
            'Agent' => $home_details->AgentId,
            'Company' => $home_details->companyId,
            'HomeId'=>$home_details->_id,
            'price' => $home_details->price,
            'OwnerId'=>$owner,
            'PreviousOwnerId'=>$home_details->OwnerId,
            'date_saling' =>time(),
            'agentcommision' =>$agent_commision

        ];
       
        $sale=Saleshistory::addSalesHistory($data_sale);
        if($sale){
            $data_home=array();
            $data_home=[
                'OwnerId'=>$owner,
                'Status'=>'owned',
                'price'=>"",
                "AgentId"=>"",
                "companyId"=>""
            ];
            Homes::updateHome($home_id,$data_home);
            $message = 'Home sold!';
        }else{
            $message = 'Check the error!';
        }
        return redirect()->to('homes/owned')->with('success', $message);
    }
}
