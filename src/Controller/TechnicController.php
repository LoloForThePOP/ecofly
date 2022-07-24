<?php

namespace App\Controller;

use App\Entity\Slide;
use App\Entity\Technic;
use App\Form\TechnicType;
use App\Service\TreatItem;
use App\Form\ImageSlideType;
use App\Form\VideoSlideType;
use App\Form\TechnicLogoType;
use App\Service\ImageResizer;
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
    public function show(Technic $technic, Request $request,  EntityManagerInterface $manager, TreatItem $specificTreatments, ImageResizer $imageResizer): Response
    {

        if ($this->isGranted('ROLE_ADMIN')) {

            $imageSlide = new Slide();
            $imageSlide->setType('image');
            $addImageForm = $this->createForm(ImageSlideType::class, $imageSlide);
            $addImageForm->handleRequest($request);
            
            if ($addImageForm->isSubmitted() && $addImageForm->isValid()) {
                

                $imageSlide->setPosition(count($technic->getSlides()));

                $technic->addSlide($imageSlide);

                $manager->persist($imageSlide);
                $manager->flush();

                $imageResizer->edit($imageSlide);

                $this->addFlash(
                    'success',
                    "✅ Image ajoutée"
                );

                return $this->redirectToRoute(
                    'show_technic',
    
                    [
    
                        'id' => $technic->getId(),
    
                    ]

                );

            }

            $videoSlide = new Slide();
            $videoSlide->setType('youtube_video'); //only Youtube Videos are allowed currently.
            $addVideoForm = $this->createForm(VideoSlideType::class, $videoSlide);
            $addVideoForm->handleRequest($request);
            
            if ($addVideoForm->isSubmitted() && $addVideoForm->isValid()) {

                $youtubeVideoIdentifier = $specificTreatments->specificTreatments('youtube_video', $addVideoForm->get('address')->getData());//user might has given a complete youtube video url or just the video identifier. We extract the video identifier in the first case.

                $videoSlide->setAddress($youtubeVideoIdentifier);   

                // count previous slide in order to set new slides positions
                $videoSlide->setPosition(count($technic->getSlides()));

                $technic->addSlide($videoSlide);
                $manager->persist($videoSlide);

                $this->addFlash(
                    'success',
                    "✅ Vidéo ajoutée"
                );

                return $this->redirectToRoute(
                    'show_technic',
    
                    [
    
                        'id' => $technic->getId(),
    
                    ]

                );

            }

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
                "imageSlideForm" => $addImageForm->createView(),
                "videoSlideForm" => $addVideoForm->createView(),
                "technicLogoForm" => $technicLogoForm->createView(),
                "technicValidationForm" => $technicValidationform->createView(),
            ]);

        }

        return $this->render('technic/show.html.twig', [
            'technic' => $technic,
        ]);

    }





}
