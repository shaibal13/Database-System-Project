<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agents; // Load the model
use App\Models\Companies;

class AgentController extends Controller
{

    public function index()
    {
        $agentModel = new Agents();
        $agents = $agentModel->getAgentsDetails();
        //$agents = Agents::getAgentsDetails();
        $companiesModel = new Companies();
        $companies = $companiesModel->getCompaniesDetails();
        //$companies = Companies::getCompaniesDetails();
        return view('agents_list', compact('agents', 'companies'));
    }

    public function addNewAgents($id = null)
    {
        $agentsModel = new Agents();
        $agent = $id ? $agentsModel->getAgents($id) : new Agents;
        //$agent = $id ? Agents::getAgents($id) : new Agents;
        $existed_company = [];
        if (isset($agent->company)) {
            foreach ($agent->company as $existed_companies) {
                // Convert each BSONDocument to an array
                $existed_company[] = json_decode(json_encode($existed_companies), true)['CompanyId'];
            }
        }
        $companiesModel = new Companies();
        $companies = $companiesModel->getCompaniesDetails();
        //$companies = Companies::getCompaniesDetails();

        return view('add_new_agents', compact('agent', 'companies', 'existed_company'));
    }

    public function addorupdateNewAgentForm(Request $request)
    {

        if (empty($request->companies)) {
            $companies = [];
        } else {
            $companies = array_map(function ($company) {
                return ['CompanyId' => $company];
            }, $request->companies);
        }
        $data = [
            'Name' => $request->name,
            'dob' => $request->dob,
            'address' => $request->address,
            'company' => $companies

        ];
        $agentsModel = new Agents();

        if ($request->id) {
            // Update existing Agent    
            $inserted_id_ = $request->id;
            $agentsModel->updateAgents($request->id, $data);
            //Agents::updateAgents($request->id, $data);
            $message = 'Agent updated successfully!';
        } else {
            $agent_id = time() . rand(1, 100);
            $data['AgentId'] = $agent_id;
            // Add new Agent 
            $inserted_id = $agentsModel->addAgents($data);       
            //$inserted_id = Agents::addAgents($data);
            // print_r((string)$inserted_id->getInsertedId());die();
            $inserted_id_ = (string)$inserted_id->getInsertedId();
            $message = 'New Agent added successfully!';
        }
        $companiesModel = new Companies();
        $all_company = $companiesModel->getCompaniesDetails();
        //$all_company = Companies::getCompaniesDetails();

        foreach ($all_company as $companies) {
            $existed_agent_ = array();
            // $companies=Companies::getCompanies($company);
            $existed_agent = array();
            if (isset($companies->Agent)) {
                foreach ($companies->Agent as $existed_companies) {

                    $existed_agent[] = json_decode(json_encode($existed_companies), true)['AgentId'];
                }
            }
            if (empty($request->companies)) {
                $update_agent = array();
                $existed_agent_ = array();
                //print_r($$existed_agent);
                $remove_agent_from_company_re_ = array_search($inserted_id_, $existed_agent, true);
                // print_r($remove_agent_from_company_re_);
                if ($remove_agent_from_company_re_ == True) {
                    unset($existed_agent[$remove_agent_from_company_re_]);
                    $update_agent = array_values($existed_agent);

                    $existed_agent_ = array();
                    $existed_agent_ = array_map(function ($agent) {
                        return ['AgentId' => $agent];
                    }, $update_agent);
                }
            } else {
                if (in_array($companies->_id, $request->companies)) {
                    $existed_agent[] = $inserted_id_;
                    $uniqueagentIds = array();
                    $uniqueagentIds = array_unique($existed_agent);

                    // If you want to re-index the array keys after filtering
                    $uniqueagentIds = array_values($uniqueagentIds);

                    $existed_agent_ = array();
                    $existed_agent_ = array_map(function ($agent) {
                        return ['AgentId' => $agent];
                    }, $uniqueagentIds);
                } else {
                    $update_agent = array();
                    //print_r($$existed_agent);
                    $remove_agent_from_company_re_ = array_search($inserted_id_, $existed_agent, true);
                    // print_r($remove_agent_from_company_re_);
                    if ($remove_agent_from_company_re_ == True) {
                        unset($existed_agent[$remove_agent_from_company_re_]);
                        $update_agent = array_values($existed_agent);
                        // echo "aa";
                        // print_r($update_agent);
                        $existed_agent_ = array();
                        $existed_agent_ = array_map(function ($agent) {
                            return ['AgentId' => $agent];
                        }, $update_agent);
                    }
                }
            }

            $companiesModel->updateCompaniesBYAddingNewAgent($companies->_id, $existed_agent_);
            //Companies::updateCompaniesBYAddingNewAgent($companies->_id, $existed_agent_);
        }

        return redirect()->to('agents')->with('success', $message);
    }
    public function destroy($id)
    {
        $agent = Agents::find($id);
        //$agent =  Agents::getAgents($id);
        if ($agent) {
            $agent->delete();
            return redirect()->route('agents.index')->with('success', 'Agent deleted successfully.');
        } else {
            return redirect()->route('agents.index')->with('error', 'Agent not found.');
        }
    }
}
