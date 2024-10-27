<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Site::orderBy('name')->paginate(10);

        return response()->json($sites, 200);
    }

    public function show($site_id)
    {
        $site = Site::find($site_id);
        if (! $site) {
            return response()->json(['message' => 'Site not found'], 404);
        }

        return response()->json($site, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'description' => 'required|string|max:255',
            'email' => 'required|email',
            'email_outage' => 'required|email',
            'email_resolved' => 'required|email',
            'url' => 'required|url',
        ]);

        $site = new Site();
        $site->name = $request->name;
        $site->description = $request->description;
        $site->email = $request->email;
        $site->email_outage = $request->email_outage;
        $site->email_resolved = $request->email_resolved;
        $site->url = $request->url;
        $site->save();

        return response()->json($site, 201);
    }

    public function update(Request $request, $site_id)
    {
        $request->validate([
            'name' => 'string|min:3',
            'description' => 'string|max:255',
            'email' => 'email',
            'email_outage' => 'email',
            'email_resolved' => 'email',
            'url' => 'url',
        ]);

        $site = Site::find($site_id);
        if (! $site) {
            return response()->json(['message' => 'Site not found'], 404);
        }

        if ($request->name) {
            $site->name = $request->name;
        }

        if ($request->description) {
            $site->description = $request->description;
        }

        if ($request->email) {
            $site->email = $request->email;
        }

        if ($request->email_outage) {
            $site->email_outage = $request->email_outage;
        }

        if ($request->email_resolved) {
            $site->email_resolved = $request->email_resolved;
        }

        if ($request->url) {
            $site->url = $request->url;
        }

        $site->save();

        return response()->json($site, 200);
    }

    public function destroy(Request $request, $site_id)
    {
        $site = Site::find($site_id);
        if (! $site) {
            return response()->json(['message' => 'Site not found'], 404);
        }

        $site->delete();

        return response()->json(null, 204);
    }
}
