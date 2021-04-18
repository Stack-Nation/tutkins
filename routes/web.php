<?php

use App\Http\Controllers\TestController;
// User
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\SettingController as UserSettings;
use App\Http\Controllers\User\GroupController as UserGroup;
use App\Http\Controllers\User\ZoomController as UserZoom;
use App\Http\Controllers\User\PaymentController as UserPayment;
use App\Http\Controllers\User\MessageController as UserMessage;
use App\Http\Controllers\User\ResumeController as UserResume;

// Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\ManagerController as AdminManager;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\CourseController as AdminCourse;
use App\Http\Controllers\Admin\WebinarController as AdminWebinar;
use App\Http\Controllers\Admin\MentoringController as AdminMentoring;
use App\Http\Controllers\Admin\ClassController as AdminClass;
use App\Http\Controllers\Admin\GroupController as AdminGroup;
use App\Http\Controllers\Admin\ApiController as AdminApi;
use App\Http\Controllers\Admin\TestsController as AdminTests;

// Instructor
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboard;
use App\Http\Controllers\Instructor\ProfileController as InstructorProfile;
use App\Http\Controllers\Instructor\CourseController as InstructorCourse;
use App\Http\Controllers\Instructor\ClassController as InstructorClass;
use App\Http\Controllers\Instructor\ExamController as InstructorExam;
use App\Http\Controllers\Instructor\TestsController as InstructorTests;
use App\Http\Controllers\Instructor\WebinarController as InstructorWebinar;
use App\Http\Controllers\Instructor\MentoringController as InstructorMentoring;
use App\Http\Controllers\Instructor\LearningController as InstructorLearning;

// Course
use App\Http\Controllers\Course\MainController as CourseMain;
use App\Http\Controllers\Course\EnrollController as CourseEnroll;

// Group
use App\Http\Controllers\Group\MainController as GroupMain;
use App\Http\Controllers\Group\SettingsController as GroupSettings;
use App\Http\Controllers\Group\PostController as GroupPost;

// Webinar
use App\Http\Controllers\Webinar\MainController as WebinarMain;
use App\Http\Controllers\Webinar\SubscribeController as WebinarSubscribe;

// Mentoring
use App\Http\Controllers\Mentoring\MainController as MentoringMain;
use App\Http\Controllers\Mentoring\SubscribeController as MentoringSubscribe;

// Mentee
use App\Http\Controllers\Mentee\DashboardController as MenteeDashboard;
use App\Http\Controllers\Mentee\ProfileController as MenteeProfile;
use App\Http\Controllers\Mentee\CourseController as MenteeCourse;
use App\Http\Controllers\Mentee\WebinarController as MenteeWebinar;
use App\Http\Controllers\Mentee\MentoringController as MenteeMentoring;
use App\Http\Controllers\Mentee\TransactionController as MenteeTransaction;

// Post
use App\Http\Controllers\Post\MainController as PostMain;

// Organisation
use App\Http\Controllers\Organisation\DashboardController as OrganisationDashboard;
use App\Http\Controllers\Organisation\ProfileController as OrganisationProfile;
use App\Http\Controllers\Organisation\MenteeController as OrganisationMentee;
use App\Http\Controllers\Organisation\MentorController as OrganisationMentor;

// Institution
use App\Http\Controllers\Institution\DashboardController as InstitutionDashboard;
use App\Http\Controllers\Institution\ProfileController as InstitutionProfile;
use App\Http\Controllers\Institution\MenteeController as InstitutionMentee;
use App\Http\Controllers\Institution\MentorController as InstitutionMentor;

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
    
        Route::get("groups",[UserGroup::class,"index"])->name("groups");
        Route::get("groups/create",[UserGroup::class,"create"])->name("groups.create");
        Route::post("groups/create",[UserGroup::class,"store"])->name("groups.create");
        Route::get("groups/member",[UserGroup::class,"member"])->name("groups.member");

        Route::get("zoom/auth",[UserZoom::class,"auth"])->name("zoom.auth");

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

        Route::get("resume",[UserResume::class,"index"])->name("resume");
        Route::post("experience",[UserResume::class,"experience"])->name("experience");
        Route::post("skill",[UserResume::class,"skill"])->name("skill");
        Route::post("project",[UserResume::class,"project"])->name("project");
        Route::post("achievement",[UserResume::class,"achievement"])->name("achievement");
        Route::post("social",[UserResume::class,"social"])->name("social");
        Route::get("{id}/{name}/view",[UserResume::class,"view"])->name("view");
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

        Route::get("courses/{type?}",[AdminCourse::class,"index"])->name("courses");
        Route::post("course/action/approve",[AdminCourse::class,"approve"])->name("course.approve");
        Route::post("course/action/reject",[AdminCourse::class,"reject"])->name("course.reject");

        Route::get("webinars",[AdminWebinar::class,"index"])->name("webinars");

        Route::get("mentorings",[AdminMentoring::class,"index"])->name("mentorings");

        Route::get("live-classes",[AdminClass::class,"index"])->name("classes");

        Route::get("tests",[AdminTests::class,"index"])->name("tests");
        Route::get("tests/groups",[AdminTests::class,"groups"])->name("tests.groups");

        Route::get("apis",[AdminApi::class,"index"])->name("apis");
        Route::post("apis",[AdminApi::class,"update"])->name("apis");
    });
    Route::middleware(["adminAuth"])->name("manager.")->prefix("manager")->group(function(){
        Route::get("dashboard",[AdminDashboard::class,"index"])->name("dashboard");
        Route::get("users/{type?}",[AdminUser::class,"index"])->name("users");

        Route::get("categories",[AdminCategory::class,"index"])->name("categories");
        Route::post("category/create",[AdminCategory::class,"create"])->name("category.create");
        Route::post("category/delete",[AdminCategory::class,"delete"])->name("category.delete");

        Route::get("courses/{type?}",[AdminCourse::class,"index"])->name("courses");
        Route::post("course/action/approve",[AdminCourse::class,"approve"])->name("course.approve");
        Route::post("course/action/reject",[AdminCourse::class,"reject"])->name("course.reject");

        Route::get("webinars",[AdminWebinar::class,"index"])->name("webinars");

        Route::get("mentorings",[AdminMentoring::class,"index"])->name("mentorings");

        Route::get("live-classes",[AdminClass::class,"index"])->name("classes");

        Route::get("tests",[AdminTests::class,"index"])->name("tests");
        Route::get("tests/groups",[AdminTests::class,"groups"])->name("tests.groups");
    });
    Route::middleware(["instructorAuth"])->name("instructor.")->prefix("instructor")->group(function(){
        Route::get("dashboard",[InstructorDashboard::class,"index"])->name("dashboard");

        Route::get("profile",[InstructorProfile::class,"profile"])->name("profile");
        Route::post("profile",[InstructorProfile::class,"update"])->name("profile");

        Route::get("courses/{type?}",[InstructorCourse::class,"index"])->name("courses");
        Route::get("courses/create/new",[InstructorCourse::class,"create"])->name("courses.create");
        Route::post("courses/create/new",[InstructorCourse::class,"store"])->name("courses.create");
        Route::get("courses/edit/{id}/landing",[InstructorCourse::class,"editLand"])->name("courses.edit-land");
        Route::post("courses/edit/{id}/landing",[InstructorCourse::class,"updateLand"])->name("courses.edit-land");
        Route::get("courses/edit/{id}/target",[InstructorCourse::class,"editTarget"])->name("courses.edit-target");
        Route::post("courses/edit/{id}/target",[InstructorCourse::class,"updateTarget"])->name("courses.edit-target");
        Route::get("courses/edit/{id}/curriculum",[InstructorCourse::class,"editCir"])->name("courses.edit-cir");
        Route::post("courses/edit/{id}/curriculum",[InstructorCourse::class,"updateCir"])->name("courses.edit-cir");
        Route::get("courses/edit/{id}/settings",[InstructorCourse::class,"editSettings"])->name("courses.edit-settings");
        Route::post("courses/edit/{id}/settings/review",[InstructorCourse::class,"review"])->name("courses.edit-settings.review");
        Route::post("courses/edit/{id}/settings/publish",[InstructorCourse::class,"publish"])->name("courses.edit-settings.publish");
        Route::post("courses/edit/{id}/settings/delete",[InstructorCourse::class,"delete"])->name("courses.edit-settings.delete");

        Route::get("classes",[InstructorClass::class,"index"])->name("classes");
        Route::get("classes/create",[InstructorClass::class,"create"])->name("classes.create");
        Route::post("classes/create",[InstructorClass::class,"store"])->name("classes.create");
        Route::get("classes/start/{id}/{title}",[InstructorClass::class,"start"])->name("classes.start");

        Route::get("exams",[InstructorExam::class,"index"])->name("exams");
        Route::get("exams/subject/create",[InstructorExam::class,"createSubject"])->name("exams.subject.create");
        Route::post("exams/subject/create",[InstructorExam::class,"storeSubject"])->name("exams.subject.create");
        Route::post("exams/subject/delete",[InstructorExam::class,"deleteSubject"])->name("exams.subject.delete");
        Route::get("exams/categories",[InstructorExam::class,"categories"])->name("exams.categories");
        Route::get("exams/categories/create",[InstructorExam::class,"createCategory"])->name("exams.categories.create");
        Route::post("exams/categories/create",[InstructorExam::class,"storeCategory"])->name("exams.categories.create");
        Route::post("exams/categories/delete",[InstructorExam::class,"deleteCategory"])->name("exams.categories.delete");
        Route::get("exams/questions",[InstructorExam::class,"questions"])->name("exams.questions");
        Route::get("exams/questions/create",[InstructorExam::class,"createQuestion"])->name("exams.questions.create");
        Route::post("exams/questions/create",[InstructorExam::class,"storeQuestion"])->name("exams.questions.create");
        Route::post("exams/questions/delete",[InstructorExam::class,"deleteQuestion"])->name("exams.questions.delete");

        Route::get("tests",[InstructorTests::class,"index"])->name("tests");
        Route::get("tests/create",[InstructorTests::class,"createTest"])->name("tests.create");
        Route::post("tests/create",[InstructorTests::class,"storeTest"])->name("tests.create");
        Route::post("tests/delete",[InstructorTests::class,"deleteTest"])->name("tests.delete");
        Route::get("tests/groups",[InstructorTests::class,"groups"])->name("tests.groups");
        Route::get("tests/groups/create",[InstructorTests::class,"createTestGroup"])->name("tests.groups.create");
        Route::post("tests/groups/create",[InstructorTests::class,"storeTestGroup"])->name("tests.groups.create");
        Route::post("tests/groups/delete",[InstructorTests::class,"deleteTestGroup"])->name("tests.groups.delete");

        Route::get("webinars",[InstructorWebinar::class,"index"])->name("webinars");
        Route::get("webinars/create",[InstructorWebinar::class,"create"])->name("webinars.create");
        Route::post("webinars/create",[InstructorWebinar::class,"store"])->name("webinars.create");
        Route::post("webinars/delete",[InstructorWebinar::class,"delete"])->name("webinars.delete");
        Route::get("webinars/{id}/form/create",[InstructorWebinar::class,"createForm"])->name("webinars.form.create");
        Route::post("webinars/{id}/form/create",[InstructorWebinar::class,"storeForm"])->name("webinars.form.create");

        Route::get("mentorings",[InstructorMentoring::class,"index"])->name("mentorings");
        Route::get("mentorings/create",[InstructorMentoring::class,"create"])->name("mentorings.create");
        Route::post("mentorings/create",[InstructorMentoring::class,"store"])->name("mentorings.create");
        Route::post("mentorings/delete",[InstructorMentoring::class,"delete"])->name("mentorings.delete");
        Route::get("mentorings/{id}/form/create",[InstructorMentoring::class,"createForm"])->name("mentorings.form.create");
        Route::post("mentorings/{id}/form/create",[InstructorMentoring::class,"storeForm"])->name("mentorings.form.create");

        Route::get("learnings",[InstructorLearning::class,"index"])->name("learnings");
        Route::get("learnings/create",[InstructorLearning::class,"create"])->name("learnings.create");
        Route::post("learnings/create",[InstructorLearning::class,"store"])->name("learnings.create");
        Route::post("learnings/delete",[InstructorLearning::class,"delete"])->name("learnings.delete");
        Route::get("learnings/{id}/certificate/create",[InstructorLearning::class,"createCertificate"])->name("learnings.certificate.create");
        Route::post("learnings/{id}/certificate/create",[InstructorLearning::class,"storeCertificate"])->name("learnings.certificate.create");
    });
    Route::middleware(["menteeAuth"])->name("mentee.")->prefix("mentee")->group(function(){
        Route::get("dashboard",[MenteeDashboard::class,"index"])->name("dashboard");

        Route::get("profile",[MenteeProfile::class,"profile"])->name("profile");
        Route::post("profile",[MenteeProfile::class,"update"])->name("profile");

        Route::get("courses",[MenteeCourse::class,"index"])->name("courses");
        Route::get("courses/view/{id}/{title}/section/{section_id}/lecture/{lecture_id}",[MenteeCourse::class,"view"])->name("courses.view");
        Route::post("courses/quiz/{id}/{title}/section/{section_id}/lecture/{lecture_id}",[MenteeCourse::class,"quiz"])->name("courses.quiz");
        Route::get("courses/feedback/{id}/{title}",[MenteeCourse::class,"feedback"])->name("courses.feedback");
        Route::get("courses/{id}/{title}/classes",[MenteeCourse::class,"classes"])->name("courses.classes");
        Route::post("courses/feedback/{id}/{title}",[MenteeCourse::class,"addFeedback"])->name("courses.feedback");

        Route::get("webinars",[MenteeWebinar::class,"index"])->name("webinars");

        Route::get("mentorings",[MenteeMentoring::class,"index"])->name("mentorings");

        Route::get("transactions",[MenteeTransaction::class,"index"])->name("transactions");
    });
    Route::middleware(["organisationAuth"])->name("organisation.")->prefix("organisation")->group(function(){
        Route::get("dashboard",[OrganisationDashboard::class,"index"])->name("dashboard");

        Route::get("profile",[OrganisationProfile::class,"profile"])->name("profile");
        Route::post("profile",[OrganisationProfile::class,"update"])->name("profile");

        Route::get("mentee",[OrganisationMentee::class,"index"])->name("mentees");
        Route::post("mentee/create",[OrganisationMentee::class,"create"])->name("mentees.create");
        Route::post("mentee/create/bulk",[OrganisationMentee::class,"createBulk"])->name("mentees.create.bulk");
        Route::post("mentee/delete",[OrganisationMentee::class,"delete"])->name("mentees.delete");

        Route::get("mentor",[OrganisationMentor::class,"index"])->name("mentors");
        Route::post("mentor/create",[OrganisationMentor::class,"create"])->name("mentors.create");
        Route::post("mentor/create/bulk",[OrganisationMentor::class,"createBulk"])->name("mentors.create.bulk");
        Route::post("mentor/delete",[OrganisationMentor::class,"delete"])->name("mentors.delete");
    });
    Route::middleware(["institutionAuth"])->name("institution.")->prefix("institution")->group(function(){
        Route::get("dashboard",[InstitutionDashboard::class,"index"])->name("dashboard");
        Route::get("dashboard",[InstitutionDashboard::class,"index"])->name("dashboard");

        Route::get("profile",[InstitutionProfile::class,"profile"])->name("profile");
        Route::post("profile",[InstitutionProfile::class,"update"])->name("profile");

        Route::get("mentee",[InstitutionMentee::class,"index"])->name("mentees");
        Route::post("mentee/create",[InstitutionMentee::class,"create"])->name("mentees.create");
        Route::post("mentee/create/bulk",[InstitutionMentee::class,"createBulk"])->name("mentees.create.bulk");
        Route::post("mentee/delete",[InstitutionMentee::class,"delete"])->name("mentees.delete");

        Route::get("mentor",[InstitutionMentor::class,"index"])->name("mentors");
        Route::post("mentor/create",[InstitutionMentor::class,"create"])->name("mentors.create");
        Route::post("mentor/create/bulk",[InstitutionMentor::class,"createBulk"])->name("mentors.create.bulk");
        Route::post("mentor/delete",[InstitutionMentor::class,"delete"])->name("mentors.delete");
    });
});
Route::name("courses.")->prefix("courses")->group(function(){
    Route::get("/",[CourseMain::class,"index"])->name("index");
    Route::get("view/{id}/{title}",[CourseMain::class,"view"])->name("view");
    Route::middleware(["auth","verified"])->name("enroll.")->prefix("enroll")->group(function(){
        Route::get("/{id}",[CourseEnroll::class,"enroll"])->name("add");
    });
});
Route::name("groups.")->prefix("groups")->group(function(){
    Route::get("/",[GroupMain::class,"index"])->name("index");
    Route::middleware(["auth","verified"])->group(function(){
        Route::get("view/{id}/{title}",[GroupMain::class,"view"])->name("view");
        Route::post("change-cover/{id}",[GroupMain::class,"changeCover"])->name("change-cover");
        Route::post("change-photo/{id}",[GroupMain::class,"changePhoto"])->name("change-photo");
        Route::post("change-description/{id}",[GroupMain::class,"changeDescription"])->name("change-description");
        Route::post("change-name/{id}",[GroupMain::class,"changeName"])->name("change-name");
        Route::get("settings/{id}",[GroupSettings::class,"settings"])->name("settings");
        Route::post("settings/{id}",[GroupSettings::class,"settingsChange"])->name("settings");
        Route::post("settings/action/delete",[GroupSettings::class,"del"])->name("delete");
        Route::get("settings/{id}/join-requests",[GroupSettings::class,"joinRequests"])->name("settings.join-requests");
        Route::post("settings/{id}/join-requests/approve",[GroupSettings::class,"joinRequestsApprove"])->name("settings.join-requests.approve");
        Route::post("settings/{id}/join-requests/reject",[GroupSettings::class,"joinRequestsReject"])->name("settings.join-requests.reject");
        Route::get("settings/{id}/post-approval",[GroupSettings::class,"postApproval"])->name("settings.post-approval");
        Route::post("settings/{id}/post-approval/approve",[GroupSettings::class,"postApprovalApprove"])->name("settings.post-approval.approve");
        Route::post("settings/{id}/post-approval/reject",[GroupSettings::class,"postApprovalReject"])->name("settings.post-approval.reject");
        Route::get("join/{id}",[GroupMain::class,"join"])->name("join");
        Route::post("create-post/{id}",[GroupPost::class,"create"])->name("post.create");
        Route::post("{id}/post/make-announcement",[GroupPost::class,"announcement"])->name("post.announcement");
        Route::post("{id}/post/like",[GroupPost::class,"like"])->name("post.like");
        Route::post("{id}/post/delete",[GroupPost::class,"delete"])->name("post.delete");
        Route::post("{id}/post/comment",[GroupPost::class,"comment"])->name("post.comment");
    });
});
Route::name("webinars.")->prefix("webinars")->group(function(){
    Route::get("/",[WebinarMain::class,"index"])->name("index");
    Route::get("view/{id}/{title}",[WebinarMain::class,"view"])->name("view");
    Route::middleware(["auth","verified"])->name("subscribe.")->prefix("subscribe")->group(function(){
        Route::get("/{id}",[WebinarSubscribe::class,"subscribe"])->name("add");
        Route::get("/{id}/fill-form",[WebinarSubscribe::class,"fillForm"])->name("fill-form");
        Route::post("/{id}/fill-form",[WebinarSubscribe::class,"submitForm"])->name("fill-form");
    });
});
Route::name("mentorings.")->prefix("mentorings")->group(function(){
    Route::get("/",[MentoringMain::class,"index"])->name("index");
    Route::get("view/{id}/{title}",[MentoringMain::class,"view"])->name("view");
    Route::middleware(["auth","verified"])->name("subscribe.")->prefix("subscribe")->group(function(){
        Route::get("/{id}/slot",[MentoringSubscribe::class,"chooseSlot"])->name("slot");
        Route::post("/{id}",[MentoringSubscribe::class,"subscribe"])->name("add");
        Route::get("/{id}/fill-form",[MentoringSubscribe::class,"fillForm"])->name("fill-form");
        Route::post("/{id}/fill-form",[MentoringSubscribe::class,"submitForm"])->name("fill-form");
    });
});
Route::middleware(["auth","verified"])->name("posts.")->prefix("posts")->group(function(){
    Route::get("/{id}/{name}",[PostMain::class,"index"])->name("index");
    Route::get("view/{id}/{title}",[PostMain::class,"view"])->name("view");
    Route::get("create/{id}/{title}",[PostMain::class,"create"])->name("create");
    Route::post("create/{id}/{title}",[PostMain::class,"store"])->name("create");
    Route::post("delete",[PostMain::class,"delete"])->name("delete");
    Route::post("{id}/comment",[PostMain::class,"comment"])->name("comment");
});


// Route::post("/test",[TestController::class,"test"])->name("test");