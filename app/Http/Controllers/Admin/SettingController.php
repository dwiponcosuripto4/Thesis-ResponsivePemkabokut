<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function toggleUmkmRegistration(Request $request)
    {
        try {
            $hideRegistration = $request->boolean('hide_registration');

            Cache::put('umkm_hide_registration', $hideRegistration, now()->addYears(1));

            return response()->json([
                'success' => true,
                'message' => $hideRegistration ? 'UMKM Registration hidden' : 'UMKM Registration shown'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating setting'
            ], 500);
        }
    }

    public function toggleUmkmMenu(Request $request)
    {
        try {
            $hideMenu = $request->boolean('hide_menu');

            Cache::put('umkm_hide_menu', $hideMenu, now()->addYears(1));

            return response()->json([
                'success' => true,
                'message' => $hideMenu ? 'UMKM Menu hidden' : 'UMKM Menu shown'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating setting'
            ], 500);
        }
    }

    public function getUmkmSettings()
    {
        try {
            $hideRegistration = Cache::get('umkm_hide_registration', false);
            $hideMenu = Cache::get('umkm_hide_menu', false);

            return response()->json([
                'success' => true,
                'data' => [
                    'hide_registration' => $hideRegistration,
                    'hide_menu' => $hideMenu
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading settings'
            ], 500);
        }
    }
}
