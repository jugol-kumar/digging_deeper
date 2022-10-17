<?php

namespace App\Http\Controllers;

use App\Models\BusinessSetting;
use Illuminate\Http\Request;

class BusinessSettingController extends Controller
{
    public function settingView(){
        return view('business.settings');
    }

    public function update(Request $request){

        foreach ($request->types as $type){
            BusinessSetting::updateOrCreate([
                'key' => $type,
                'value' => $request[$type]
            ]);
        }

        return "save successfully done";
    }


}
