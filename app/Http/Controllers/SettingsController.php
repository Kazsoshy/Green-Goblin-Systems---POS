<?php

namespace App\Http\Controllers;

use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Auth::user()->settings ?? new UserSetting([
            'font_size' => 'medium',
            'high_contrast' => false,
            'reduce_motion' => false,
            'theme_color' => 'default'
        ]);

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'font_size' => 'required|in:small,medium,large',
            'high_contrast' => 'boolean',
            'reduce_motion' => 'boolean',
            'theme_color' => 'required|in:default,purple,green,blue'
        ]);

        $settings = UserSetting::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'font_size' => $request->font_size,
                'high_contrast' => $request->boolean('high_contrast'),
                'reduce_motion' => $request->boolean('reduce_motion'),
                'theme_color' => $request->theme_color
            ]
        );

        return redirect()->back()->with('success', 'Settings updated successfully');
    }
} 