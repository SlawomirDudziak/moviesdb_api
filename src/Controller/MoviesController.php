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
    private $tvshows_url = "https://api.themoviedb.org/3/trending/tv/week?api_key=";
    private $person_url = "https://api.themoviedb.org/3/trending/person/week?api_key=";
    public $movies_table = array();

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

        // $content = $response->toArray();
        // return $content;
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

    public function fetchTrendingPeople()
    {
        $api_url = "{$this->person_url}{$this->api_key}";
        $response = $this->client->request(
            'GET',
            $api_url
        );

        // $content = $response->toArray();
        // return $content;
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
     * @Route("/movies", name="movies_list")
     */
    public function movies()
    {
        $movies = array();
        $movies = $this->fetchTrendingMovies();
        
        // $this->movies_table = $movies;
        $this->movies_table = $movies;
        
        return $this->render('movies/movies.html.twig', $movies);
    }
    
    /**
     * @Route("/movies/{id}", name="movie_details")
     */
    public function movie($id)
    {
        $movies = array();
        // $movies = $this->movies_table;
        $movies = $this->fetchTrendingMovies();
        // print_r($this->movies_table);
        $details = '';
        for ($i = 0; $i < 20; $i++) {
            if ($id == $movies['results'][$i]['id']) $details = $movies['results'][$i];
        }
        
        return $this->render('movies/movie_details.html.twig', array('details' => $details));
    }
    
    /**
     * @Route("/tvshows", name="tvshows_list")
     */
    public function tvshows()
    {
        $tvshows = array();
        $tvshows = $this->fetchTrendingTVShows();

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
     * @Route("/people", name="people_list")
     */
    public function people()
    {
        $people = array();
        $people = $this->fetchTrendingPeople();

        return $this->render('people/people.html.twig', $people);
    }
}