<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)
    {
        //$repo =$this->getDoctrine()->getRepository(Ad::class);//permet de parler avec le moteur de doctrine
        $ads = $repo->findBy(array(), array('date_pub' => 'desc'));
        return $this->render('ad/index.html.twig', [
            'ads' => $ads,

        ]);
    }
      /**
     * Permet de créer une annonce
     * @Route("/ads/new",name="ads_create")
     * @return Response
     */
    public function create(Request $request,  EntityManagerInterface $manager)
    {

        $ad = new Ad();
        $form = $this->createForm(AdType::class,$ad);
        $form->handleRequest($request); 
        $ad->initializeSlug();   
        if($form->isSubmitted() && $form->isValid())
        {
            foreach($ad->getImages() as $image)
            {
                $image->setAd($ad);//pour dire chaque image lié à une annonce
                $manager->persist($image);
            }
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong> {$ad->getTitle()} </strong> a bien été enregistrée !"
            );
            
            return $this->redirectToRoute('ads_show',[
                'slug' => $ad->getSlug()
            ]);

        } 
        return $this->render('ad/new.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * Permet d'afficher une seul annonce 
     * @Route("/ads/{slug}", name="ads_show")
     * @return Response
     */
    public function show($slug, AdRepository $repo)
    {
        //Je récupere l'annonce qui correspond au slug
        $ad=$repo->findOneBySlug($slug);//il nous envois un tableau on utilisant la functiono findBySlug
        return $this->render('ad/show.html.twig', [
            'ad' => $ad,
        ]);
    }

     /**
     * Permet d'afficher le formulaire d'édition
     *
     * @Route("/ads/{slug}/edit", name="ads_edit")
     * 
     * 
     * @return Response
     */
    public function edit(Ad $ad, Request $request, EntityManagerInterface $manager){

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            foreach($ad->getImages() as $image)
            {
                $image->setAd($ad);//pour dire chaque image lié à une annonce
                $manager->persist($image);
            }
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les modifications de l'annonce <strong> {$ad->getTitle()} </strong> ont  été enregistrées !"
            );
            
            return $this->redirectToRoute('ads_show',[
                'slug' => $ad->getSlug()
            ]);

        } 

        return $this->render('ad/edit.html.twig', [
            'form' => $form->createView(),
            'ad' => $ad
        ]);
    }


    
  
}
