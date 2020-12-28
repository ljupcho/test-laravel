<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class InsertUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;

    protected int $offset;
    protected int $chunk;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $i, int $chunk)
    {
        $this->offset = $i;
        $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $startTime = microtime(true);
        \Log::error("started time:". $startTime);
        $t = $this->offset * $this->chunk;

        for ($i = 0; $i < $this->chunk; $i++) {
            $date = date('Y-m-d H:i:s'); 
            $user = User::create([
                'first_name' => "First Name 01",
                'last_name' => "Last Name 01",
                'email' => sprintf('testmail%s@test.com', ($t + $i)),
                'age' => $i + 1,
                'group_id' => 200,
                'created_at' => $date,    
                'updated_at' => $date, 
            ]);

            $user->posts()->createMany([
                ['title' => 'test title', 'content'=> 'lorem ipsum test content'],
                ['title' => 'test title', 'content'=> 'lorem ipsum test content'],
            ]);

            // \DB::table('users')->insertGetId([
            //     'first_name' => "First Name 01",
            //     'last_name' => "Last Name 01",
            //     'email' => sprintf('testmail%s@test.com', ($t + $i)),
            //     'age' => $i + 1,
            //     'created_at' => $date,    
            //     'updated_at' => $date,    
            // ]);
        }       

        $endTime = microtime(true) - $startTime;

        \Log::error("time elapsed is: " . $endTime);
    }
}
