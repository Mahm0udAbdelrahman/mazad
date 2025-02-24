<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PrivacyPolicy\PrivacyPolicyRequest;

class PrivacyPolicyController extends Controller
{
    public function show()
   {

       $privacy_policy = PrivacyPolicy::first();
        return view("admin.privacy_policy.edit", compact("privacy_policy"));
     }
     public function update(PrivacyPolicyRequest $request)
     {
         $data = $request->validated();

         $PrivacyPolicy = PrivacyPolicy::first();

         if ($PrivacyPolicy) {
             $PrivacyPolicy->update($data);
         } else {
             PrivacyPolicy::create($data);
         }

         return redirect()->back()->with('success', 'Privacy Policy updated successfully!');

}
}
