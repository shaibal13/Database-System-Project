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

    // public function addorupdateNewAgentForm(Request $request)
    // {
    //     $agentsModel = new Agents();
    //     $companiesModel = new Companies();

    //     $agent = $request->id ? $agentsModel->getAgents($request->id) : new Agents();
    //     $agentData = $request->only(['name', 'dob', 'address']);
        
    //     $agent->fill($agentData);

    //     if($request->has('companies')){
    //         $agent->company = array_map(function($company) {
    //             return ['CompanyId' => $company];
    //         }, $request->get('companies'));
    //     }

    //     if ($request->id) {
    //         $agentsModel->updateAgents($request->id, $agent->toArray());
    //         $message = 'Agent updated successfully!';
    //     } else {
    //         $agent_id = time().rand(1, 100);
    //         $agent->AgentId = $agent_id;
    //         $agentsModel->addAgents($agent->toArray());
    //         $inserted_id_ = (string)$agent->_id; // Assuming the _id is accessible after saving
    //         $message = 'New Agent added successfully!';
    //     }

    //     if ($request->has('companies')) {
    //         foreach ($request->get('companies') as $company_id) {
    //             $company = $companiesModel->getCompanies($company_id);
    //             $existed_agent = [];
    //             if (isset($company->Agent)) {
    //                 foreach ($company->Agent as $existed_agents) {
    //                     $existed_agent[] = json_decode(json_encode($existed_agents), true)['AgentId'];
    //                 }
    //             }
    //             $existed_agent[] = $agent->AgentId;
    //             $companiesModel->updateCompaniesBYAddingNewAgent($company->_id, $existed_agent);
    //         }
    //     }

    //     return redirect()->to('agents')->with('success', $message);
    // }

    public function addorupdateNewAgentForm(Request $request)
{
    
    $requestData = $request->except(['_id', 'companies']);

    $agentsModel = new Agents();

    if ($request->id) {
        
        $agent = $agentsModel->findOrFail($request->id); // 使用 findOrFail 确保找到代理或返回404
        $agent->fill($requestData);
        $agent->save();

        
        $this->updateAgentCompanies($request->id, $request->get('companies', []));

        $message = 'Agent updated successfully!';
    } else {
        
        $agent = new Agents();
        $agent->fill($requestData);
        $agent_id = time().rand(1, 100);
        $agent->AgentId = $agent_id;
        $agent->save(); // 使用 save 方法添加新代理

        
        $this->updateAgentCompanies($agent->_id, $request->get('companies', []));

        $message = 'New Agent added successfully!';
    }

    return redirect()->to('agents')->with('success', $message);
}

protected function updateAgentCompanies($agentId, $companies)
{
    $companiesModel = new Companies();

    foreach ($companies as $companyId) {
        $company = $companiesModel->findOrFail($companyId); // 确保公司存在

        // 检查代理是否已经与公司关联
        $existed_agent = array_column($company->Agent ?? [], 'AgentId');
        if (!in_array($agentId, $existed_agent)) {
            $existed_agent[] = $agentId;
            $company->Agent = array_map(function($agentId) {
                return ['AgentId' => $agentId];
            }, $existed_agent);
            $company->save(); // 更新公司文档
        }
    }
}

    public function destroy($id)
    {
        $agent = Agents::find($id);
        if ($agent) {
            $agent->delete();
            // 如果删除成功，则重定向到代理列表页并附带成功消息
            return redirect()->route('agents.index')->with('success', 'Agent deleted successfully.');
        } else {
            // 如果没有找到代理，则重定向到代理列表页并附带错误消息
            return redirect()->route('agents.index')->with('error', 'Agent not found.');
        }
    }
    

}
