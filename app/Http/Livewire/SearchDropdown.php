<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Throwable;
use Illuminate\Support\Str;



class SearchDropdown extends Component
{
    public $search = '';

    public function render()
    {
        $searchResults = [];
    
        if (strlen($this->search) >= 2) {
            try {
                $response = Http::withToken(config('services.tmdb.token'))
                    ->get('https://api.themoviedb.org/3/search/movie?query=' . $this->search)
                    ->json();
    
                if (isset($response['results'])) {
                    $searchResults = $response['results'];
                }
            } catch (Throwable $e) {
                // Handle the exception or log the error.
                // You can customize this based on your needs.
                // For example:
                // Log::error('Failed to fetch search results: ' . $e->getMessage());
                // return response()->json(['error' => 'Failed to fetch search results.'], 500);
            }
        }
    
        return view('livewire.search-dropdown', [
            'searchResults' => collect($searchResults)->take(7),
        ]);
    }
    
}
