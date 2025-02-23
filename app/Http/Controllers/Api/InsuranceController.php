<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Insurance\InsuranceRequest;
use App\Models\Insurance;
use App\Services\InsuranceService;

class InsuranceController extends Controller
{
    public function __construct(public InsuranceService $insuranceService){}
    public function store(InsuranceRequest $insuranceRequest)
    {
        return $this->insuranceService->store($insuranceRequest->validated());
    }

    public function callback(Request $request)
    {
        $data = $request->all();
        if($data){
            $insurance=Insurance::where('payment_id','=',$data['order'])->first();

            if($data['success']==true||$data['success']=="true"){
                $insurance->update(['payment_status'=>'paid']);
                $url = 'http://127.0.0.1:8000/api/callback/?id=' . $data['id'] . '&success=' . $data['success'];

                return view('payment', compact('insurance', 'url'));
            }
            else{
                $insurance->update(['payment_status'=>'faild']);
                $url = 'http://127.0.0.1:8000/api/callback/?id=' . $data['id'] . '&success=' . $data['success'];
                return view('payment', compact('insurance', 'url'));
            }
        }
    }
}
