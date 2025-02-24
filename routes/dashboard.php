<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\{
    AuthController,
    HomeController,
    UserController,
    RoleController,
    CategoryController,
    AskCategoryController,
    AskController,
    NotificationController,
    ProviderController,
    PrivacyPolicyController,
    CountryController,
    GovernorateController,
    SendNotificationController,
    MaintenanceCenterController
};
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
        Route::get('/', function () {
            return redirect()->route('login');
        })->middleware('guest');
        Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
        Route::post('/login', [AuthController::class, 'loginAction'])->name('loginAction')->middleware('guest');

        Route::group(['middleware'=>['auth','notification','admin'],'prefix' => 'admin', 'as' => 'Admin.'], function () {
            // home
            Route::get('/home', [HomeController::class, 'index'])->name('home');
            Route::get('/delete/{model}/{id}', [HomeController::class, 'confirmDelete'])->name('confirmDelete');
            Route::post('/products-orders-year/{year}', [HomeController::class, 'getByYear'])->name('getByYear');

          
            // notifications

            Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications');
            Route::delete('/notifications/{id}',[NotificationController::class, 'destroy']);
            Route::get('/notifications/read-all', [NotificationController::class, 'ReadAll'])->name('notifications.markAllRead');
            Route::post('/notifications/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');


            Route::resource('send_notifications', SendNotificationController::class);


            //country
            Route::resource('countries', CountryController::class);
            // roles
            Route::resource('roles', RoleController::class);

            // users
            Route::resource('users', UserController::class);
            Route::get('/profile', [UserController::class, 'profile'])->name('profile');
            Route::put('/profile', [UserController::class, 'updateProfile'])->name('updateProfile');
            Route::get('/get_users', [UserController::class, 'dataTable'])->name('getUsers');

            // providers
            Route::resource('providers', ProviderController::class);
            Route::get('/profile/provider', [ProviderController::class, 'profile'])->name('profileProviders');
            Route::put('/profile/provider', [ProviderController::class, 'updateProfile'])->name('updateProfileProviders');
            Route::get('/get_providers', [ProviderController::class, 'dataTable'])->name('getProviders');
            Route::delete('/admin/providers/{id}', [ProviderController::class, 'destroy'])->name('Admin.providers.destroy');


            // categories
            Route::resource('categories', CategoryController::class);

            // Maintenance Center
            Route::resource('maintenance_centers', MaintenanceCenterController::class);

            // ask_categories
            Route::resource('ask_categories', AskCategoryController::class);

            // asks
            Route::resource('asks', AskController::class);

          
        
            //governorates

            Route::resource('governorates', GovernorateController::class);

                   // privacy_policy
            Route::get('privacy_policy/show', [PrivacyPolicyController::class,'show'])->name('privacy_policy.show');
            Route::put('privacy_policy/update', [PrivacyPolicyController::class, 'update'])->name('privacy_policy.update');



            // logout
            Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        });
    });

    // Route::get('/get-governorates/{countryId}', function ($countryId) {
    //     $governorates = Governorate::where('country_id', $countryId)->get();
    //     return response()->json($governorates);
    // });


// solve wallet iframe with package => done
// solve wallet id , response method and callback or response with package with intention!! => done
// reomve from package file => done

// order => one provider or many ?! if many solve shipping ?! => done
// dashboard manage orders status, delivery and dropshipping. => in progress

// carts => every cart has product and total so this is one provider of the first cart => done
//       => in dashboard order profile manage this view and every provider has its own from this order. => done

// dashboard users crud => done
// dashboard roles crud => done
// dashboard categories crud => done
// dashboard shipping crud => done
// dashboard orders crud => in progress
