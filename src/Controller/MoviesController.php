<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;

class MoviesController extends AbstractController
{
    private $client;
    private $api_key;
    private $tmdb_url = "https://api.themoviedb.org/3";

    public function __construct(HttpClientInterface $client, $api_key)
    {
        $this->client = $client;
        $this->api_key = $api_key;
    }

    public function fetch_movies($movies)
    {
        $api_url = "{$this->tmdb_url}/movie/{$movies}?api_key={$this->api_key}";
        $response = $this->client->request(
            'GET',
            $api_url
        );

        return $response->toArray();
    }

    public function fetch_popular_people()
    {
        $api_url = "{$this->tmdb_url}/trending/person/week?api_key={$this->api_key}";
        $response = $this->client->request(
            'GET',
            $api_url
        );

        return $response->toArray();
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
    public function upcoming_movies()
    {
        $movies = $this->fetch_movies('upcoming');
                
        return $this->render('movies/upcoming_movies.html.twig', $movies);
    }
    
    /**
     * @Route("/movies/toprated", name="top_rated_movies")
     */
    public function top_rated_movies()
    {
        $movies = $this->fetch_movies('top_rated');

        return $this->render('movies/top_rated_movies.html.twig', $movies);
    }
    
    /**
     * @Route("/movie/{id}", name="movie_details")
     */
    public function movie($id)
    {
        $movie = $this->fetch_movies($id);
        
        return $this->render('movies/movie_details.html.twig', array('details' => $movie));
    }

    /**
     * @Route("/people/popular", name="popular_people")
     */
    public function people()
    {
        $people = $this->fetch_popular_people();

        return $this->render('people/people.html.twig', $people);
    }
}
