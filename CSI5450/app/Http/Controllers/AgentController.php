<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Agents; // Load the model
use App\Models\Companies;

class AgentController extends Controller
{
   
    public function index(){
        $agents=Agents::getAgentsDetails();
        $companies=Companies::getCompaniesDetails();
        return view('agents_list',compact('agents','companies'));
    }

    public function addNewAgents($id=null){
        $agent = $id ? Agents::getAgents($id) : new Agents;
        $existed_company = [];
        if (isset($agent->company)) {
            foreach ($agent->company as $existed_companies) {
                // Convert each BSONDocument to an array
                $existed_company[] = json_decode(json_encode($existed_companies), true)['CompanyId'];
            }
        }
        $companies=Companies::getCompaniesDetails();

        return view('add_new_agents',compact('agent','companies','existed_company'));
    }

    public function addorupdateNewAgentForm(Request $request)
    {
        if(empty($request->companies)){
            $companies=[];
        }else{
            $companies = array_map(function($company) {
                return ['CompanyId' => $company];
            }, $request->companies);
    }
        $data = [
            'Name' => $request->name, 
            'dob' => $request->dob,
            'address' => $request->address, 
            'company'=>$companies
            
        ];
       
        if ($request->id) {
            // Update existing Agent    
            $inserted_id_= $request->id;
            Agents::updateAgents($request->id,$data);
            $message = 'Agent updated successfully!';
        } else {
            $agent_id=time().rand(1,100);
            $data['AgentId']=$agent_id;
            // Add new Agent        
            $inserted_id=Agents::addAgents($data);
            // print_r((string)$inserted_id->getInsertedId());die();
            $inserted_id_=(string)$inserted_id->getInsertedId();
            $message = 'New Agent added successfully!';
        }
        if(!empty($request->companies)){
        foreach($request->companies as $company) {
            $companies=Companies::getCompanies($company);
            $existed_agent=[];
            if (isset($companies->Agent)) {
                foreach ($companies->Agent as $existed_companies) {
                    // Convert each BSONDocument to an array
                    $existed_agent[] = json_decode(json_encode($existed_companies), true)['AgentId'];
                }
            }
            $existed_agent[]=$inserted_id_;
            $existed_agent_ = array_map(function($agent) {
                return ['AgentId' => $agent];
            }, $existed_agent);
           
           
            Companies::updateCompaniesBYAddingNewAgent($companies->_id,$existed_agent_);
            
        }
    }
       
        return redirect()->to('agents')->with('success', $message);
    
    }
}
