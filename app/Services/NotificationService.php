<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public function index($limit = 10)
{
    $user = Auth::user();
    $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate($limit);
    $lang = request()->header('Accept-Language', 'ar');

    $pagination = [
        'currentPage' => $notifications->currentPage(),
        'nextPage'    => $notifications->hasMorePages() ? $notifications->currentPage() + 1 : null,
        'prevPage'    => $notifications->currentPage() > 1 ? $notifications->currentPage() - 1 : null,
        'totalPages'  => $notifications->lastPage(),
        'totalItems'  => $notifications->total(),
        'perPage'     => $notifications->perPage(),
    ];

    $notes = $notifications->map(function ($note) use ($lang) {
        $data = $note->data;

        if ($lang === 'en') {
            unset($data['title_ar'], $data['body_ar'], $data['title_ru'], $data['body_ru']);
        } elseif ($lang === 'ar') {
            unset($data['title_en'], $data['body_en'], $data['title_ru'], $data['body_ru']);
        } elseif ($lang === 'ru') {
            unset($data['title_en'], $data['body_en'], $data['title_ar'], $data['body_ar']);
        }

        $note->data = $data; // Update the note object
        return $note;
    });

    $response = [
        'notifications' => $notes,
        'pagination'    => $pagination,
    ];


    return $response;

    // return $this->sendResponse(
    //     $response,
    //     __('Notifications have been retrieved successfully', [], $lang)
    // );
}

}
