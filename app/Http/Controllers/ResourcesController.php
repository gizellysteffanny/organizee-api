<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resource;

class ResourcesController extends Controller
{
    public function index(Request $request) {
        $user_id = $request->user()->id;
        $resources = Resource::where('user_id', '=', $user_id)->get();
        
        return $resources->toJson();
    }

    public function show(Request $request, $id) {
        $user_id = $request->user()->id;
        $resource = Resource::where('user_id', '=', $user_id)
            ->where('id', '=', $id)
            ->first();

        if (isset($resource)) {
            return response($resource->toJson(), 200);
        }

        return response('Not Found', 404);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'url' => 'required|string',
        ]);

        $resource = new Resource([
            'title' => $request->title,
            'url' => $request->url,
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);

        $resource->save();

        return response()->json([
            'data'=>'Resource successfully created'
        ], 201);
    }

    public function delete(Request $request, $id) {
        $user_id = $request->user()->id;
        $resource = Resource::where('user_id', '=', $user_id)->find($id);

        if (isset($resource)) {
            $resource->delete();
            return response('No Content', 204);
        }

        return response('Not Found', 404);
    }
}
