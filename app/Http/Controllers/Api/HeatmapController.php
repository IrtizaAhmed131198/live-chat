<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeatmapEvent;

class HeatmapController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required',
            'session_id' => 'required',
            'url' => 'required',
            'type' => 'required'
        ]);

        HeatmapEvent::create([
            'brand_id' => $request->brand_id,
            'session_id' => $request->session_id,
            'url' => $request->url,
            'type' => $request->type,
            'x' => $request->x,
            'y' => $request->y,
            'scroll_percent' => $request->scroll_percent,
        ]);

        return response()->json(['success'=>true]);
    }

    public function getAdminHeatmap(Request $request)
    {
        $request->validate([
            'brand_id' => 'required',
            'url' => 'required'
        ]);

        $events = HeatmapEvent::where('brand_id', $request->brand_id)
            ->where('url', $request->url)
            ->get(['x','y','scroll_percent','type']);

        return response()->json([
            'events' => $events
        ]);
    }
}
