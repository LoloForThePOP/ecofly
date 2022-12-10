<?php

namespace App\Controller;

use App\Entity\PPBase;
use App\Service\CacheThumbnail;
use Doctrine\ORM\EntityManager;
use App\Repository\PlaceRepository;
use App\Repository\PPBaseRepository;
use App\Repository\TechnicRepository;
use App\Repository\CategoryRepository;
use Algolia\SearchBundle\SearchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * This controller allows to perform an action that will be executed only once. Exemple : change something in database for all users.
 * 
 * It is only accessed for admins thanks to  /admin/ route
 * 
 * It is safe to delete the method content once it's been applied
 * 
 */
class OneShotController extends AbstractController
{

    /**
     * @Route("/admin/one-shot", name="one_shot")
     * 
     */
    public function doAction(PPBaseRepository $repo, TechnicRepository $technicsRepo, CategoryRepository $categoriesRepo, SearchService $searchService, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {

        $technics = $technicsRepo->findAll();

        foreach ($technics as $technic) {

            $technic->setNameSlug(strtolower($slugger->slug( $technic->getName())));

        }

        $manager->flush();



        /* 

        $places = $placesRepo->findAll();

        foreach ($places as $place) {

            $place->setGeoloc(
                [
                    "lat" => floatval($place->getGeoloc()["lat"]),
                    "lng" => floatval($place->getGeoloc()["lng"]),
                ]
            );

        }

        
        $manager->flush();

        
       
        
            $presentations = $repo->findAll();

            $em = $this->getDoctrine()->getManagerForClass(PPBase::class);

            foreach ($presentations as $presentation) {
                $searchService->index($em, $presentation);
            } 
        
            $categories = $categoriesRepo->findAll();

            foreach ($categories as $category) {
                $searchService->index($em, $category);
            } */ 
        
/*  
        $places = $placesRepo->findAll();

        foreach ($places as $place) {

            $place->setGeoloc(
                [
                    "lat" => floatval($place->getGeoloc()["lat"]),
                    "lng" => floatval($place->getGeoloc()["lng"]),
                ]
            );

        }

        $manager->flush(); */

        $this->addFlash(
            'success',
            "✅ L'action one-shot a été effectuée."
        );

        return $this->redirectToRoute('homepage', [
            'controller_name' => 'OneShotController',
        ]);

    }

}
