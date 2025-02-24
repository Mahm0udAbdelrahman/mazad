<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Car;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\ModelHasRole;
use Illuminate\Http\Request;
use App\Models\TransationHestory;
use Illuminate\Support\Facades\DB;
use App\Models\DropshippingProduct;
use App\Models\ShippingGovernorate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $vendor = User::where('service', 'vendor')->count();
        $merchant = User::where('service', 'merchant')->count();
        $car = Car::count();
        // $product_provider = Product::count();
        // $product_dropshipping = DropshippingProduct::count();
        // $complete = TransationHestory::where('status', '=', 'complete')->count();
        // $pending = TransationHestory::where('status', '=', 'pending')->count();
        // $order = Order::count();
        // $shipping_governorate = ShippingGovernorate::count();

        return view('admin.index', compact('vendor', 'merchant', 'car'));
    }

    public function confirmDelete($model, $id)
    {
        $data = app('App\\Models\\' . ucfirst($model))->find($id);
        if ($model == 'role') {
            $data->revokePermissionTo($data->permissions);
        }

        if ($model == 'user') {
            DB::table('model_has_roles')->where('model_id', $id)->delete();

        }

        $data->delete();
        Session::flash('message', ['type' => 'success', 'text' => __('Deleted successfully')]);
        return redirect()->back();
    }
}
