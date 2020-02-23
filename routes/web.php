<?php

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
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use \App\Mentor;
use \App\Discount;
/**
 * Main Website ROUTE
 */
Route::get('/', 'LandingPageController@index')->name('landingpage');
Route::post('/search-mentor', 'LandingPageController@searchMentor')->name('search.mentor');
Route::get('/profile', 'UserController@profile')->name('my-profile');
Route::get('/about-us', 'AboutController@index')->name('about-us');
Route::get('/faq', 'AboutController@faqIndex')->name('about-us');
Route::get('/dummy/mentor', 'DummyController@index')->name('dummymentor');
Route::get('/dummy/mentor/show', 'DummyController@view')->name('dummymentorshow');
Route::get('/notification', 'UserController@indexAllNotification')->name('indexAllNotification');
Route::get('/search', 'LessonController@search')->name('search');
Route::get('/cart', 'CartController@index')->name('indexAllPurchases');
Route::get('/faq', 'FaqController@index')->name('faq');
Route::resource('news','NewsController')->only(['index', 'show']);
Route::resource('mentors','MentorController')->only(['index', 'show']);
Route::group(['middleware' => 'auth'], function () {
    Route::resource('carts', 'CartController');
    Route::get('/v1/cart/clear-all', 'CartController@clearAll')->name('cart.clearall');
    Route::resource('wishlists', 'WishlistController');
    Route::get('/wishlists/{id}/remove', 'WishlistController@remove')->name('wishlists.remove');
    Route::post('/cart/checkout', 'CartController@checkout')->name('cart.checkout');
});

Route::group(['as' => 'main.', 'middleware' => ['auth']], function(){
//    Route::get('/redirect', 'SocialAuthGoogleController@redirect')->name('redirect');
//    Route::get('/home', 'HomeController@index')->name('home');
//    Route::get('/mentors/{mid}/lessons/{lid}', 'LessonController@show')->middleware(['can_watch_lesson']);

//    Route::resource('mentors.lessons','MentorLessonController')->middleware(['can_watch_lesson'])->only(['show']);
//    Route::resource('comments','CommentController');
    Route::post('/mentor/{username}/send-rating', 'CommentController@sendRating')->name('mentor.send-rating');
    Route::post('/lesson/enroll/{username}','LessonController@enroll')->name('comment.enroll');
    Route::get('/profile/{username}', 'Usercontroller@show')->name('user.profile');
    Route::group(['middleware' => ['auth','can_watch_lesson']], function() {
//        Route::get('/mentors/{mid}/lessons/{lid}', 'LessonController@show');
        Route::resource('mentors.lessons','MentorLessonController')->only(['show'])->middleware('verified');
        Route::get('/mentors/{mid}/lessons/{lid}/fetch-comment', 'MentorLessonController@fetchComment')->name('mentors.lessons.fetch-comment');
        Route::post('/mentors/{mid}/lessons/{lid}/send-comment', 'MentorLessonController@sendComment')->name('mentors.lessons.send-comment');
        Route::post('/mentors/{mid}/lessons/{lid}/edit-comment', 'MentorLessonController@editComment')->name('mentors.lessons.edit-comment');
        Route::post('/mentors/{mid}/lessons/{lid}/delete-comment', 'MentorLessonController@deleteComment')->name('mentors.lessons.delete-comment');
    });
});

/**
 * ADMIN ROUTE
*/
Route::group(['prefix' => 'adm', 'middleware' => ['auth','role:admin|mentor|staff']], function(){
    Route::get('/', function() { return redirect()->route('dashboard'); } );
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/setting', 'SettingController@index')->name('setting.index');
    Route::get('/setting/landingpage', 'SettingController@landingpage')->name('setting.landingpage');
    Route::put('/setting/landingpage', 'SettingController@updateLandingpage')->name('setting.landingpage.update');
    Route::resource('mentors.lessons','MentorLessonController');
    Route::group(['middleware' => ['role:admin']],function (){
        Route::resource('users','UserController');
        Route::resource('news','NewsController');
        Route::resource('faq', 'FaqController');
        Route::resource('support', 'SupportDeskController');
        Route::resource('discounts','DiscountController');
        Route::get('/discounts/{did}/assign', 'DiscountController@viewAssign')->name('discounts.view-assign');
        Route::post('/discounts/{did}/assign', 'DiscountController@doAssign')->name('discounts.do-assign');

    });
    Route::group(['middleware' => ['role:admin|staff']],function (){
        Route::resource('mentors','MentorController');
        Route::resource('lessons','LessonController');
    });
    Route::group(['middleware' => ['role:admin|mentor']],function (){
        Route::resource('mentors','MentorController')->only(['show', 'edit','update']);
    });
});

/**
 * AUTHENICATION ROUTE
 */
Auth::routes(['verify' => true]);
Route::get('/redirect', 'SocialAuthGoogleController@redirect')->name('redirect');
Route::get('/callback', 'SocialAuthGoogleController@callback')->name('callback');










/*
 * Route Dibawah hanya Untuk kebutuhan Dev Saja
 * Nanti Akan Dihapus.
 * "Ikhsn"
 */

Route::get('/create-new-roles', function() {
    DB::transaction(function () {
        $permission = Permission::create(['name' => 'read comments']);

        $role = Role::create(['name' => 'student']);
        $role->givePermissionTo($permission);
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'staff']);
        Role::create(['name' => 'mentors']);
    });
});

Route::get('/give-permission-to', function() {
    $role = Role::where('name','super-admin')->first();
    $permission = Permission::all();
    DB::transaction(function () use ($role, $permission){
        $role->givePermissionTo($permission);
    });
});

Route::get('/generate-user',function (){
    DB::beginTransaction();
    try {
        // $permission = Permission::create(['name' => 'read comments']);

        $roleSuperadmin = Role::create(['name' => 'super-admin']);
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleStaff = Role::create(['name' => 'staff']);
        $roleMentor = Role::create(['name' => 'mentor']);
        $roleStudent = Role::create(['name' => 'student']);
        // $roleStudent->givePermissionTo($permission);

        $superadmin = new User([
            'name' => 'super admin',
            'username' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $superadmin->save();
        $superadmin->assignRole($roleSuperadmin);

        $admin = new User([
            'name' => 'first admin',
            'username' => 'firstadmin',
            'email' => 'firstadmin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $admin->save();
        $admin->assignRole($roleAdmin);
        $staff = new User([
            'name' => 'first staff',
            'username' => 'firststaff',
            'email' => 'firststaff@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $staff->save();
        $staff->assignRole($roleStaff);

        $student = new User([
            'name' => 'first student',
            'username' => 'firststudent',
            'email' => 'firststudent@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $student->save();
        $student->assignRole($roleStudent);

        $mentor = new User([
            'name' => 'Bobbi Brown',
            'username' => 'firstmentor',
            'email' => 'firstmentor@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $mentor->save();
        $mentorDetail = new Mentor([
            'mentor_id' => $mentor->id,
            'profesi' => 'designer',
            'desc' => 'Bobbi Brown’s philosophy is that makeup should be quick and natural, and it should enhance who you are. 
            A beauty industry icon, Bobbi shares her expertise in step-by-step tutorials, using models with a range of skin tones. 
            You’ll learn how to choose the right foundation, do a smoky eye and a statement lip, and take your look from day to night. 
            But most of all, you’ll learn how to feel confident in your own skin.',
            'price' => 120000,
            'visit_count' => 0,
        ]);
        $mentorDetail->save();
        $mentor->assignRole($roleMentor);
        DB::commit();
    }
    catch (Exception $e){
        echo $e->getMessage();
        DB::rollBack();
    }
});

Route::get('/sb', function (){
    $mentor = Mentor::all();
    $discount = Discount::first();
    $discount->mentors()->attach($mentor);
})->name('callback');