<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BugController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'site_id' => 'required|exists:sites,id',
            'message' => 'required|string',
            'url' => 'required|string',
            'code' => 'required',
            'file' => 'required|string',
            'line' => 'required',
            'method' => 'required|string',
            'path' => 'required|string',
        ]);

        $bug = new Bug();
        $bug->site_id = $request->site_id;
        $bug->env = $request->env;
        $bug->url = Str::limit($request->url, 250);
        $bug->user = $request->user;
        $bug->ip = $request->ip;
        $bug->user_agent = Str::limit($request->user_agent, 250);
        $bug->method = $request->method;
        $bug->path = Str::limit($request->path, 250);
        $bug->code = $request->code;
        $bug->file = Str::limit($request->file, 250);
        $bug->line = $request->line;
        $bug->message = Str::limit($request->message, 250);
        $bug->logged_at = now();
        $bug->save();

        return response()->json($bug, 201);
    }
}
