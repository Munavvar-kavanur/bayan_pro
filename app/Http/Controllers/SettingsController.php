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
        // 1. Handle Generic Inputs
        $data = $request->except(['_token', '_method', 'tab', 'branding_logo', 'invoice_logo', 'quotation_logo']);
        $group = $request->input('tab', 'general');

        foreach ($data as $key => $value) {
            Setting::set($key, $value, $group);
        }

        // 2. Handle Logo Uploads
        $logos = ['branding_logo', 'invoice_logo', 'quotation_logo'];

        foreach ($logos as $logoField) {
            if ($request->hasFile($logoField)) {
                $request->validate([
                    $logoField => 'image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB
                ]);

                $path = $request->file($logoField)->store('uploads/branding', 'public');
                Setting::set($logoField, $path, 'branding');
            }
        }

        return redirect()->route('settings.index', ['tab' => $group])
            ->with('success', 'Settings updated successfully.');
    }
}
