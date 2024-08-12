<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function show()
    {
        return view('survey');
    }

    public function submit(Request $request)
    {
        // Verarbeiten Sie die Bewertung hier, z.B. speichern Sie sie in der Datenbank
        $rating = $request->input('rating');

        // Speichern Sie die Bewertung in der Datenbank oder führen Sie eine andere Aktion aus

        return redirect('/survey')->with('status', 'Danke für Deine Bewertung!');
    }
}
