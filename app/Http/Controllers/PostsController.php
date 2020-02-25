<?php


namespace App\Http\Controllers;


class PostsController extends Controller
{
    // отображение всех постов
    public function all()
    {
        return view('welcome', [
            'posts' => Post::query()->paginate(4),
            'categories' => Category::all()
        ]);
    }

    // отображение постов по категориям
    public function category(Category $category)
    {
        return view('category', [
            'posts' => Post::query()->where('category_id', '=', $category->id)->get(),
            'category' => $category
        ]);
    }

    // управление постами
    public function control()
    {
        return view('control', [
            'posts' => Post::query()->where('user_id', '=', \Auth::id())->get()
        ]);
    }

    // отображение одного поста
    public function get(Post $post)
    {
        return view('post', [
            'comments' => Comment::where('articles_id', '=', $post->id)->get(),
            'categories' => $post->category->name,
            'username' => $post->user->name
        ]);
    }

    // создание нового поста
    public function new(PostValidated $request)
    {
        $post = new Post($request->validated());
        \Auth::user()->posts()->save($post);
        return redirect()->route('all');
    }

    // удаление поста
    public function delete(Post $post)
    {
        Post::destroy($post->id);
        return redirect()->route('all');
    }

}
