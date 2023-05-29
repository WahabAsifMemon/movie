<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ViewModels\TvViewModel;
use App\ViewModels\TvShowViewModel;
use Illuminate\Support\Facades\Http;
use Throwable;
use Illuminate\Support\Str;

    

class TvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $popularTv = [];
        $topRatedTv = [];
        $genres = [];
    
        try {
            $popularTvResponse = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/tv/popular')
                ->json();
    
            if (isset($popularTvResponse['results'])) {
                $popularTv = $popularTvResponse['results'];
            }
    
            $topRatedTvResponse = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/tv/top_rated')
                ->json();
    
            if (isset($topRatedTvResponse['results'])) {
                $topRatedTv = $topRatedTvResponse['results'];
            }
    
            $genresResponse = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/genre/tv/list')
                ->json();
    
            if (isset($genresResponse['genres'])) {
                $genres = $genresResponse['genres'];
            }
        } catch (Throwable $e) {
            // Handle the exception or log the error.
            // You can customize this based on your needs.
            return response()->json(['error' => 'Failed to fetch TV data.'], 500);
        }
    
        $viewModel = new TvViewModel(
            $popularTv,
            $topRatedTv,
            $genres
        );
    
        return view('tv.index', $viewModel);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tvshow = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/tv/'.$id.'?append_to_response=credits,videos,images')
            ->json();

        $viewModel = new TvShowViewModel($tvshow);

        return view('tv.show', $viewModel);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
