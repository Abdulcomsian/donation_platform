<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function campaign(){
        return view('campaigns.index');
    }
}
