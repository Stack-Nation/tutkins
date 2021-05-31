<?php

use App\Http\Controllers\TestController;
// User
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\SettingController as UserSettings;
use App\Http\Controllers\User\PaymentController as UserPayment;
use App\Http\Controllers\User\MessageController as UserMessage;
use App\Http\Controllers\User\WalletController as UserWallet;

// Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\ManagerController as AdminManager;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\ApiController as AdminApi;
use App\Http\Controllers\Admin\ProgramController as AdminProgram;
use App\Http\Controllers\Admin\EventController as AdminEvent;
use App\Http\Controllers\Admin\WithdrawalController as AdminWithdrawal;

// Kid
use App\Http\Controllers\Kid\DashboardController as KidDashboard;
use App\Http\Controllers\Kid\ProfileController as KidProfile;
use App\Http\Controllers\Kid\ProgramController as KidProgram;
use App\Http\Controllers\Kid\EventController as KidEvent;

// Trainer
use App\Http\Controllers\Trainer\DashboardController as TrainerDashboard;
use App\Http\Controllers\Trainer\ProfileController as TrainerProfile;
use App\Http\Controllers\Trainer\ProgramController as TrainerProgram;

// Organiser
use App\Http\Controllers\Organiser\DashboardController as OrganiserDashboard;
use App\Http\Controllers\Organiser\ProfileController as OrganiserProfile;
use App\Http\Controllers\Organiser\EventController as OrganiserEvent;

// Program
use App\Http\Controllers\Program\MainController as ProgramMain;
use App\Http\Controllers\Program\EnrollController as ProgramEnroll;

// Event
use App\Http\Controllers\Event\MainController as EventMain;
use App\Http\Controllers\Event\EnrollController as EventEnroll;

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
        Route::post("training",[UserSettings::class,"training"])->name("training");
        Route::post("parent",[UserSettings::class,"parent"])->name("parent");

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

            // Wallet
            Route::get('wallet',[UserWallet::class,"index"])->name('wallet');
            Route::get('wallet/accounts',[UserWallet::class,"accounts"])->name('wallet.accounts');
            Route::post('wallet/withdraw',[UserWallet::class,"withdraw"])->name('wallet.withdraw');
            Route::post('wallet/accounts/bank',[UserWallet::class,"addBank"])->name('wallet.addBank');
            Route::post('wallet/accounts/upi',[UserWallet::class,"addUpi"])->name('wallet.addUpi');
        });
    });
    Route::get("kid/view-profile/{id}",[KidProfile::class,"view"])->name("kid.view-profile");
    Route::get("trainer/view-profile/{id}",[TrainerProfile::class,"view"])->name("trainer.view-profile");
    Route::get("organiser/view-profile/{id}",[TrainerProfile::class,"view"])->name("organiser.view-profile");
    Route::middleware(["adminAuth"])->name("admin.")->prefix("admin")->group(function(){
        Route::get("dashboard",[AdminDashboard::class,"index"])->name("dashboard");
        Route::get("users/{type?}",[AdminUser::class,"index"])->name("users");
        Route::get("pending-users/{type?}",[AdminUser::class,"pending"])->name("users.pending");
        Route::post("pending-users/approve",[AdminUser::class,"approve"])->name("users.approve");
        Route::post("pending-users/deny",[AdminUser::class,"deny"])->name("users.deny");

        Route::get("managers",[AdminManager::class,"index"])->name("managers");
        Route::post("manager/create",[AdminManager::class,"create"])->name("manager.create");
        Route::post("manager/delete",[AdminManager::class,"delete"])->name("manager.delete");

        Route::get("categories",[AdminCategory::class,"index"])->name("categories");
        Route::post("category/create",[AdminCategory::class,"create"])->name("category.create");
        Route::post("category/delete",[AdminCategory::class,"delete"])->name("category.delete");

        Route::get("apis",[AdminApi::class,"index"])->name("apis");
        Route::post("apis",[AdminApi::class,"update"])->name("apis");

        Route::get("programs",[AdminProgram::class,"index"])->name("programs");

        Route::get("events",[AdminEvent::class,"index"])->name("events");

        //Withdraw methods
        Route::get('withdrawals/pending', [AdminWithdrawal::class,"pending"])->name('withdrawals.pending');
        Route::post('withdrawals/accept', [AdminWithdrawal::class,"accept"])->name('withdrawals.accept');
        Route::post('withdrawals/reject', [AdminWithdrawal::class,"reject"])->name('withdrawals.reject');
        Route::get('withdrawals/approved', [AdminWithdrawal::class,"approved"])->name('withdrawals.approved');
    });
    Route::middleware(["adminAuth"])->name("manager.")->prefix("manager")->group(function(){
        Route::get("dashboard",[AdminDashboard::class,"index"])->name("dashboard");
        Route::get("users/{type?}",[AdminUser::class,"index"])->name("users");
        Route::get("pending-users/{type?}",[AdminUser::class,"pending"])->name("users.pending");

        Route::get("categories",[AdminCategory::class,"index"])->name("categories");
        Route::post("category/create",[AdminCategory::class,"create"])->name("category.create");
        Route::post("category/delete",[AdminCategory::class,"delete"])->name("category.delete");

        Route::get("programs",[AdminProgram::class,"index"])->name("programs");
    });
    Route::middleware(["kidAuth"])->name("kid.")->prefix("kid")->group(function(){
        Route::get("dashboard",[KidDashboard::class,"index"])->name("dashboard");
        
        Route::get("profile",[KidProfile::class,"index"])->name("profile");
        Route::post("profile",[KidProfile::class,"update"])->name("profile");

        Route::get("programs",[KidProgram::class,"index"])->name("programs");
        Route::get("events",[KidEvent::class,"index"])->name("events");
    });
    Route::middleware(["trainerAuth"])->name("trainer.")->prefix("trainer")->group(function(){
        Route::get("profile",[TrainerProfile::class,"index"])->name("profile");
        Route::post("profile",[TrainerProfile::class,"update"])->name("profile");
        Route::middleware(["approved"])->group(function(){
            Route::get("dashboard",[TrainerDashboard::class,"index"])->name("dashboard");

            Route::get("programs",[TrainerProgram::class,"index"])->name("programs");
            Route::get("programs/subscribers/{id}",[TrainerProgram::class,"subscribers"])->name("programs.subscribers");
            Route::get("programs/create",[TrainerProgram::class,"create"])->name("programs.create");
            Route::post("programs/create",[TrainerProgram::class,"store"])->name("programs.create");
            Route::get("programs/edit/{id}",[TrainerProgram::class,"edit"])->name("programs.edit");
            Route::post("programs/edit/{id}",[TrainerProgram::class,"update"])->name("programs.edit");
            Route::post("programs/delete",[TrainerProgram::class,"delete"])->name("programs.delete");
        });
    });
    Route::middleware(["organiserAuth"])->name("organiser.")->prefix("organiser")->group(function(){
        Route::get("profile",[OrganiserProfile::class,"index"])->name("profile");
        Route::post("profile",[OrganiserProfile::class,"update"])->name("profile");
        Route::middleware(["approved"])->group(function(){
            Route::get("dashboard",[OrganiserDashboard::class,"index"])->name("dashboard");

            Route::get("events",[OrganiserEvent::class,"index"])->name("events");
            Route::get("events/subscribers/{id}",[OrganiserEvent::class,"subscribers"])->name("events.subscribers");
            Route::get("events/create",[OrganiserEvent::class,"create"])->name("events.create");
            Route::post("events/create",[OrganiserEvent::class,"store"])->name("events.create");
            Route::get("events/edit/{id}",[OrganiserEvent::class,"edit"])->name("events.edit");
            Route::post("events/edit/{id}",[OrganiserEvent::class,"update"])->name("events.edit");
            Route::post("events/delete",[OrganiserEvent::class,"delete"])->name("events.delete");
        });
    });
});

Route::name("programs.")->prefix("programs")->group(function() {
    Route::get("/",[ProgramMain::class,"index"])->name("index");
    Route::get("view/{id}/{title}",[ProgramMain::class,"view"])->name("view");
    Route::post("search",[ProgramMain::class,"search"])->name("search");
    Route::middleware(["auth","verified"])->name("subscribe.")->prefix("subscribe")->group(function(){
        Route::get("/{id}/slot",[ProgramEnroll::class,"chooseSlot"])->name("slot");
        Route::post("/{id}",[ProgramEnroll::class,"enroll"])->name("add");
        Route::get("/{id}/feedback",[ProgramMain::class,"feedback"])->name("feedback");
        Route::post("/{id}/feedback",[ProgramMain::class,"addFeedback"])->name("feedback");
    });
});

Route::name("events.")->prefix("events")->group(function() {
    Route::get("/",[EventMain::class,"index"])->name("index");
    Route::get("view/{id}/{title}",[EventMain::class,"view"])->name("view");
    Route::post("search",[EventMain::class,"search"])->name("search");
    Route::middleware(["auth","verified"])->name("subscribe.")->prefix("subscribe")->group(function(){
        Route::get("/{id}/slot",[EventEnroll::class,"chooseSlot"])->name("slot");
        Route::post("/{id}",[EventEnroll::class,"enroll"])->name("add");
        Route::get("/{id}/feedback",[EventMain::class,"feedback"])->name("feedback");
        Route::post("/{id}/feedback",[EventMain::class,"addFeedback"])->name("feedback");
    });
});


// Route::post("/test",[TestController::class,"test"])->name("test");