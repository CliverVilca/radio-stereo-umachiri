<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use App\Models\Comment;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AnalyticsApiController extends BaseApiController
{
    /**
     * Get analytics data.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $period = $request->get('period', '30'); // days
            $startDate = now()->subDays($period);

            $analytics = [
                'summary' => $this->getSummaryStats($startDate),
                'content_performance' => $this->getContentPerformance($startDate),
                'engagement_metrics' => $this->getEngagementMetrics($startDate),
                'trends' => $this->getTrends($startDate),
                'top_content' => $this->getTopContent($startDate),
            ];

            return $this->successResponse($analytics, 'Analytics obtenidos correctamente');
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener los analytics', 500);
        }
    }

    /**
     * Get summary statistics.
     */
    private function getSummaryStats($startDate): array
    {
        return [
            'page_views' => rand(1000, 5000), // Placeholder - integrate with real analytics
            'unique_visitors' => rand(500, 2000),
            'avg_session_duration' => '5:30',
            'bounce_rate' => '35%',
            'new_content' => [
                'news' => News::where('created_at', '>=', $startDate)->count(),
                'events' => Event::where('created_at', '>=', $startDate)->count(),
                'comments' => Comment::where('created_at', '>=', $startDate)->count(),
            ],
        ];
    }

    /**
     * Get content performance metrics.
     */
    private function getContentPerformance($startDate): array
    {
        $newsWithComments = News::withCount(['comments' => function ($query) use ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }])
        ->where('created_at', '>=', $startDate)
        ->orderBy('comments_count', 'desc')
        ->limit(10)
        ->get(['id', 'title', 'created_at'])
        ->map(function ($news) {
            return [
                'title' => $news->title,
                'comments' => $news->comments_count,
                'views' => rand(50, 500), // Placeholder
                'engagement_rate' => rand(5, 25) . '%',
                'created_at' => $news->created_at,
            ];
        });

        return [
            'top_news' => $newsWithComments,
            'content_types' => [
                'news' => [
                    'total' => News::count(),
                    'published' => News::where('status', 'published')->count(),
                    'draft' => News::where('status', 'draft')->count(),
                ],
                'events' => [
                    'total' => Event::count(),
                    'upcoming' => Event::where('event_date', '>=', now())->count(),
                    'past' => Event::where('event_date', '<', now())->count(),
                ],
            ],
        ];
    }

    /**
     * Get engagement metrics.
     */
    private function getEngagementMetrics($startDate): array
    {
        $commentsByDay = Comment::where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        $newsByDay = News::where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        return [
            'comments_by_day' => $commentsByDay,
            'news_by_day' => $newsByDay,
            'comment_approval_rate' => $this->getCommentApprovalRate(),
            'most_active_days' => $this->getMostActiveDays($startDate),
        ];
    }

    /**
     * Get trends data.
     */
    private function getTrends($startDate): array
    {
        $previousPeriod = $startDate->copy()->subDays($startDate->diffInDays(now()));
        
        $currentPeriodNews = News::where('created_at', '>=', $startDate)->count();
        $previousPeriodNews = News::whereBetween('created_at', [$previousPeriod, $startDate])->count();
        
        $currentPeriodComments = Comment::where('created_at', '>=', $startDate)->count();
        $previousPeriodComments = Comment::whereBetween('created_at', [$previousPeriod, $startDate])->count();

        return [
            'news_trend' => $this->calculateTrend($currentPeriodNews, $previousPeriodNews),
            'comments_trend' => $this->calculateTrend($currentPeriodComments, $previousPeriodComments),
            'engagement_trend' => $this->calculateTrend(
                $currentPeriodComments + $currentPeriodNews,
                $previousPeriodComments + $previousPeriodNews
            ),
        ];
    }

    /**
     * Get top performing content.
     */
    private function getTopContent($startDate): array
    {
        return [
            'most_commented_news' => News::withCount(['comments' => function ($query) use ($startDate) {
                $query->where('created_at', '>=', $startDate);
            }])
            ->having('comments_count', '>', 0)
            ->orderBy('comments_count', 'desc')
            ->limit(5)
            ->get(['id', 'title', 'created_at'])
            ->map(function ($news) {
                return [
                    'title' => $news->title,
                    'comments' => $news->comments_count,
                    'url' => "/noticias/{$news->id}",
                ];
            }),
            
            'recent_popular' => News::where('created_at', '>=', $startDate)
                ->withCount('comments')
                ->orderBy('comments_count', 'desc')
                ->limit(5)
                ->get(['id', 'title', 'type', 'created_at'])
                ->map(function ($news) {
                    return [
                        'title' => $news->title,
                        'type' => $news->type,
                        'comments' => $news->comments_count,
                        'created_at' => $news->created_at,
                    ];
                }),
        ];
    }

    /**
     * Calculate trend percentage.
     */
    private function calculateTrend($current, $previous): array
    {
        if ($previous == 0) {
            $percentage = $current > 0 ? 100 : 0;
        } else {
            $percentage = round((($current - $previous) / $previous) * 100, 1);
        }

        return [
            'current' => $current,
            'previous' => $previous,
            'percentage' => $percentage,
            'direction' => $percentage > 0 ? 'up' : ($percentage < 0 ? 'down' : 'stable'),
        ];
    }

    /**
     * Get comment approval rate.
     */
    private function getCommentApprovalRate(): array
    {
        $total = Comment::count();
        $approved = Comment::where('status', 'approved')->count();
        $pending = Comment::where('status', 'pending')->count();
        $rejected = Comment::where('status', 'rejected')->count();

        return [
            'total' => $total,
            'approved' => $approved,
            'pending' => $pending,
            'rejected' => $rejected,
            'approval_rate' => $total > 0 ? round(($approved / $total) * 100, 1) : 0,
        ];
    }

    /**
     * Get most active days.
     */
    private function getMostActiveDays($startDate): array
    {
        $dayNames = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        
        $commentsByDay = Comment::where('created_at', '>=', $startDate)
            ->select(DB::raw('DAYOFWEEK(created_at) as day'), DB::raw('count(*) as count'))
            ->groupBy('day')
            ->pluck('count', 'day')
            ->toArray();

        $result = [];
        foreach ($dayNames as $index => $dayName) {
            $result[] = [
                'day' => $dayName,
                'activity' => $commentsByDay[$index + 1] ?? 0,
            ];
        }

        return collect($result)->sortByDesc('activity')->values()->all();
    }
}