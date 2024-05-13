<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Middleware\CorsMiddleware;

// Ruta para la página de bienvenida
Route::get('/', function () {
    return view('welcome');
});
Route::middleware([CorsMiddleware::class])->get('/hello', function () {
    return 'welcome';
});
// Ruta para obtener datos de Trade Marketing
// /api/trade-marketing?DateStart=20230101&DateFinish=20240423
Route::get('/trade-marketing', function (Illuminate\Http\Request $request) {
    // Validar los parámetros de fecha de la solicitud
    $validatedData = $request->validate([
        'DateStart' => 'required|date',
        'DateFinish' => 'required|date|after_or_equal:DateStart',
    ]);

    // Realizar la solicitud a la otra API
    $response = Http::get('http://190.12.79.135:8060/get/api/TradeMarketing/Get', [
        'DateStart' => $validatedData['DateStart'],
        'DateFinish' => $validatedData['DateFinish']
    ]);

    // Verificar si la respuesta es exitosa
    if ($response->successful()) {
        // Obtener los datos de la respuesta y formatearlos según sea necesario
        $data = $response->json();

        // Devolver los datos en un formato JSON con los encabezados CORS configurados
        return response()->json($data)->header('Access-Control-Allow-Origin', '*');
    } else {
        // Devolver un error si la respuesta falla
        return response()->json(['error' => 'No se pudo obtener la información de Trade Marketing'], 500);
    }
});
Route::get('/trade-marketing', function (Illuminate\Http\Request $request) {
    // Validar los parámetros de fecha de la solicitud
    $validatedData = $request->validate([
        'DateStart' => 'required|date',
        'DateFinish' => 'required|date|after_or_equal:DateStart',
    ]);

    // Realizar la solicitud a la otra API
    $response = Http::get('http://190.12.79.135:8060/get/api/TradeMarketing/Get', [
        'DateStart' => $validatedData['DateStart'],
        'DateFinish' => $validatedData['DateFinish']
    ]);

    // Verificar si la respuesta es exitosa
    if ($response->successful()) {
        // Obtener los datos de la respuesta y formatearlos según sea necesario
        $data = $response->json();

        // Devolver los datos en un formato JSON con los encabezados CORS configurados
        return response()->json($data)->header('Access-Control-Allow-Origin', '*');
    } else {
        // Devolver un error si la respuesta falla
        return response()->json(['error' => 'No se pudo obtener la información de Trade Marketing'], 500);
    }
});
