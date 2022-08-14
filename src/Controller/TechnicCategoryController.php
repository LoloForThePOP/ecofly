<?php

namespace App\Controller;

use App\Entity\Technic;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



/**
 * Most Categories Functions are in Category Controller
 */


class TechnicCategoryController extends AbstractController
{

    /**
     * Allow user to :
     * 
     *  - display and select Technic Categories
     * 
     * @Route("/technic/{id}/categories", name="select_technic_categories")
     * 
     */
    public function select(Technic $technic, CategoryRepository $categoryRepository)
    {

        $this->denyAccessUnlessGranted('edit', $technic);

        $categories = $categoryRepository->findBy([], ['position' => 'ASC']);

        return $this->render('technic/edit/categories/select.html.twig', [
            'categories' => $categories,
            'technic' => $technic,
        ]);
    }

    /** 
     *  
     * @Route("/technic/{id}/ajax-select-category", name="ajax_select_technic_category") 
     * 
     */
    public function ajaxSelectCategory(Request $request,Technic $technic, CategoryRepository $categoryRepository, EntityManagerInterface $manager)
    {

        $this->denyAccessUnlessGranted('edit', $technic);

        if ($request->isXmlHttpRequest()) {

            dump($request);


            $categoryId = $request->request->get('category-id');

            $category = $categoryRepository->findOneById($categoryId);

            $technicCategories = $technic->getCategories();

            if (!$technicCategories->contains($category)) {
                $technic->addCategory($category);
            } else {
                $technic->removeCategory($category);
            }

            $manager->flush();

            return new JsonResponse(true);
        }

        return new JsonResponse();
    }



}
