<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Por favor, complete todos los campos correctamente.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Aquí puedes enviar el email usando Laravel Mail
            // Por ahora solo retornamos éxito
            return response()->json([
                'success' => true,
                'message' => '¡Mensaje enviado correctamente! Nos pondremos en contacto contigo pronto.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el mensaje. Por favor, inténtalo de nuevo.'
            ], 500);
        }
    }
}
