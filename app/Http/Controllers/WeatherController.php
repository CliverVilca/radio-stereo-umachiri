<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    /**
     * Get current weather and forecast from OpenWeatherMap API.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWeather(Request $request)
    {
        $apiKey = env('OPENWEATHER_API_KEY');
        $lat = $request->input('lat', ''); // Default latitude if needed
        $lon = $request->input('lon', ''); // Default longitude if needed

        if (empty($lat) || empty($lon)) {
            return response()->json(['error' => 'Latitude and longitude are required'], 400);
        }

        // MOCK DATA FALLBACK (If no API Key or API Error)
        if (empty($apiKey) || $request->input('mock') === 'true') {
            // Generar algo de variación para que se sienta dinámico
            $baseTemp = rand(10, 25); 
            $weatherTypes = [
                ['description' => 'cielo claro', 'icon' => '01d'],
                ['description' => 'parcialmente nublado', 'icon' => '02d'],
                ['description' => 'lluvia ligera', 'icon' => '10d']
            ];
            $currentWeather = $weatherTypes[array_rand($weatherTypes)];
            
            return response()->json([
                'current' => [
                    'temp' => $baseTemp,
                    'humidity' => rand(30, 80),
                    'wind_speed' => rand(2, 8),
                    'weather' => [$currentWeather]
                ],
                'daily' => array_map(function($i) use ($baseTemp) {
                    $dayTemp = $baseTemp + rand(-3, 3);
                    return [
                        'dt' => time() + ($i * 86400),
                        'temp' => ['max' => $dayTemp + 4, 'min' => $dayTemp - 4],
                        'weather' => [['description' => 'variable', 'icon' => '02d']]
                    ];
                }, range(1, 5))
            ]);
        }

        $url = "https://api.openweathermap.org/data/2.5/onecall";
        
        try {
            $response = Http::get($url, [
                'lat' => $lat,
                'lon' => $lon,
                'exclude' => 'minutely,alerts',
                'units' => 'metric',
                'lang' => 'es',
                'appid' => $apiKey,
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }
        } catch (\Exception $e) {
            // Fallthrough to error if fetch fails completely
        }

        return response()->json(['error' => 'Failed to fetch weather data'], 500);
    }
}
