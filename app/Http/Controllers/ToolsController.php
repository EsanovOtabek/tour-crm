<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Nnjeim\World\World;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    protected function middleware(): array
    {
        return [
            'permission:tools.countries' => ['only' => ['countries']],
            'permission:tools.languages' => ['only' => ['languages']],
            'permission:tools.currencies' => ['only' => [ 'currencies']],
        ];
    }
    public function countries()
    {
        $countries = DB::table('countries')->get();

        return view('tools.countries', compact('countries'));
    }


    // Languages
    public function languages()
    {
        $languages = DB::table('languages')->get();

        return view('tools.languages', compact('languages'));
    }

    // Currencies
    public function currencies()
    {
        $currencies = DB::table('currencies')->get();

        return view('tools.currencies', compact('currencies'));
    }
}
