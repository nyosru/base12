<?php

/**
 * Ulogin.ru auto registration or login.
 */

namespace App\Http\Controllers;
// namespace App\Modules\Buh\Models;

// use App\User;
// use App\Models\User;
// use App\Modules\Buh\Models\User;
use App\Modules\Narod\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\DB;


class UloginController extends Controller
{

    // Login user through social network.
    public function logout(Request $request)
    {
        session( [ 'user' => [] ] );
        return redirect('/');
    }

    // Login user through social network.
    public function login(Request $request)
    {

        // Get information about user.
        $data = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
        $user = json_decode($data, TRUE);

        if (!empty($user['error'])) {
            // throw new \Exception($user['error'], 1);
            return redirect('/');
        }

        // $network = $user['network'] ?? '';
        // dd($user);

        $login_mail = ($user['nickname'] ?? 'x') . ($user['uid'] ?? 'y') . ($user['network'] ?? 'net') . '@php-cat.com';

        try {

            //code...
            $re = DB::table('users')->where('email', '=', $login_mail)->first();
            // dd( $re );

        }
        //
        catch (\Throwable $th) {

            //dd($th);
            //throw $th;
            $re = 'fail';
        }

        // dd($user, $re);

        // Find user in DB.
        // $userData = User::where('email', $login_mail)->first();



        // dd( [ $user , $userData , $userData->id , $userData->status ] );

        // Check exist user.
        // if (isset($userData->id)) {
        if (isset($re->id)) {

            // Check user status.
            // if ($userData->status) {

            session( [ 'user' => $re ] );

            // Make login user.
            // Auth::loginUsingId($userData->id, TRUE);
            // Войти и "запомнить" данного пользователя...
            // Auth::loginUsingId($re->id, TRUE);
            // Auth::loginUsingId($re->id);

            // }
            // // Wrong status.
            // else {
            //     \Session::flash('flash_message_error', trans('interface.AccountNotActive'));
            // }

            // return Redirect::back();

            // $user = Auth::user();

            // if (Auth::check()) {
            //     dd( 'Пользователь вошёл в систему...'  , $user);
            // } else {
            //     dd( 'Пользователь NO вошёл в систему...' , $user , $re );
            // }

            return redirect('/');


        }
        // Make registration new user.
        else {


            // if (empty($re) || $re == 'fail') {
            //     // Create new user in DB.
            //     $newUser = DB::table('users')->insert([
            //         'nik' => $user['nickname'],
            //         'name' => $user['first_name'] . ' ' . $user['last_name'],
            //         'avatar' => $user['photo'],
            //         'country' => $user['country'] ?? '',
            //         'email' => $login_mail,
            //         // 'password' => Hash::make(str_random(8)),
            //         'password' => Hash::make(rand(0, 999999)),
            //         'role' => 'new',
            //         // 'status' => TRUE,
            //         // 'ip' => $request->ip()
            //     ]);
            //     $re = DB::table('users')->where('email', '=', $login_mail)->first();
            // }
    

            // Create new user in DB.
            $newUser = User::create([
                'nik' => $user['nickname'],
                'name' => $user['first_name'] . ' ' . $user['last_name'],
                'avatar' => $user['photo'],
                'country' => $user['country'],
                'email' => $login_mail,
                // 'password' => Hash::make(str_random(8)),
                'password' => Hash::make(rand(0, 999999)),
                'role' => 'user',
                'status' => TRUE,
                'ip' => $request->ip()
            ]);

            // Make login user.
            Auth::loginUsingId($newUser->id, TRUE);

            \Session::flash('flash_message', trans('interface.ActivatedSuccess'));

            // return Redirect::back();
            return redirect('/');
        }
    }
}
