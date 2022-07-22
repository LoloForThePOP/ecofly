<?php

namespace App\Controller;

use App\Entity\Technic;
use App\Form\TechnicType;
use App\Form\TechnicLogoType;
use Doctrine\ORM\EntityManager;
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

            if($this->getUser()){ //when user is logged in, we attach technic authorship to this user

                $technic->setCreator($this->getUser());

            }

            $manager->persist($technic);
            $manager->flush();

            $this->addFlash(
                'success fs-4',
                "✅ La technique a été ajoutée avec succès <br> Merci pour votre aide 👍"
            );

            return $this->redirectToRoute('homepage', []);

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

            return $this->render('technic/show.html.twig', [
                'technic' => $technic,
                "technicLogoForm" => $technicLogoForm->createView(),
            ]);

        }

        return $this->render('technic/show.html.twig', [
            'technic' => $technic,
        ]);

    }





}
