<?php

namespace App\Controller;

use App\Entity\Technic;
use App\Form\TechnicType;
use App\Form\TechnicLogoType;
use Doctrine\ORM\EntityManager;
use App\Form\TechnicValidationType;
use App\Repository\TechnicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TechnicController extends AbstractController
{
    
    /**
     * @Route("/technic/new", name="new_technic")
     */
    public function new(Request $request, EntityManagerInterface $manager): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');

        $technic = new Technic ();

        $form = $this->createForm(
            TechnicType::class,
            $technic,
            array(

                // Time protection
                'antispam_time'     => true,
                'antispam_time_min' => 3,
                'antispam_time_max' => 3600,
            )
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $technic->setCreator($this->getUser());

            $manager->persist($technic);
            $manager->flush();

            $this->addFlash(
                'success fs-4',
                "✅ La technique a été ajoutée avec succès <br> Merci pour votre aide 👍"
            );

            return $this->redirectToRoute('show_technic', [

                'id' => $technic->getId(),

            ]);

        }

        return $this->render('technic/create.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/technic/{id}/update", name="update_technic")
     */
    public function update(Technic $technic, Request $request, EntityManagerInterface $manager): Response
    {

        $this->denyAccessUnlessGranted('edit', $technic);

        $form = $this->createForm(
            TechnicType::class,
            $technic
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();

            $this->addFlash(
                'success fs-4',
                "✅ La présentation de la technique a été modifiée avec succès"
            );

            return $this->redirectToRoute('show_technic', [
                'id' => $technic->getId(),
            ]);

        }

        return $this->render('technic/create.html.twig', [
            'form' => $form->createView(),
        ]);

    }



    /**
     * @Route("/technic/{id}/show", name="show_technic")
     */
    public function show(Technic $technic, Request $request,  EntityManagerInterface $manager): Response
    {

        if ($this->isGranted('ROLE_ADMIN')) {

            $technicLogoForm = $this->createForm(
                TechnicLogoType::class,
                $technic,
               
            );

            $technicLogoForm->handleRequest($request);

            if ($technicLogoForm->isSubmitted() && $technicLogoForm->isValid()) {

                $manager->flush();

                $this->addFlash(
                    'success fade-out',
                    "✅ Un logo a été ajouté pour la technique ".$technic->getName()."."
                );

                return $this->redirectToRoute(
                    'show_technic',
    
                    [
    
                        'id' => $technic->getId(),
    
                    ]

                );

            }


            $technicValidationform = $this->createForm(
                TechnicValidationType::class,
                $technic,
               
            );

            $technicValidationform->handleRequest($request);

            if ($technicValidationform->isSubmitted() && $technicValidationform->isValid()) {

                $manager->flush();

                $this->addFlash(
                    'success fade-out',
                    "✅ La technique est validée pour apparaître sur le site"
                );

                return $this->redirectToRoute(
                    'show_technic',
    
                    [
    
                        'id' => $technic->getId(),
    
                    ]

                );

            }

            return $this->render('technic/show.html.twig', [
                'technic' => $technic,
                "technicLogoForm" => $technicLogoForm->createView(),
                "technicValidationForm" => $technicValidationform->createView(),
            ]);

        }

        return $this->render('technic/show.html.twig', [
            'technic' => $technic,
        ]);

    }





}
