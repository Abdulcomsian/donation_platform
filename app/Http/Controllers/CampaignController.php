<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function campaign()
    {
        return view('campaigns.index');
    }

    public function getCampaignForm()
    {
        return view('campaigns.create');
    }

    public function campaignCreated()
    {
        return view('campaigns.campaign-created');
    }
}
