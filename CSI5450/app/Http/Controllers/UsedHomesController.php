<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homes;
use App\Models\Saleshistory;

class UsedHomesController extends Controller
{
    public function showUsedHomes() {
        $salesHistoryModel = new Saleshistory(); // Instantiate the Saleshistory model
        $usedHomes = $salesHistoryModel->getHomesSoldMoreThanOnce();
        return view('used_homes', ['usedHomes' => $usedHomes]); 
        //return view('used_homes', compact('usedHomes'));
    }
    
}