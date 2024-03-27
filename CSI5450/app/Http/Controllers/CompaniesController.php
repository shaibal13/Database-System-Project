<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companies;
class CompaniesController extends Controller
{
    //
    public function index(){
        $companies=Companies::getCompaniesDetails();
        return view('companies_list',compact('companies'));
    }

    public function addNewCompanies($id=null){
        $company = $id ? Companies::getCompanies($id) : new Companies;

        return view('add_new_companies',compact('company'));  
    }
    
    public function addorupdateNewCompaniesForm(Request $request)
    {
        $data = [
            'Name' => $request->name, 
            'Percentage' => $request->Percentage,
            'Familymember' => $request->familymember, 
            'Income' => $request->income,
            'Age' => $request->age,
            'Profession' => $request->profession
        ];
        if ($request->id) {
            // Update existing company     
            Companies::updateCompanies($request->id,$data);
            $message = 'company updated successfully!';
        } else {
            // Add new company        
            Companies::addCompanies($data);
            $message = 'New company added successfully!';
        }
    
        return redirect()->to('companies')->with('success', $message);
      
    }
}
