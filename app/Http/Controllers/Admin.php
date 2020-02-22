<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
USE DB;

class Admin extends Controller {

    //
    function dashboard() {
        $posts = DB::select(DB::raw("SELECT * FROM posts WHERE status = :status"), array(
                    'status' => 'A',
        ));
        $data['posts'] = $posts;
        return view('dashboard')->with($data);
    }

    function savePost() {
        $title = $_POST['title'];
        $mini_content = $_POST['mini_content'];
        $content = $_POST['content'];
        $tags = explode('####', $_POST['tags']);

        if (strlen(trim($content)) < 10) {
            echo json_encode(['status' => 0, 'msg' => 'content too less']);
            die;
        }
        // Start transaction
// Start transaction!
        DB::beginTransaction();
        $values = ['title' => $title, 'content' => trim($content), 'mini_content' => $mini_content, 'created_by' => session()->get('session_id'), 'readed_count' => 0, 'status' => 'A', 'created_at' => date('Y-m-d H:i:s')];

        $id = DB::table('Posts')->insertGetId($values);
        $tag_data = [];
        foreach ($tags as $tag) {
            $tag_data[] = ['title' => $tag, 'post_id' => $id, 'status' => 'A', 'created_at' => date('Y-m-d H:i:s')];
        }

        DB::table('tags')->insert($tag_data);
        DB::commit();
        echo json_encode(['status' => 1, 'msg' => 'post saved successfully']);
    }

}
