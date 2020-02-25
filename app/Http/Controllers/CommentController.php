<?php


namespace App\Http\Controllers;


class CommentController extends Controller
{
    public function new(CommentValidated $request)
    {
        $comment = new Comment($request->validated());
        \Auth::user()->comment()->save($comment);
        return redirect()->back();
    }
}
