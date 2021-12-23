<?php
namespace App\Controller;

use App\Entity\Playlist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlaylistController extends AbstractController
{
    /**
     * @Route("/playlist", name="playlist")
     */
    public function playlist()
    {
        $movies = $this->getDoctrine()->getRepository(Playlist::class)->findAll();

        return $this->render('playlist/playlist.html.twig', array('movies' => $movies));
    }

    /**
     * @Route("/save/{type}/{name}/{release_date}")
     */
    public function playlist_save($type, $name, $release_date)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $playlist = new Playlist();
        $playlist->setType($type);
        $playlist->setName($name);
        $playlist->setReleaseDate($release_date);
        $playlist->setDeleted(0);
        $playlist->setWatched(0);

        $entityManager->persist($playlist);
        $entityManager->flush();

        return $this->redirectToRoute('playlist');
    }

    /**
     * @Route("playlist/watched/{id}")
     */
    public function playlist_set_watched($id)
    {
        $movie = $this->getDoctrine()->getRepository(Playlist::class)->find($id);
        $movie->setWatched(1);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('playlist');
    }

    /**
     * @Route("/playlist/delete/{id}")
     */
    public function playlist_delete($id)
    {
        $movie = $this->getDoctrine()->getRepository(Playlist::class)->find($id);
        $movie->setDeleted(1);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('playlist');
    }
}
