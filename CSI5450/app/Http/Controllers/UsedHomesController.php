<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homes;
use App\Models\Saleshistory;

class UsedHomesController extends Controller
{
    public function showUsedHomes() {
        
        $salesHistoryModel = new Saleshistory();
        
        $usedHomesData = $salesHistoryModel->getHomesSoldMoreThanOnce();
        
        $usedHomesData = collect($usedHomesData);

        //dump($usedHomesData);

        $usedHomes = $usedHomesData->map(function ($homeData) {
            return [
                'FloorSpace' => $homeData['FloorSpace'] ?? 'N/A',
                'Floors' => $homeData['Floors'] ?? 'N/A',
                'BedRooms' => $homeData['BedRooms'] ?? 'N/A',
                'BathRooms' => $homeData['BathRooms'] ?? 'N/A',
                'Street' => $homeData['Street'] ?? 'N/A',
                'City' => $homeData['City'] ?? 'N/A',
                'State' => $homeData['State'] ?? 'N/A',
                'SalesCount' => $homeData['SalesCount'] ?? 0,
            ];
        });

        return view('used_homes', compact('usedHomes'));
    }
}
