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
        $all_agents=Agents::getAgentsDetails();
        
        foreach($all_agents as $agent_details){
            $existed_companies_=array();
           // $companies=Companies::getCompanies($company);
           $existed_company=array();
           if (isset($agent_details->company)) {
                foreach ($agent_details->company as $existed_companies) {
                  
                    $existed_company[] = json_decode(json_encode($existed_companies), true)['CompanyId'];
                  
                }
            }
            // echo "aa";
            // print_r($existed_company);
            if(empty($request->agents)){
                $update_company=array();
                $existed_company_=array();
                //print_r($$existed_company);
                $remove_company_from_agent_re_ = array_search($inserted_id_, $existed_company, true);
                // print_r($remove_agent_from_company_re_);
                if ($remove_company_from_agent_re_ == True) {
                    unset($existed_company[$remove_company_from_agent_re_]);
                    $update_company = array_values($existed_company);
                   
                    $existed_companies_=array();
                    $existed_companies_ = array_map(function($company_) {
                                    return ['CompanyId' => $company_];
                                }, $update_company);
                }
            }else{
                if(in_array($agent_details->_id,$request->agents)){
                    $existed_company[]=$inserted_id_;
                    $uniquecompanyIds=array();
                    $uniquecompanyIds = array_unique($existed_company);
    
                    // If you want to re-index the array keys after filtering
                    $uniquecompanyIds = array_values($uniquecompanyIds);
    
                    $existed_companies_=array();
                    $existed_companies_ = array_map(function($company_) {
                            return ['CompanyId' => $company_];
                    }, $uniquecompanyIds);
                    // echo "ba";
    // print_r($existed_companies_);
                }else{
                    $update_company=array();
                    //print_r($$existed_company);
                    $remove_company_from_agent_re_ = array_search($inserted_id_, $existed_company, true);
                    // print_r($remove_agent_from_company_re_);
                    if ($remove_company_from_agent_re_ == True) {
                        unset($existed_company[$remove_company_from_agent_re_]);
                        $update_company = array_values($existed_company);
                        // echo "aa";
                        // print_r($update_company);
                        $existed_companies_=array();
                        $existed_companies_ = array_map(function($company_) {
                                        return ['CompanyId' => $company_];
                                    }, $update_company);
                    }
                   
                }
            }
        
          
            Agents::updateAgentsBYAddingNewCompanies($agent_details->_id,$existed_companies_);
           }


        return redirect()->to('companies')->with('success', $message);
      
    }
}
