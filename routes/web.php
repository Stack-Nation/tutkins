<?php

use App\Http\Controllers\TestController;
// User
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\SettingController as UserSettings;
use App\Http\Controllers\User\PaymentController as UserPayment;
use App\Http\Controllers\User\MessageController as UserMessage;

// Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\ManagerController as AdminManager;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\ApiController as AdminApi;

// Kid
use App\Http\Controllers\Kid\DashboardController as KidDashboard;

// Trainer
use App\Http\Controllers\Trainer\DashboardController as TrainerDashboard;

// Organiser
use App\Http\Controllers\Organiser\DashboardController as OrganiserDashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name("home");

require __DIR__.'/auth.php';

Route::get("admin",function(){
    return redirect()->route("login");
});
Route::get("getting-started",function(){
    return view("auth.get-started");
})->middleware("guest")->name("getting-started");

Route::middleware(["auth","verified"])->group(function(){
    Route::name("user.")->prefix("user")->group(function(){
        Route::get("settings",[UserSettings::class,"settings"])->name("settings");
        Route::post("settings",[UserSettings::class,"update"])->name("settings");
        Route::get("not-verified",[UserSettings::class,"notVerified"])->name("not-verified");

        Route::middleware(["approved"])->group(function(){
            Route::get("{type}/{id}/checkout",[UserPayment::class,"choose"])->name("payment.choose");
            Route::get("{type}/{id}/pay/razorpay",[UserPayment::class,"razorpay"])->name("payment.razorpay");
            Route::post("{type}/{id}/pay/razorpay",[UserPayment::class,"razorpayPay"])->name("payment.razorpay");
            Route::get("{type}/{id}/pay/paytm",[UserPayment::class,"paytm"])->name("payment.paytm");
            Route::post("{type}/{id}/pay/paytm/pay",[UserPayment::class,"paytmPay"])->name("payment.paytm.pay");

            Route::get("chats",[UserMessage::class,"index"])->name("chats");
            Route::post("sendMessage",[UserMessage::class,"sendMessage"])->name("sendMessage");
            Route::post("sendFile",[UserMessage::class,"sendFile"])->name("sendFile");
            Route::post("sendImage",[UserMessage::class,"sendImage"])->name("sendImage");
            Route::get("messages/{id}",[UserMessage::class,"messages"])->name("messages");
            Route::get("message/{id}",[UserMessage::class,"message"])->name("message");
            Route::post("message/{id}",[UserMessage::class,"sendM"])->name("message");
            Route::post("messagesA",[UserMessage::class,"messagesA"])->name("messagesA");
        });
    });
    Route::middleware(["adminAuth"])->name("admin.")->prefix("admin")->group(function(){
        Route::get("dashboard",[AdminDashboard::class,"index"])->name("dashboard");
        Route::get("users/{type?}",[AdminUser::class,"index"])->name("users");

        Route::get("managers",[AdminManager::class,"index"])->name("managers");
        Route::post("manager/create",[AdminManager::class,"create"])->name("manager.create");
        Route::post("manager/delete",[AdminManager::class,"delete"])->name("manager.delete");

        Route::get("categories",[AdminCategory::class,"index"])->name("categories");
        Route::post("category/create",[AdminCategory::class,"create"])->name("category.create");
        Route::post("category/delete",[AdminCategory::class,"delete"])->name("category.delete");

        Route::get("apis",[AdminApi::class,"index"])->name("apis");
        Route::post("apis",[AdminApi::class,"update"])->name("apis");
    });
    Route::middleware(["adminAuth"])->name("manager.")->prefix("manager")->group(function(){
        Route::get("dashboard",[AdminDashboard::class,"index"])->name("dashboard");
        Route::get("users/{type?}",[AdminUser::class,"index"])->name("users");

        Route::get("categories",[AdminCategory::class,"index"])->name("categories");
        Route::post("category/create",[AdminCategory::class,"create"])->name("category.create");
        Route::post("category/delete",[AdminCategory::class,"delete"])->name("category.delete");
    });
    Route::middleware(["kidAuth"])->name("kid.")->prefix("kid")->group(function(){
        Route::get("dashboard",[KidDashboard::class,"index"])->name("dashboard");
    });
    Route::middleware(["trainerAuth"])->name("trainer.")->prefix("trainer")->group(function(){
        Route::middleware(["approved"])->group(function(){
            Route::get("dashboard",[TrainerDashboard::class,"index"])->name("dashboard");
        });
    });
    Route::middleware(["organiserAuth"])->name("organiser.")->prefix("organiser")->group(function(){
        Route::middleware(["approved"])->group(function(){
            Route::get("dashboard",[OrganiserDashboard::class,"index"])->name("dashboard");
        });
    });
});


// Route::post("/test",[TestController::class,"test"])->name("test");