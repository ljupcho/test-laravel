<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Models\Post;
use App\Models\Group;
use App\Jobs\InsertUsers;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function createUserAtOnce()
    {
        $startTime = microtime(true);

        for ($i = 0; $i < 10000; $i++) {
            $age = $i + 1;
            $date = date('Y-m-d H:i:s');           

            \DB::table('users')->insertGetId([
                'first_name' => "First Name 01",
                'last_name' => "Last Name 01",
                'email' => sprintf('testmail%s@test.com', $age),
                'age' => $age,
                'created_at' => $date,    
                'updated_at' => $date,    
            ]);
        }   

        $endTime = microtime(true) - $startTime;

        return "time elapsed is: " . $endTime;
    }

    public function createUsers()
    {        
        $total = 20000;
        $chunk = 500;

        $perPage = ceil($total/$chunk);

        for ($i = 0; $i < $perPage; $i++) {
            InsertUsers::dispatch($i, $chunk);                 
        }

    	return 'ok';
    }

    public function getUsers()
    {
        $users = User::orderBy('users.id', 'desc')->with('group')->take(50)->get();        
        // will make whereIn query for post relationship
        $users->load('posts');

        $data = $users->map(function($user) {
            $group = $user->group;
            $posts = $user->posts->map(fn($post) => ['title' => $post->title, 'content' => $post->content]);
            return [
                'user_id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->first_name,
                'email' => $user->email,
                'age' => $user->age,
                'group' => [
                    'name' => $group->name,
                    'phone' => $group->phone,
                    'email' => $group->email,
                    'city' => $group->city,                    
                ],
                'posts' => $posts->toArray(),
            ];
        });

        \Log::error("total of returned users:". count($users)); 

        return response()->json($data);
    }

    public function getUsersWithJoin()
    {
        $users = User::query()
            ->join('groups', 'users.group_id', '=', 'groups.id')
            ->select('users.*', 
                'groups.name as group_name',
                'groups.phone as group_phone',
                'groups.email as group_email',
                'groups.city as group_city')
            ->orderBy('users.id', 'desc')
            ->take(50)
            ->get();

        $users->load('posts');

        $data = $users->map(function($user) {
            $posts = $user->posts->map(fn($post) => ['title' => $post->title, 'content' => $post->content]);
            return [
                'user_id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->first_name,
                'email' => $user->email,
                'age' => $user->age,
                'group' => [
                    'name' => $user->group_name,
                    'phone' => $user->group_phone,
                    'email' => $user->group_email,
                    'city' => $user->group_city,                    
                ],
                'posts' => $posts->toArray(),
            ];
        });

        \Log::error("total of returned users:". count($users)); 

        return response()->json($data);
    }


    public function createGroups()
    {
        for ($i = 0; $i < 300; $i++) {
            $date = date('Y-m-d H:i:s');       
            Group::insertGetId([
                'name' => "First Name 01",
                'phone' => '1232354',
                'email' => sprintf('testmail%s@test.com', ($i + 1)),
                'city' => 'Skopje',
                'created_at' => $date,    
                'updated_at' => $date,    
            ]);
        }  
    }
}
