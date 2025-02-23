<?php
namespace App\Services;

use App\Models\Car;
use App\Models\User;
use App\Traits\HasImage;
use App\Models\Insurance;
use App\Helpers\OTPHelper;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class InsuranceService
{
    use HttpResponse;
    protected $baseUrl;
    protected $secretKey;
    protected $publicKey;
    protected $cardId;
    protected $api_key;
    protected $walletId;
    protected $walletIdFrame;
    protected $cardIdFrame;

    public function __construct()
    {
        $this->baseUrl = env('PAYMOB_API_URL');
        $this->secretKey = env('PAYMOB_SECRET_KEY');
        $this->publicKey = env('PAYMOB_PUBLIC_KEY');
        $this->cardId = env('PAYMOB_INTEGRATION_ID');
        $this->walletId = env('PAYMOB_WALLET_INTEGRATION_ID');
        $this->api_key = env('PAYMOB_API_KEY');
        $this->cardIdFrame = env('PAYMOB_IFRAME_ID');
        $this->walletIdFrame= env('PAYMOB_WALLET_IFRAME_ID');
    }

    public function store($data)
    {

    $user = auth()->user();

    if (!$user) {
        return response()->json(['success' => false, 'message' => 'المستخدم غير موجود'], 401);
    }

    $authResponse = Http::post("{$this->baseUrl}/api/auth/tokens", [
        'api_key' => $this->api_key,
    ]);

    if (!$authResponse->successful()) {
        return $this->errorResponse(message: 'فشل في المصادقة مع Paymob');
    }

    $authToken = $authResponse->json()['token'];

    $orderResponse = Http::withHeaders([
        'Authorization' => 'Bearer ' . $authToken,
        'Content-Type' => 'application/json',
    ])->post("{$this->baseUrl}/api/ecommerce/orders", [
        'auth_token' => $authToken,
        'delivery_needed' => false,
        'amount_cents' => $data['balance'] * 100,
        'currency' => 'EGP',
        'items' => [],
    ]);


    if (!$orderResponse->successful()) {
        return $this->errorResponse(message: 'فشل في إنشاء الطلب في Paymob');
    }

    $paymobOrderId = $orderResponse->json()['id'];

    $billing = [
        "apartment" => "123",
        "first_name" => $user->name,
        "last_name" => "غير محدد",
        "street" => 'لا يوجد عنوان',
        "building" => "456",
        "phone_number" => $user->phone,
        "city" => 'غير محدد',
        "country" => "EG",
        "email" => $user->email,
        "floor" => "1",
        "state" => 'غير محدد',
        "postal_code" => "12345",
        "shipping_method" => "PKG"
    ];

    $integrationId = request()->input('payment_method') == 'card' ? $this->cardId : $this->walletId;


    $paymentKeyResponse = Http::withHeaders([
        'Authorization' => 'Bearer ' . $authToken,
        'Content-Type' => 'application/json',
    ])->post("{$this->baseUrl}/api/acceptance/payment_keys", [
        'auth_token' => $authToken,
        'amount_cents' => $data['balance'] * 100,
        'expiration' => 3600,
        'order_id' => $paymobOrderId,
        'billing_data' => $billing,
        'currency' => 'EGP',
        'integration_id' => $integrationId,
    ]);

    $insurance = Insurance::firstOrCreate(
        ['user_id' => $user->id],
        [
            'balance'        => 0,
            'payment_method' => request('payment_method'),
            'payment_id'     => $paymobOrderId ?? null,

        ]
    );

    $insurance->increment('balance', $data['balance'] ?? 0);

    $insurance->update([
        'payment_method' => request('payment_method'),
        'payment_id'     => $paymobOrderId ?? null,
        'payment_status' => 'pending',
    ]);




    if (!$paymentKeyResponse->successful()) {
        Log::error('Paymob Payment Key Error:', $paymentKeyResponse->json());
        return $this->errorResponse(message: 'فشل في إنشاء مفتاح الدفع');
    }

    $paymentKey = $paymentKeyResponse->json()['token'];


    $iframeId = request()->input('payment_method') == 'card' ? env('PAYMOB_IFRAME_ID') : env('PAYMOB_WALLET_IFRAME_ID');
    return [
        'payment_id' => $paymobOrderId,
        'balance' => $data['balance'],
        'redirect_url' => "https://accept.paymob.com/api/acceptance/iframes/{$iframeId}?payment_token={$paymentKey}&amount={$data['balance']}",
    ];
    }



}
