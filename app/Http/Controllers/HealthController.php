<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class HealthController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $checks = [
            'cache' => $this->checkCache(),
            'content' => $this->checkContentFiles(),
            'mail' => $this->checkMailConfig(),
        ];

        $healthy = collect($checks)->every(fn ($check) => $check['healthy']);

        $statusCode = $healthy ? 200 : 503;

        return response()->json([
            'status' => $healthy ? 'healthy' : 'degraded',
            'checks' => $checks,
            'timestamp' => now()->toIso8601String(),
        ], $statusCode);
    }

    private function checkCache(): array
    {
        try {
            Cache::store('file')->put('health-check', true, 1);
            $ok = Cache::store('file')->get('health-check') === true;
            Cache::store('file')->forget('health-check');
            return ['healthy' => $ok, 'message' => $ok ? 'Cache reachable' : 'Cache write/read failed'];
        } catch (\Exception $e) {
            return ['healthy' => false, 'message' => $e->getMessage()];
        }
    }

    private function checkContentFiles(): array
    {
        $paths = [
            'projects' => base_path('content/projects'),
            'articles' => base_path('content/articles'),
            'skills' => base_path('content/skills.json'),
            'experiences' => base_path('content/experiences.json'),
            'education' => base_path('content/education.json'),
            'testimonials' => base_path('content/testimonials.json'),
            'settings' => base_path('content/settings.json'),
        ];

        $missing = [];
        foreach ($paths as $name => $path) {
            if (! File::exists($path)) {
                $missing[] = $name;
            }
        }

        $healthy = empty($missing);
        return [
            'healthy' => $healthy,
            'message' => $healthy ? 'All content files present' : 'Missing: '.implode(', ', $missing),
        ];
    }

    private function checkMailConfig(): array
    {
        $mailer = config('mail.default');
        $fromAddress = config('mail.from.address');

        $healthy = ! empty($fromAddress);
        return [
            'healthy' => $healthy,
            'message' => $healthy ? "Mailer: {$mailer}, From: {$fromAddress}" : 'Mail from address not configured',
        ];
    }
}
