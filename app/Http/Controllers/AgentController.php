<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Agents;
use App\Models\Companies;

class AgentController extends Controller
{
    public function index(){
        $agentsModel = new Agents();
        $agents = $agentsModel->getAgentsDetails();

        $companiesModel = new Companies();
        $companies = $companiesModel->getCompaniesDetails();

        return view('agents_list', compact('agents', 'companies'));
    }

    public function addNewAgents($id = null){
        $agentsModel = new Agents();
        $agent = $id ? $agentsModel->getAgents($id) : new Agents();

        $existed_company = [];
        if (isset($agent->company)) {
            foreach ($agent->company as $existed_companies) {
                $existed_company[] = json_decode(json_encode($existed_companies), true)['CompanyId'];
            }
        }

        $companiesModel = new Companies();
        $companies = $companiesModel->getCompaniesDetails();

        return view('add_new_agents', compact('agent', 'companies', 'existed_company'));
    }

    public function addorupdateNewAgentForm(Request $request)
    {
        $agentsModel = new Agents();
        $companiesModel = new Companies();

        $agent = $request->id ? $agentsModel->getAgents($request->id) : new Agents();
        $agentData = $request->only(['name', 'dob', 'address']);
        
        $agent->fill($agentData);

        if($request->has('companies')){
            $agent->company = array_map(function($company) {
                return ['CompanyId' => $company];
            }, $request->get('companies'));
        }

        if ($request->id) {
            $agentsModel->updateAgents($request->id, $agent->toArray());
            $message = 'Agent updated successfully!';
        } else {
            $agent_id = time().rand(1, 100);
            $agent->AgentId = $agent_id;
            $agentsModel->addAgents($agent->toArray());
            $inserted_id_ = (string)$agent->_id; // Assuming the _id is accessible after saving
            $message = 'New Agent added successfully!';
        }

        if ($request->has('companies')) {
            foreach ($request->get('companies') as $company_id) {
                $company = $companiesModel->getCompanies($company_id);
                $existed_agent = [];
                if (isset($company->Agent)) {
                    foreach ($company->Agent as $existed_agents) {
                        $existed_agent[] = json_decode(json_encode($existed_agents), true)['AgentId'];
                    }
                }
                $existed_agent[] = $agent->AgentId;
                $companiesModel->updateCompaniesBYAddingNewAgent($company->_id, $existed_agent);
            }
        }

        return redirect()->to('agents')->with('success', $message);
    }
}
