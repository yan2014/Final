<?php

use Illuminate\Database\Seeder;
use Illuminate\database\Eloquent\Model;
use App\Article;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserTableSeeder::class);
        DB::table('articles')->truncate();
        for($i=0;$i<10;$i++){
        	Article::create([
        		'title'=>str_random(10),
        		'content'=>str_random(255)
        	]);
        }
    }
}
