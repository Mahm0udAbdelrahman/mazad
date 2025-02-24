<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Models\SendNotification;
use App\Http\Controllers\Controller;
use App\Helpers\SendNotificationHelper;
use App\Notifications\DBFirebasNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DBFireBaseNotification;
use App\Http\Controllers\Api\DeviceTokensController;
use App\Http\Requests\Dashboard\SendNotification\SendNotificationRequest;

class SendNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(public SendNotification $model){}
        /**
         * Display a listing of the resource.
         */
    public function index()
    {
        $data = $this->model->paginate();
        return view('admin.send_notification.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.send_notification.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SendNotificationRequest $request)
{
    $validation = $request->validated();

    $newNotification = new SendNotificationHelper();

    $data = [
        "title_ar" => $request->title_ar,
        "body_ar" => $request->body_ar,
        "title_en" => $request->title_en,
        "body_en" => $request->body_en,
        "title_ru" => $request->title_ru,
        "body_ru" => $request->body_ru,
        'image' => null,
    ];
    $this->model->create($validation);

    User::whereNotNull('fcm_token')->chunk(300, function ($users) use ($data, $newNotification) {

        Notification::send($users, new DBFireBaseNotification($data['title_ar'], $data['body_ar'], $data['title_en'], $data['body_en'],$data['title_ru'],$data['body_ru']));



        $fcmTokens = $users->pluck('fcm_token')->toArray();
        $newNotification->sendNotification($data, $fcmTokens);
    });

    return redirect()->route('Admin.send_notifications.index')->with('success','Created Notification');


}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $send_notification = $this->model->findOrFail($id);
        return view('admin.send_notification.edit',compact('send_notification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SendNotificationRequest $request, string $id)
    {
        $validation = $request->validated();
        $send_notification = $this->model->findOrFail($id);

    $newNotification = new SendNotificationHelper();

    $data = [
        "title_ar" => $validation['title_ar'],
        "body_ar" => $validation['body_ar'],
        "title_en" => $validation['title_en'],
        "body_en" => $validation['body_en'],
        "title_ru" => $validation['title_ru'],
        "body_ru" => $validation['body_ru'],
        'image' => null,
    ];

    $send_notification->update($validation);

    User::whereNotNull('fcm_token')->chunk(300, function ($users) use ($data, $newNotification) {

        Notification::send($users, new DBFireBaseNotification($data['title_ar'], $data['body_ar'], $data['title_en'], $data['body_en']));



        $fcmTokens = $users->pluck('fcm_token')->toArray();
        $newNotification->sendNotification($data, $fcmTokens);
    });

    return redirect()->route('Admin.send_notifications.index')->with('success','Update Notification');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $this->model->findOrFail($id)->delete();
        return redirect()->route('Admin.send_notifications.index')->with('success','Deleted Notification');
    }
}
