<?php

namespace App\Controller;

use App\Service\UluleAPI;
use App\Repository\TechnicRepository;
use Algolia\SearchBundle\SearchService;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    
    /**
     * @Route("/", name="homepage")
     */
    public function index(CategoryRepository $catRepo/* EntityManagerInterface $manager */): Response
    {
             
        $categories = $catRepo->findAll();

        // Categories in order to get their Technics


        // last 20 inserted technics presentations

        /* $technics = $manager->createQuery('SELECT t FROM App\Entity\Technic t WHERE t.isAdminValidated=true ORDER BY t.createdAt DESC')->setMaxResults('30')->getResult(); */


        // last 20 inserted projects presentations

       /*  $lastInsertedProjects = $manager->createQuery('SELECT p FROM App\Entity\PPBase p WHERE p.isPublished=true AND p.overallQualityAssessment>=2 AND p.isAdminValidated=true AND p.isDeleted=false ORDER BY p.createdAt DESC')->setMaxResults('30')->getResult();
 */
        return $this->render("/home/homepage.html.twig", [
            /* 'lastInsertedProjects' => $lastInsertedProjects, */
            'categories' => $categories,
        ]);

    }

    
    /**
     * 
     * Test something
     * 
     * @Route("/test-something", name="test_something")
     */
     public function test(): Response
    {

        return $this->render("/test_something.html.twig", [
            
        ]);

    }




}
