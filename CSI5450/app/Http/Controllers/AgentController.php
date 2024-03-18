<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Agent; // Load the model


class AgentController extends Controller
{
    //
    public function index(){}
    public function newAgent(){
        return view('add_new_agent_form');
    }

    public function addNewAgent(Request $request)
   {
       $agent = new Agent;

       $agent->name = $request->name;
       $agent->dob = $request->dob;
       $agent->address = $request->address;
       $agent->companies=$request->companies;
       

       $agent->save();

       return response()->json(["result" => "ok"], 201);
   }
}
