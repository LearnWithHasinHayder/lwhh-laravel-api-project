<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller {
    function getAllArticles() {
        return Article::all();
    }

    function getArticle( Article $article ) {
        // return Article::findOrFail($id);
        return $article;
    }

    function createArticle( Request $request ) {
        $title = $request->title;
        $content = $request->content;
        $user = $request->user();

        $article = new Article();
        $article->title = $title;
        $article->content = $content;
        $article->user_id = $user->id;
        $article->save();
        return $article;
    }

    function updateArticle( Request $request, Article $article ) {
        $user = $request->user();
        if ( $user->id != $article->user_id ) {
            return response()->json( array("error" => "You don't have permission to edit this article"), 404 );
        } else {
            $title = $request->title;
            $content = $request->content;
            $article->title = $title;
            $article->content = $content;
            $article->save();
            return $article;
        }
    }

    function deleteArticle( Request $request, Article $article ) {
        $user = $request->user();
        if ( $user->id != $article->user_id ) {
            return response()->json( array("error" => "You don't have permission to edit this article"), 404 );
        } else {
            $article->delete();
            return response()->json( array("success" => "Article Delettion Complete"), 200 );
        }
    }
}
