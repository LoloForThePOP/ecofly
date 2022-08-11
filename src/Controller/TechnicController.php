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
use App\Service\MailerService;
use App\Form\TechnicValidationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TechnicController extends AbstractController
{
    
    /**
     * @Route("/technic/new", name="new_technic")
     */
    public function new(Request $request, EntityManagerInterface $manager, MailerService $mailer): Response
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
                'antispam_time_max' => 10000,
            )
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $technic->setCreator($this->getUser());

            $manager->persist($technic);
            $manager->flush();

            
            /* Email Webmaster that a new technic presentation has been created (moderation) */

            $sender = $this->getParameter('app.general_contact_email');
            $receiver = $sender;

            $emailParameters=[

                "techName" => $technic->getName(),
                "address" => $this->generateUrl('show_technic', ["id"=>$technic->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
                
            ];

            $mailer->send($sender, 'Flycore', $receiver, "A New Technic Presentation Has Been Created",'/technic/email_webmaster_notif_new_pp.html.twig', $emailParameters);

            $this->addFlash(
                'success fs-4',
                "✅ La solution a été ajoutée avec succès <br> Merci pour votre aide 👍"
            );

            return $this->redirectToRoute('show_technic', [

                'id' => $technic->getId(),

            ]);

        }

        return $this->render('technic/create.html.twig', [
            'form' => $form->createView(),
            'instance' => 'new',
        ]);

    }

    /**
     * @Route("/technic/{id}/update", name="update_technic")
     */
    public function update(Technic $technic, Request $request, EntityManagerInterface $manager, MailerService $mailer): Response
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
                "✅ La présentation de la solution a été modifiée avec succès"
            );

            return $this->redirectToRoute('show_technic', [
                'id' => $technic->getId(),
            ]);

        }

        if($this->isGranted('ROLE_ADMIN')){

            $technicLogoForm = $this->createForm(
                TechnicLogoType::class,
                $technic,
               
            );
    
            $technicLogoForm->handleRequest($request);
    
            if ($technicLogoForm->isSubmitted() && $technicLogoForm->isValid()) {
    
                $manager->flush();
    
                $this->addFlash(
                    'success fade-out',
                    "✅ Un logo a été ajouté pour la solution ".$technic->getName()."."
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
    
                if($technicValidationform->getData('isAdminValidated')==true){
    
                    $sender = $this->getParameter('app.general_contact_email');
                    
                    $receiver = $technic->getCreator()->getEmail();
        
                    $mailer->send($sender, 'Flycore', $receiver, "Votre présentation de solution est validée sur Flycore.", "Votre présentation de solution a été validée par un membre de notre équipe. Merci pour votre participation sur le site 👍 <br><br>L'équipe Flycore.org.");
    
                    $this->addFlash(
                        'success fade-out',
                        "✅ La solution est validée pour apparaître sur le site"
                    );
    
                }
    
    
    
                return $this->redirectToRoute(
                    'show_technic',
    
                    [
    
                        'id' => $technic->getId(),
    
                    ]
    
                );
    
            }
    
            return $this->render('technic/create.html.twig', [
                'form' => $form->createView(),
                'instance' => 'update',
                'technicLogoForm' => $technicLogoForm->createView(),
                'technicValidationForm' => $technicValidationform->createView(),
            ]);

        }

        return $this->render('technic/create.html.twig', [
            'form' => $form->createView(),
            'instance' => 'update',
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
                

                $imageSlide->setPosition(1); //count($technic->getSlides())

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
                $videoSlide->setPosition(1);

                $technic->addSlide($videoSlide);
                $manager->persist($videoSlide);
                $manager->flush();

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

            return $this->render('technic/show.html.twig', [
                'technic' => $technic,
                "addImageForm" => $addImageForm->createView(),
                "addVideoForm" => $addVideoForm->createView(),
            ]);

        }

        return $this->render('technic/show.html.twig', [
            'technic' => $technic,
        ]);

    }



    /**
     * @Route("/technics/index", name="index_technics")
     */
    public function index(EntityManagerInterface $manager): Response
    {

        // last 30 inserted projects presentations

        $technics = $manager->createQuery('SELECT t FROM App\Entity\Technic t WHERE t.isAdminValidated=true ORDER BY t.createdAt DESC')->setMaxResults('30')->getResult();

        return $this->render('technic/index.html.twig', [
            'technics' => $technics,
        ]);

    }




}
