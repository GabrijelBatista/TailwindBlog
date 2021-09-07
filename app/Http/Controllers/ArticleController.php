<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleImage;
use App\Models\ArticleTag;
use App\Models\Image;
use App\Models\Subscriber;
use App\Models\Tag;
use App\Notifications\NewArticle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ArticleController extends Controller
{
    public function get_articles(){
        $articles=Article::paginate(15);
        foreach($articles as $article){
            $article->author=$article->user->name;
            $article->images=$article->images;
            $article->tags=$article->tags;
            $article->categories=$article->categories;
            $article->date=$article->created_at->format("d. M Y.");
        }

        return response()->json(['articles'=>$articles], 200);
    }

    public function display_articles($id, $sort){
        if($id!=1000) {
            if($sort=='Newest') {
                $articles = Category::find($id)->articles()->orderBy('created_at', 'desc')->paginate(15);
            }
            else if($sort=='Popular') {
                $articles = Category::find($id)->articles()->orderBy('views', 'desc')->paginate(15);
            }
            else if($sort=='Name') {
                $articles = Category::find($id)->articles()->orderBy('title', 'asc')->paginate(15);
            }
        }
        else{
            if($sort=='Newest') {
                $articles = Article::orderBy('created_at', 'desc')->paginate(15);
            }
            else if($sort=='Popular') {
                $articles = Article::orderBy('views', 'desc')->paginate(15);
            }
            else if($sort=='Name') {
                $articles = Article::orderBy('title', 'asc')->paginate(15);
            }
        }
        foreach($articles as $article){
            $article->author=$article->user->name;
            $article->images=$article->images;
            $article->tags=$article->tags;
            $article->categories=$article->categories;
            $article->date=$article->created_at->format("d. M Y.");
        }

        return response()->json(['articles'=>$articles], 200);
    }

    public function search_articles($data){
        $data=explode(" ", $data);
        $articles= new \stdClass();
        $articles->data=[];
        foreach($data as $d) {
            $tags = Tag::where('title', $d)->get()->all();
            foreach ($tags as $tag) {
                $articles_tags = $tag->articles()->get();
                foreach ($articles_tags as $x) {
                    $articles->data[] = $x;
                }
            }
            $categories = Category::where('name', $d)->get()->all();
            foreach ($categories as $category) {
                $articles_categories = $category->articles()->get();
                foreach ($articles_categories as $y) {
                    $articles->data[] = $y;
                }
            }
        }
        if(isset($articles->data[0])) {
            $tempArray = array_unique(array_column($articles->data, 'id'));
            $articles->data = array_values(array_intersect_key($articles->data, $tempArray));
            foreach ($articles->data as $article) {
                $article->author = $article->user->name;
                $article->images = $article->images;
                $article->tags = $article->tags;
                $article->categories = $article->categories;
                $article->date=$article->created_at->format("d. M 'y");
            }
        }

        return response()->json(['articles'=>$articles], 200);
    }

    public function select_article($title){
        $article=Article::where('title', $title)->first();
        if(!Auth::user()) {
            $article->views++;
        }
        $article->save();
        $article->author=$article->user->name;
        $article->images=$article->images;
        $article->tags=$article->tags;
        $article->categories=$article->categories;
        $article->date=$article->created_at->format("d. M Y.");

        return response()->json($article);
    }

    public function add_article(Request $request){
        $request->validate([
            'title' => 'required|unique:articles',
            'categories' => 'required',
            'html' => 'required',
            'images' => 'required',
            'tags' => 'required',
        ]);
        $user=Auth::user();
        Article::create(
            [
                'title' => $request->title,
                'user_id' => $user->id,
                'content' => $request->html,
                'description' => $request->description,
                'views' => 0
            ]
        );
        $article_id=Article::where('title', $request->title)->select('id')->first();
        foreach($request->file('images') as $image) {
            $filenameWithExt = $image->getClientOriginalName();
            $image = \Intervention\Image\Facades\Image::make($image->getRealPath());
            $image->save(public_path() . '/storage/images/' . $filenameWithExt);

            Image::firstOrCreate(
                [
                    'title' => $filenameWithExt
                ]
            );
            $image_id=Image::where('title', $filenameWithExt)->select('id')->first();
            ArticleImage::create(
                [
                    'article_id' => $article_id->id,
                    'image_id' => $image_id->id,
                ]
            );
        }
        foreach($request->tags as $tag) {
            Tag::firstOrCreate(
                [
                    'title' => $tag,
                ]
            );
            $tag_id=Tag::where('title', $tag)->select('id')->first();
            ArticleTag::create(
                [
                    'article_id' => $article_id->id,
                    'tag_id' => $tag_id->id,
                ]
            );
        }
        foreach($request->categories as $category) {
            $category_id=Category::where('name', $category)->select('id')->first();
            ArticleCategory::create(
                [
                    'article_id' => $article_id->id,
                    'category_id' => $category_id->id,
                ]
            );
        }

        $subscribers=Subscriber::where('verified', 1)->where('disabled', 0)->get();
        $email_data = [
            'title' => $request->title,
            'description' => $request->description,
        ];
        Notification::send($subscribers, new NewArticle($email_data));

        return response()->json(200);
    }

    public function delete_article(Request $request){
        $request->validate([
            'id' => 'required',
        ]);
        ArticleCategory::where('article_id', $request->id)->delete();
        ArticleImage::where('article_id', $request->id)->delete();
        ArticleTag::where('article_id', $request->id)->delete();
        Article::where('id', $request->id)->delete();

        return response()->json(200);
    }

    public function edit_article(Request  $request){
        $article=Article::find($request->id);
        $article->title = $request->title;
        $article->content = $request->html;
        $article->description =$request->description;

        $article->categories()->detach();
        $article->tags()->detach();
        $article->images()->detach();

        foreach($request->file('images') as $image) {
            $filenameWithExt = $image->getClientOriginalName();
            $image = \Intervention\Image\Facades\Image::make($image->getRealPath());
            $image->save(public_path() . '/storage/images/' . $filenameWithExt);

            Image::firstOrCreate(
                [
                    'title' => $filenameWithExt
                ]
            );
            $image_id=Image::where('title', $filenameWithExt)->select('id')->first();
            $article->images()->attach($image_id->id);
        }
        foreach($request->tags as $tag) {
            Tag::firstOrCreate(
                [
                    'title' => $tag,
                ]
            );
            $tag_id=Tag::where('title', $tag)->select('id')->first();
            $article->tags()->attach($tag_id->id);
        }
        foreach($request->categories as $category) {
            $category_id=Category::where('name', $category)->select('id')->first();
            $article->categories()->attach($category_id->id);
        }
        $article->save();

        $article=Article::where('id', $request->id)->first();
        $article->author=$article->user->name;
        $article->images=$article->images;
        $article->tags=$article->tags;
        $article->categories=$article->categories;
        $article->date=$article->created_at->format("d. M Y.");

        return response()->json($article);
    }
}
