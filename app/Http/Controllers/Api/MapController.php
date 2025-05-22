<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MapController extends Controller
{
    public function ping()
    {
        return response()->json(['message' => 'pong from Laravel']);
    }

    public function search(Request $request)
    {
        $location = $request->input('location', 'Bang sue');
        $query = "restaurant in $location";

//          สร้าง key สำหรับ cache
            $cacheKey = 'google_search_' . md5($query);

//          ลองดึงจาก cache ก่อน
            $data = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($query) {
                $response = Http::get(env('GOOGLE_SERVICE'), [
                    'query' => $query,
                    'key' => env('GOOGLE_MAPS_API_KEY'),
                ]);

                return $response->json();
            });

            return response()->json($data['results'] ?? []);
    }
}
