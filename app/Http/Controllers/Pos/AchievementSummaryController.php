<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bengkel;

class AchievementSummaryController extends Controller
{
    public function index($id_bengkel)
    {
        $bengkel = Bengkel::find($id_bengkel);

        if (!$bengkel) {
            return redirect()->route('profile.workshop')->with('status_error', 'Workshop not found.');
        }

        $chartData = [
            'labels' => [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ],
            'data' => [
                '2023' => [10, 15, 25, 30, 40, 50, 60, 45, 55, 70, 80, 85],

                '2024' => [12, 18, 28, 35, 42, 55, 62, 48, 58, 75, 85, 90]
            ]
        ];

        return view('pos.reports.achievementsummary', compact('bengkel', 'chartData'));
    }
}
