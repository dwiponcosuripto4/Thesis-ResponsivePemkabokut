<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Business;
use App\Models\Document;
use App\Models\Category;
use App\Models\Headline;
use App\Models\Data;
use App\Models\File;
use App\Models\Icon;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $statistics = [
            'categories' => Category::count(),
            'headlines' => Headline::count(),
            'posts' => Post::count(),
            'data' => Data::count(),
            'documents' => Document::count(),
            'files' => File::count(),
            'businesses' => Business::count(),
            'icons' => Icon::count(),
        ];

        $userStats = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => [400, 300, 400, 500, 400, 300, 400, 500, 600, 700, 800, 900],
                ],
                [
                    'label' => 'Sessions',
                    'data' => [200, 250, 200, 300, 250, 200, 250, 300, 350, 400, 450, 500],
                ],
                [
                    'label' => 'Bounce Rate',
                    'data' => [150, 180, 150, 200, 180, 150, 180, 200, 220, 250, 280, 300],
                ]
            ]
        ];

        $dailySales = [
            'labels' => ['Mar 25', 'Mar 26', 'Mar 27', 'Mar 28', 'Mar 29', 'Mar 30', 'Mar 31', 'Apr 01', 'Apr 02'],
            'data' => [3000, 3200, 3100, 3400, 3300, 3500, 3800, 4200, 4578],
            'total' => 4578.58
        ];

        $recentBusinesses = Business::with('user')
            ->latest()
            ->take(6)
            ->get();

        $calendarEvents = $this->getCalendarEventsData();

        return view('admin.dashboard', compact('statistics', 'userStats', 'dailySales', 'recentBusinesses', 'calendarEvents'));
    }

    /**
     * Get dashboard statistics for AJAX requests.
     */
    public function getStatistics()
    {
        $statistics = [
            'categories' => Category::count(),
            'headlines' => Headline::count(),
            'posts' => Post::count(),
            'data' => Data::count(),
            'documents' => Document::count(),
            'files' => File::count(),
            'businesses' => Business::count(),
            'icons' => Icon::count(),
        ];

        return response()->json($statistics);
    }

    /**
     * Get user statistics data for charts.
     */
    public function getUserStats()
    {
        $userStats = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [
                [
                    'label' => 'New Users',
                    'data' => User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                        ->whereYear('created_at', date('Y'))
                        ->groupBy('month')
                        ->pluck('count', 'month')
                        ->values()
                        ->toArray()
                ]
            ]
        ];

        return response()->json($userStats);
    }

    /**
     * Get calendar events data.
     */
    private function getCalendarEventsData()
    {
        $events = [];

        // Posts
        foreach (Post::all() as $post) {
            $events[] = [
                'title' => 'Create Post: ' . ($post->title ?? 'No Title'),
                'start' => $post->created_at->format('Y-m-d'),
                'backgroundColor' => '#007bff',
                'borderColor' => '#007bff',
                'description' => 'Post dibuat oleh ' . ($post->user->name ?? '-')
            ];
        }

        // Documents
        foreach (Document::all() as $document) {
            $events[] = [
                'title' => 'Create Document: ' . ($document->title ?? 'No Title'),
                'start' => $document->created_at->format('Y-m-d'),
                'backgroundColor' => '#28a745',
                'borderColor' => '#28a745',
                'description' => 'Document dibuat oleh ' . ($document->user->name ?? '-')
            ];
        }

        // Icons
        foreach (Icon::all() as $icon) {
            $events[] = [
                'title' => 'Create Icon: ' . ($icon->title ?? 'No Title'),
                'start' => $icon->created_at->format('Y-m-d'),
                'backgroundColor' => '#ffc107',
                'borderColor' => '#ffc107',
                'description' => 'Icon dibuat oleh ' . ($icon->user->name ?? '-')
            ];
        }

        // Businesses
        foreach (Business::all() as $business) {
            $events[] = [
                'title' => 'Create Business: ' . ($business->nama ?? 'No Name'),
                'start' => $business->created_at->format('Y-m-d'),
                'backgroundColor' => '#6f42c1',
                'borderColor' => '#6f42c1',
                'description' => 'Business dibuat oleh ' . ($business->user->name ?? '-')
            ];
        }

        return $events;
    }

    /**
     * Get calendar events for AJAX requests.
     */
    public function getCalendarEvents()
    {
        $events = $this->getCalendarEventsData();
        return response()->json($events);
    }
}
