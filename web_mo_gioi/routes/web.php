<?php

use App\Enums\PostStatusEnum;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Models\Company;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
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
Route::get('/login', [AuthController::class,'login']);
Route::get('/register', [AuthController::class,'register'])->name('register');
Route::post('/register', [AuthController::class,'registering'])->name('registering');
Route::get('/', function () {
    return view('layout.master');
})->name('welcome');
Route::get('/auth/redirect/{provider}', function ($provider) {
    return Socialite::driver($provider)->redirect();
})->name('auth.redirect');
Route::get('/auth/callback/{provider}', [AuthController::class,'callback'])->name('auth.callback');

Route::get('/test',function (){
        $companyName = 'Da cap';
        $language = 'PHP';
        $city = 'HN';
        $link = 'abc';

        $company = Company::query()->firstOrCreate([
            'name'=>$companyName,
        ],[
            'city' => $city,
            'country' => 'VietNam',
        ]);

        $post = Post::create([
            'job_title' =>$language,
            'company_id' => $company->id,
            'city' =>$city,
            'status'=>PostStatusEnum::ADMIN_APPROVED,
        ]);
        $languages = explode(',',$language);
        foreach ($languages as $language){
            \App\Models\Language::firstOrCreate([
                'name'=>trim($language),
            ]);
        }
        \App\Models\File::create([
            'post_id' => $post->id,
            'link' => $link,
            'type' => \App\Enums\FileTypeEnum::JD,
        ]);
});
