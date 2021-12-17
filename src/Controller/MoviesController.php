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

    public function __construct(HttpClientInterface $client, $api_key)
    {
        $this->client = $client;
        $this->api_key = $api_key;
    }

    public function fetchTrendingMovies()
    {
        $api_url = "{$this->movies_url}{$this->api_key}";
        $response = $this->client->request(
            'GET',
            $api_url
        );

        $content = $response->toArray();
        return $content;
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

        $content = $response->toArray();
        return $content;
    }

    /**
     * @Route("/", name="movies_list")
     */
    public function index()
    {
        $movies = array();
        $movies = $this->fetchTrendingMovies();

        return $this->render('movies/index.html.twig', $movies);
    }

    /**
     * @Route("/tvshows", name="tvshows_list")
     */
    public function tvshows()
    {
        $tvshows = array();
        $tvshows = $this->fetchTrendingTVShows();

        return $this->render('tvshows/index.html.twig', $tvshows);
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