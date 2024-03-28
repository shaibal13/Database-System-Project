<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\Agents;
class CompaniesController extends Controller
{
    //
    public function index(){
        $companies=Companies::getCompaniesDetails();
        $agents=Agents::getAgentsDetails();
        return view('companies_list',compact('companies','agents'));
    }

    public function addNewCompanies($id=null){
        $company = $id ? Companies::getCompanies($id) : new Companies;
        $existed_agent = [];
        if (isset($company->Agent)) {
            foreach ($company->Agent as $existed_agents) {
                // Convert each BSONDocument to an array
                $existed_agent[] = json_decode(json_encode($existed_agents), true)['AgentId'];
            }
        }
        $agents=Agents::getAgentsDetails();
        return view('add_new_companies',compact('company','agents','existed_agent'));  
    }
    
    public function addorupdateNewCompaniesForm(Request $request)
    { 
        if(empty($request->agents)){
            $agents=[];
        }else{
            $agents = array_map(function($agent) {
                return ['AgentId' => $agent];
            }, $request->agents);
        }
       
        $data = [
            'Name' => $request->name, 
            'Percentage' => $request->Percentage,
            'Address' => $request->address, 
            'Agent'=>$agents
            // 'Income' => $request->income,
            // 'Age' => $request->age,
            // 'Profession' => $request->profession
        ];
        if ($request->id) {
            $inserted_id_= $request->id;
            // Update existing company     
            Companies::updateCompanies($request->id,$data);
            $message = 'company updated successfully!';
        } else {
            // Add new company     
            // $data['AgentId']=$agent_id;   
            $inserted_id=Companies::addCompanies($data);
            $inserted_id_=(string)$inserted_id->getInsertedId();
            $message = 'New company added successfully!';
        }
        if(!empty($request->agents)){
        foreach($request->agents as $agent) {
            $agent_details=Agents::getAgents($agent);
            $existed_companies=[];
            if (isset($agent_details->company)) {
                foreach ($agent_details->company as $existed_agents) {
                    // Convert each BSONDocument to an array
                    $existed_companies[] = json_decode(json_encode($existed_agents), true)['CompanyId'];
                }
            }
            $existed_companies[]=$inserted_id_;
            $existed_companies_ = array_map(function($company) {
                return ['CompanyId' => $company];
            }, $existed_companies);
           
           
            Agents::updateAgentsBYAddingNewCompanies($agent_details->_id,$existed_companies_);
            
        }
    }
        return redirect()->to('companies')->with('success', $message);
      
    }
}
