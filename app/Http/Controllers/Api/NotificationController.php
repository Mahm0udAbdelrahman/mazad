<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    public function __construct(public NotificationService $notificationService){}


    public function index(Request $request)
    {

        $data = $this->notificationService->index($request->limit ?? null);

        return $data;

    }
}
