<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;

class MoviesController extends AbstractController {
    private $client;
    private $api_key;
    private $movies_url = "https://api.themoviedb.org/3/movie/upcoming?api_key=";
    private $top_rated_movies_url = "https://api.themoviedb.org/3/movie/top_rated?api_key=";
    private $tvshows_url = "https://api.themoviedb.org/3/trending/tv/week?api_key=";
    private $top_rated_tvshows_url = "https://api.themoviedb.org/3/tv/top_rated?api_key=";
    private $person_url = "https://api.themoviedb.org/3/trending/person/week?api_key=";
    // public $movies_table = array();

    public function __construct(HttpClientInterface $client, $api_key)
    {
        $this->client = $client;
        $this->api_key = $api_key;
        // $this->movies_table = $movies_table;
    }

    public function fetchTrendingMovies()
    {
        $api_url = "{$this->movies_url}{$this->api_key}";
        $response = $this->client->request(
            'GET',
            $api_url
        );

        return $response->toArray();
    }

    public function fetch_top_rated_movies()
    {
        $api_url = "{$this->top_rated_movies_url}{$this->api_key}";
        $response = $this->client->request(
            'GET',
            $api_url
        );

        return $response->toArray();
    }

    public function fetchTrendingTVShows()
    {
        $api_url = "{$this->tvshows_url}{$this->api_key}";
        $response = $this->client->request(
            'GET',
            $api_url
        );

        return $response->toArray();
    }

    public function fetch_top_rated_tvshows()
    {
        $api_url = "{$this->top_rated_tvshows_url}{$this->api_key}";
        $response = $this->client->request(
            'GET',
            $api_url
        );

        return $response->toArray();
    }

    public function fetchTrendingPeople()
    {
        $api_url = "{$this->person_url}{$this->api_key}";
        $response = $this->client->request(
            'GET',
            $api_url
        );

        return $response->toArray();
    }

    public function getMovies()
    {
        return $this->movies_table;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/movies/upcoming", name="upcoming_movies")
     */
    public function movies()
    {
        $movies = array();
        $movies = $this->fetchTrendingMovies();
                
        return $this->render('movies/movies.html.twig', $movies);
    }
    
    /**
     * @Route("/movies/toprated", name="top_rated_movies")
     */
    public function top_rated_movies()
    {
        $movies = $this->fetch_top_rated_movies();

        return $this->render('movies/movies.html.twig', $movies);
    }
    
    /**
     * @Route("/movies/{id}", name="movie_details")
     */
    public function movie($id)
    {
        $movies = array();
        $movies = $this->fetchTrendingMovies();
        $details = '';
        for ($i = 0; $i < 20; $i++) {
            if ($id == $movies['results'][$i]['id']) $details = $movies['results'][$i];
        }
        
        return $this->render('movies/movie_details.html.twig', array('details' => $details));
    }
    
    /**
     * @Route("/tvshows/upcoming", name="upcoming_tvshows")
     */
    public function tvshows()
    {
        $tvshows = array();
        $tvshows = $this->fetchTrendingTVShows();

        return $this->render('tvshows/tvshows.html.twig', $tvshows);
    }

    /**
     * @Route("/tvshows/toprated", name="top_rated_tvshows")
     */
    public function top_rated_tvshows()
    {
        $tvshows = $this->fetch_top_rated_tvshows();

        return $this->render('tvshows/tvshows.html.twig', $tvshows);
    }

    /**
     * @Route("/tvshows/{id}", name="tvshows_details")
     */
    public function tvshow($id)
    {
        $tvshows = array();
        $tvshows = $this->fetchTrendingTVShows();
        $details = '';
        for ($i = 0; $i < 20; $i++) {
            if ($id == $tvshows['results'][$i]['id']) $details = $tvshows['results'][$i];
        }
        
        return $this->render('tvshows/tvshow_details.html.twig', array('details' => $details));
    }

    /**
     * @Route("/people/popular", name="popular_people")
     */
    public function people()
    {
        $people = array();
        $people = $this->fetchTrendingPeople();

        return $this->render('people/people.html.twig', $people);
    }
}