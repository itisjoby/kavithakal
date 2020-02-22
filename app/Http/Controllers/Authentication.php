<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class Authentication extends Controller {

    //
    function login(Request $request) {
        $username = $_POST['username'];
        $password = $_POST['password'];


        //$hashed = password_hash(trim($new_pass), PASSWORD_DEFAULT);
        $results = DB::select(DB::raw("SELECT * FROM users WHERE email = :email"), array(
                    'email' => $username,
        ));
        if (!empty($results)) {

            //if (password_verify($password, $results[0]->password)) {
            if (1) {
                session(['session_id' => $results[0]->id]);
//dont use die or exit as ession wont be set
                echo json_encode(['status' => 1, 'msg' => '']);
            } else {
                echo json_encode(['status' => 0, 'msg' => 'Unknown Password']);
                die;
            }
        } else {
            echo json_encode(['status' => 0, 'msg' => 'Invalid mail address']);
            die;
        }
    }

}
