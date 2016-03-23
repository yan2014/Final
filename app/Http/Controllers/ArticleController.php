<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Article;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
    public function articles_json() {
        $articles = Article::all();
        return response()->json($articles);
    }
    public function index(){
    	$query=Article::all();
    	return view('article.index',compact('query'));
    }
    public function create(){
    	return view('article.create');
    }
    public function store(ArticleRequest $request){
    	Article::create($request->all());
    	return redirect('article');
    }
    public function edit($id){
    	$query=Article::find($id);
    	return view('article.edit',compact('query'));
    }
    public function update(Request $request,$id){
    	//Article::where('id',$id)->update($request->all());
    	Article::where('id',$id)->update([
    			'title'=> $request->get('title'),
    			'content'=> $request->get('content')
    		]);
    	//Article::update($request->all())->where($id, $request->get('id'));
    	return redirect('article');
    }
    public function destroy($id){
    	Article::where('id',$id)->delete();
    	return redirect('article');
    }
}
