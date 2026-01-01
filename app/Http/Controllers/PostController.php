<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        if ($q = $request->input('q')) {
            $query->where(function($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")->orWhere('tags', 'like', "%{$q}%");
            });
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($date = $request->input('date')) {
            $query->whereDate('created_at', $date);
        }

        $posts = $query->orderBy('created_at', 'desc')->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function show(Post $post)
    {
        // ถ้า post ไม่ active ให้ return 404
        if (!$post->active) {
            abort(404);
        }
        
        return view('posts.show', compact('post'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|string',
            'type' => 'required|in:news,activity',
            'pinned' => 'nullable|in:pinned,unpinned',
        ]);

        $data['pinned'] = ($data['pinned'] ?? 'unpinned') === 'pinned';
        $data['active'] = true;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($data);

        return redirect('/posts')->with('success', 'บันทึกข่าว/กิจกรรมเรียบร้อย');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'tags' => 'nullable|string',
            'type' => 'required|in:news,activity',
            'pinned' => 'nullable|in:pinned,unpinned',
        ]);

        $data['pinned'] = ($data['pinned'] ?? 'unpinned') === 'pinned';

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect('/posts')->with('success', 'อัพเดตข่าว/กิจกรรมเรียบร้อย');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        return redirect('/posts')->with('success', 'ลบข่าว/กิจกรรมเรียบร้อย');
    }

    public function toggle(Request $request, Post $post)
    {
        $post->active = ! $post->active;
        $post->save();

        return response()->json(['active' => $post->active]);
    }

    public function publicIndex(Request $request)
    {
        $query = Post::where('active', true);

        if ($tag = $request->input('tag')) {
            $query->where('tags', 'like', "%{$tag}%");
        }

        if ($q = $request->input('q')) {
            $query->where(function($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")->orWhere('content', 'like', "%{$q}%");
            });
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('posts.public-index', compact('posts'));
    }

    public function tagsJson()
    {
        $tags = Post::where('active', true)
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatMap(function($tagsString) {
                return array_map('trim', explode(',', $tagsString));
            })
            ->unique()
            ->values()
            ->sort()
            ->toArray();

        return response()->json(['tags' => $tags]);
    }

    public function publicNews()
    {
        $schoolInfo = \App\Models\SchoolInfo::first();
        $posts = Post::where('type', 'news')
            ->where('active', true)
            ->orderBy('pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('posts.news', compact('posts', 'schoolInfo'));
    }

    public function publicActivities()
    {
        $schoolInfo = \App\Models\SchoolInfo::first();
        $posts = Post::where('type', 'activity')
            ->where('active', true)
            ->orderBy('pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('posts.activities', compact('posts', 'schoolInfo'));
    }

    public function publicSearch(Request $request)
    {
        $schoolInfo = \App\Models\SchoolInfo::first();
        $query = $request->input('q', '');
        $posts = [];
        
        if (!empty($query)) {
            $posts = Post::where('active', true)
                ->where(function($sub) use ($query) {
                    $sub->where('title', 'like', "%{$query}%")
                        ->orWhere('content', 'like', "%{$query}%")
                        ->orWhere('tags', 'like', "%{$query}%");
                })
                ->orderBy('pinned', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        }
        
        return view('posts.search', compact('posts', 'schoolInfo', 'query'));
    }
}
