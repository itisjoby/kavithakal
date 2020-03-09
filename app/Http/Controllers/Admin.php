<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use JasonGrimes\Paginator;

class Admin extends Controller
{

    //
    function dashboard($page_no = '1')
    {

        $totalItems_arr = DB::select(DB::raw("SELECT count(p.id) as total FROM posts p  WHERE p.status = :status "), array(
            'status' => 'A',
        ));
        $totalItems = $totalItems_arr[0]->total;
        $itemsPerPage = 5;
        $currentPage = $page_no;
        $urlPattern = '/admin/page/(:num)';
        $data['paginator'] = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        $show_records_from = ($currentPage - 1) * $itemsPerPage;

        $posts = DB::select(DB::raw("SELECT p.* FROM posts p  WHERE p.status = :status order by p.created_at desc limit " . $show_records_from . ", " . $itemsPerPage), array(
            'status' => 'A',
        ));
        $data['posts'] = $posts;



        return view('dashboard')->with($data);
    }

    function savePost()
    {
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

    function deletePost()
    {
        $postid = $_POST['postid'];

        DB::table('posts')->where(['id' => $postid])->update(['status' => 'D']);
        $_SESSION['site_messages'] = [
            'status' => 1,
            'msg' => 'Post deleted successfully'
        ];
        echo json_encode(['status' => 1, 'msg' => 'post deleted successfully']);
    }

    function everyDayPosts()
    {
        $daily_postcount = DB::select(DB::raw("SELECT COUNT(id) as count,CAST(created_at as DATE) as created_at FROM `posts` group by CAST(created_at as DATE)  order by created_at"), array());
        echo json_encode(['status' => 1, 'data' => $daily_postcount]);
        die;
    }

    function signout(Request $request)
    {
        $_SESSION['site_messages'] = [
            'status' => 1,
            'msg' => 'Logged out successfully'
        ];
        $request->session()->flush();
        return redirect('/');
    }
}
