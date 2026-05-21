<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Cuaca;
use App\Models\Sawah;

class CuacaController extends Controller
{
    public function index()
    {
        $city = "Indramayu";
        $apiKey = '3528ceb82663ef89787704264b0d201b';

        // ===============================
        // CUACA HARI INI (REAL-TIME)
        // ===============================
        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q'     => $city,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang'  => 'id'
        ]);

        $current = $response->json();

        // Simpan ke database jika berhasil
        if ($response->successful()) {
            Cuaca::updateOrCreate(
                [
                    'lokasi'  => $city,
                    'tanggal' => now()->toDateString()
                ],
                [
                    'suhu'             => $current['main']['temp'] ?? null,
                    'kelembaban'       => $current['main']['humidity'] ?? null,
                    'curah_hujan'      => $current['rain']['1h'] ?? 0,
                    'kecepatan_angin'  => $current['wind']['speed'] ?? null,
                    'kondisi'          => $current['weather'][0]['description'] ?? null,
                ]
            );
        }

        // ===============================
        // FORECAST 7 HARI
        // ===============================
        $forecast = Http::get("https://api.openweathermap.org/data/2.5/forecast", [
            'q'     => $city,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang'  => 'id'
        ])->json();

        // ===============================
        // DATA SAWAH PETANI
        // ===============================
        $sawah = Sawah::where('user_id', auth()->id())->get();

        return view('dashboard.cuaca', compact('current', 'forecast', 'sawah'));
    }
}
