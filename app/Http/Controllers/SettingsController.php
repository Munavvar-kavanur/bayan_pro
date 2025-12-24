<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'general');
        
        // Fetch all settings
        // In a larger app, you might only fetch specific groups
        $settings = Setting::all()->pluck('value', 'key');

        return view('settings.index', compact('tab', 'settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method', 'tab']);
        $group = $request->input('tab', 'general');

        foreach ($data as $key => $value) {
            Setting::set($key, $value, $group);
        }

        return redirect()->route('settings.index', ['tab' => $group])
            ->with('success', 'Settings updated successfully.');
    }
}
