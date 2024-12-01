<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\WebScrapingController;
use App\Http\Livewire\Admin\AdminDashboardComponent;
use App\Http\Livewire\Admin\AdminEventComponent;
use App\Http\Livewire\Admin\AdminCategoryComponent;
use App\Http\Livewire\Admin\AdminServiceComponent;
use App\Http\Livewire\Admin\AdminAddEventComponent;
use App\Http\Livewire\Admin\AdminAddCategoryComponent;
use App\Http\Livewire\Admin\AdminEditCategoryComponent;
use App\Http\Livewire\Admin\AdminAddServiceComponent;
use App\Http\Livewire\Admin\AdminEditEventComponent;
use App\Http\Livewire\Admin\AdminEditServiceComponent;
use App\Http\Livewire\User\UserDashboardComponent;
use App\Http\Livewire\User\UserProfileComponent;
use App\Http\Livewire\User\UserEditProfileComponent;
use App\Http\Livewire\User\UserChangePasswordComponent;
use App\Http\Livewire\User\UserManageSupscriptionComponent;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\SubscriptionComponent;
use App\Http\Livewire\CheckoutStatusComponent;
use App\Http\Livewire\CategoryComponent;
use App\Http\Livewire\ServiceDetailsComponent;
use App\Http\Livewire\ContactComponent;
use App\Http\Livewire\EventCityComponent;
use App\Http\Livewire\AllEventsComponent;
use App\Http\Livewire\Admin\AdminSettingComponent;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LocaleController;
use App\Actions\Fortify\CreateNewUser;



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


Route::get('/scrape',[HomeController::class,'scrape'])->name('scrape');
Route::get('/',[HomeController::class,'index'])->name('index');



// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

Route::middleware(['setapplang'])->prefix('{locale}')->group(function () {
// Route::get('/login', [CreateNewUser::class, 'showLoginForm'])->name('login_form');

Route::get('/',HomeComponent::class)->name('home');
Route::get('event-category/{category_id}/{scategory_slug?}',CategoryComponent::class)->name('event.category');
Route::get('/events/{city_id}',EventCityComponent::class)->name('events.city');
Route::get('/all-events', AllEventsComponent::class)->name('all_events');
Route::get('/subscribe', SubscriptionComponent::class)->name('subscribe');
Route::get('/payment/status', CheckoutStatusComponent::class)->name('payment.status');
Route::get('/register', [CreateNewUser::class, 'showRegistrationForm'])->name('register-form');
Route::get('/contact-us', ContactComponent::class)->name('contact');



});
Route::get('/service_details/{service_id}',ServiceDetailsComponent::class)->name('service_details');

Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google-auth');
Route::get('auth/google/call-back', [GoogleAuthController::class, 'handleGoogleCallback']);






Route::middleware(['auth:sanctum','verified','setapplang','authAdmin'])->prefix('{locale}')->group(function () {
    Route::get('/admin/dashboard',AdminDashboardComponent::class)->name('admin.dashboard');
    Route::get('/admin/events',AdminEventComponent::class)->name('admin.events');
    Route::get('/admin/categories',AdminCategoryComponent::class)->name('admin.categories');
    Route::get('/admin/services',AdminServiceComponent::class)->name('admin.services');
    Route::get('/dashboard',AdminDashboardComponent::class)->name('dashboard');
    Route::get('/admin/event/add',AdminAddEventComponent::class)->name('admin.addEvent');
    Route::get('/admin/category/add',AdminAddCategoryComponent::class)->name('admin.addCategory');
    Route::get('/admin/service/add',AdminAddServiceComponent::class)->name('admin.addService');
    Route::get('/admin/event/edit/{event_id}',AdminEditEventComponent::class)->name('admin.editEvent');
    Route::get('/admin/service/edit/{service_id}',AdminEditServiceComponent::class)->name('admin.editService');
    Route::get('/admin/category/edit/{category_id}/{scategory_id?}',AdminEditCategoryComponent::class)->name('admin.editCategory');
    Route::get('/admin/setting', AdminSettingComponent::class)->name('admin.settings');



});

// Route::middleware(['auth:sanctum','verified','setapplang'])->prefix('{locale}')->group(function () {
Route::middleware(['auth:sanctum','verified','setapplang'])->prefix('{locale}')->group(function () {
    Route::get('/user/dashboard',UserDashboardComponent::class)->name('user.dashboard');
    Route::get('/user/profile',UserProfileComponent::class)->name('user.profile');
    Route::get('/user/profile/edit',UserEditProfileComponent::class)->name('user.editProfile');
    Route::get('/user/change-password',UserChangePasswordComponent::class)->name('user.changePassword');
    Route::get('/user/manage-supscription',UserManageSupscriptionComponent::class)->name('user.manageSupscription');



});








