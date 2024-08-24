<?php

namespace App\Http\Controllers;

use App\Http\Utilities\CockpitApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PageController extends Controller
{

    public function messages()
    {
        $cms = new CockpitApiClient;
        $messages = $cms->model('messages')->result();

        return view('welcome', [
            'messages' => $messages
        ]);
    }

    public function recipes()
    {
        $cms = new CockpitApiClient;
        $categories = $cms->model('recipesCategories')->result();

        // Funktion zur Vergleichsfunktion für die Sortierung nach dem Namen der Kategorie
        $compareFunction = function($a, $b) {
            return strcmp($a['name'], $b['name']);
        };

        // Alphabetisch nach dem Namen der Kategorie sortieren
        usort($categories, $compareFunction);

        return view('rezepte', [
            'categories' => $categories
        ]);
    }

    public function category($slug)
    {
        $cms = new CockpitApiClient;
        $category = $cms->model('recipesCategories')->filter('slug', '=', $slug)->result();
        $recipes = $cms->model('recipes')->filter('category._id', '=', $category[0]['_id'])->populate()->result();

        // Funktion zur Vergleichsfunktion für die Sortierung nach dem Produkt
        $compareFunction = function($a, $b) {
            return strcmp($a['product'], $b['product']);
        };

        // Alphabetisch nach Produkt sortieren
        usort($recipes, $compareFunction);

        return view('category', [
            'recipes' => $recipes
        ]);
    }

    public function ansprechpartner()
    {
        $cms = new CockpitApiClient;
        $contacts = $cms->model('contacts')->result();

        return view('ansprechpartner', [
            'contacts' => $contacts
        ]);
    }

    public function operatingInstructions()
    {
        $cms = new CockpitApiClient;
        $operatingInstructions = $cms->model('operatingInstructions')->result();


        // Funktion zur Vergleichsfunktion für die Sortierung nach dem Titel
        $compareFunction = function($a, $b) {
            return strcmp($a['title'], $b['title']);
        };

        // Alphabetisch nach Titel sortieren
        usort($operatingInstructions, $compareFunction);

        return view('betriebsanweisungen', [
            'operatingInstructions' => $operatingInstructions
        ]);
    }

    public function manuals()
    {
        $cms = new CockpitApiClient;
        $manuals = $cms->model('manuals')->result();

        // Funktion zur Vergleichsfunktion für die Sortierung nach dem Titel
        $compareFunction = function($a, $b) {
            return strcmp($a['title'], $b['title']);
        };

        // Alphabetisch nach Titel sortieren
        usort($manuals, $compareFunction);

        return view('gebrauchsanweisungen', [
            'manuals' => $manuals
        ]);
    }

    public function laws()
    {
        $cms = new CockpitApiClient;
        $laws = $cms->model('laws')->result();

        return view('gesetze', [
            'laws' => $laws
        ]);
    }

    public function notices()
    {
        $cms = new CockpitApiClient;
        $notices = $cms->model('notices')->result();


        // Funktion zur Vergleichsfunktion für die Sortierung nach dem Titel
        $compareFunction = function($a, $b) {
            return strcmp($a['title'], $b['title']);
        };

        // Alphabetisch nach Titel sortieren
        usort($notices, $compareFunction);

        return view('aushaenge', [
            'notices' => $notices
        ]);
    }
}
