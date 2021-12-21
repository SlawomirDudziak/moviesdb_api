<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class TVShowsController extends AbstractController
{
    private $client;
    private $api_key;
    private $tmdb_url = "https://api.themoviedb.org/3";

    public function __construct(HttpClientInterface $client, $api_key)
    {
        $this->client = $client;
        $this->api_key = $api_key;
    }

    public function fetch_tvshows($tvshows)
    {
        $api_url = "{$this->tmdb_url}/tv/{$tvshows}?api_key={$this->api_key}";
        $response = $this->client->request(
            'GET',
            $api_url
        );

        return $response->toArray();
    }

    /**
     * @Route("/tvshows/upcoming", name="upcoming_tvshows")
     */
    public function upcoming_tvshows()
    {
        $tvshows = $this->fetch_tvshows('on_the_air');

        return $this->render('tvshows/tvshows.html.twig', $tvshows);
    }

    /**
     * @Route("/tvshows/toprated", name="top_rated_tvshows")
     */
    public function top_rated_tvshows()
    {
        $tvshows = $this->fetch_tvshows('top_rated');

        return $this->render('tvshows/tvshows.html.twig', $tvshows);
    }

    /**
     * @Route("/tvshows/{id}", name="tvshows_details")
     */
    public function tvshow($id)
    {
        $tvshows = $this->fetch_tvshows('on_the_air');
        $details = '';
        for ($i = 0; $i < 20; $i++) {
            if ($id == $tvshows['results'][$i]['id']) $details = $tvshows['results'][$i];
        }
        
        return $this->render('tvshows/tvshow_details.html.twig', array('details' => $details));
    }
}
