<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

//require '../vendor/autoload.php';

use JasonGrimes\Paginator;

class Home extends Controller
{

    //
    function index($page_no = '1')
    {

        $totalItems_arr = DB::select(DB::raw("SELECT count(p.id) as total FROM posts p  join users u on u.id=p.created_by WHERE p.status = :status order by p.created_at desc "), array(
            'status' => 'A',
        ));
        $totalItems = $totalItems_arr[0]->total;
        $itemsPerPage = 5;
        $currentPage = $page_no;
        $urlPattern = '/home/page/(:num)';
        $data['paginator'] = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        $show_records_from = ($currentPage - 1) * $itemsPerPage;

        $posts = DB::select(DB::raw("SELECT p.*, u.name as creator FROM posts p join users u on u.id = p.created_by WHERE p.status = :status order by p.created_at desc limit " . $show_records_from . ", " . $itemsPerPage), array(
            'status' => 'A',
        ));
        $data['posts'] = $posts;
        $data['top_posts'] = $this->mostPopular();
        $data['new_posts'] = $this->mostLatest();
        //d($data);
        return view('index')->with($data);
    }

    function read_content($id)
    {


        $posts = DB::select(DB::raw("SELECT u.name as author, p.*, GROUP_CONCAT(t.title )as tag
FROM `posts` p
left join tags t on t.post_id = p.id and t.status = 'A'
left join users u on p.created_by = u.id
where p.status = 'A' and p.id = :id
group by p.id
order by p.readed_count desc limit 1"), array(
            'id' => $id,
        ));

        $data['article'] = $posts;
        $posts = DB::select(DB::raw("SELECT * FROM posts WHERE status = :status"), array(
            'status' => 'A',
        ));
        $data['other_posts'] = $posts;



        DB::table('posts')->where(['id' => $id])->update(['readed_count' => ($data['article'][0]->readed_count + 1)]);

        return view('read_more')->with($data);
    }

    function mostLatest()
    {
        $posts = DB::select(DB::raw("SELECT u.name as author, p.*, GROUP_CONCAT(t.title )as tag
FROM `posts` p
left join tags t on t.post_id = p.id and t.status = 'A'
left join users u on p.created_by = u.id
where p.status = 'A'
group by p.id
order by p.created_at desc limit 2"), array());
        return $posts;
    }

    function mostPopular()
    {
        $posts = DB::select(DB::raw("SELECT u.name as author, p.*, GROUP_CONCAT(t.title )as tag
FROM `posts` p
left join tags t on t.post_id = p.id and t.status = 'A'
left join users u on p.created_by = u.id
where p.status = 'A'
group by p.id
order by p.readed_count desc limit 1"), array());
        return $posts;
    }

    function search_content(Request $request)
    {

        $query = htmlentities($_GET['query']);
        $posts = DB::select(DB::raw("SELECT u.name as author, p.*, GROUP_CONCAT(t.title )as tag
FROM `posts` p
left join tags t on t.post_id = p.id and t.status = 'A'
left join users u on p.created_by = u.id
where p.status = 'A' and (p.title like '%" . $query . "%' or t.title like '%" . $query . "%')
group by p.id
order by p.readed_count desc"), array());

        $data['results'] = $posts;
        session(['search' => $query]);

        return view('search')->with($data);
    }

    function getRandomWord($len = 10)
    {
        $word = array_merge(range('a', 'z'), range('A', 'Z'));
        shuffle($word);
        return substr(implode($word), 0, $len);
    }

    function savePost()
    {

        for ($i = 0; $i < 1000; $i++) {
            $title = $this->getRandomWord(10);
            $mini_content = $this->getRandomWord(250);
            $content = $this->getRandomWord(1000);
            $created_at = date('Y-m-d', rand(1577860048, 1582957648));
            $values = ['title' => $title, 'content' => trim($content), 'mini_content' => $mini_content, 'created_by' => session()->get('session_id'), 'readed_count' => 0, 'status' => 'A', 'created_at' => $created_at];
            $id = DB::table('Posts')->insertGetId($values);
        }
        d($i . "done");
    }
}
