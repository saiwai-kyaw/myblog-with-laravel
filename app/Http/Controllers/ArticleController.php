<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    public function __construct()
    {
       $this->middleware("auth")->except(['index','detail']); 
    }
    public function index(){
        $data = Article::latest()->paginate(5);
        return view("articles.index", ['articles' => $data]);
    }

    public function detail($id){
        $article = Article::find($id);
        return view("articles.detail", ["article" => $article]);
    }

    public function add(){
        $category = Category::All();
        return view("articles.add", ["categories" => $category]);
    }

    public function create(Request $request){

        $validator = validator($request->all(), [
            "title" => "required",
            "body" => "required",
            "category_id" => "required",
        ]);
        
        if($validator->fails()){
            return back() ->withErrors($validator);
        }

        $article = new Article;
        $article->title = $request->title;
        $article->body = $request->body;
        $article->category_id = $request->category_id;
        $article->user_id = Auth::id();

        $article->save();

        return redirect("/articles");
    }

    public function delete($id) {
        $article = Article::find($id);
        if(Gate::allows("delete-article", $article)) {
            $article -> delete();
            return redirect("/articles") -> with("info", "Deleted an article");
        }

        return back()->with("info", "!Unauthorize");
    }

    public function edit($id) {
        $article = Article::find($id);
        $category = Category::all();

        return view("articles.edit", ["article" => $article, "categories"=> $category]);
    }

    public function update(Request $request){

        $validator = validator($request->all(), [
            "title" => "required",
            "body" => "required",
            "category_id" => "required",
        ]);
        
        if($validator->fails()){
            return back() ->withErrors($validator);
        }

        Article::where('id', request()->id)->update([
            'title' => request()->title,
            'body' => request()->body,
            'category_id' => request()->category_id,
            'updated_at' => DB::raw('now()'),
        ]);

        return redirect("/articles");
    }   
}
