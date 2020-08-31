<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="ps_contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer, TranslatorInterface $translator)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $contactFormData = $form->getData();
            $message = (new \Swift_Message('You Got Mail from your blog !'))
                ->setFrom($contactFormData['from'])
                ->setSubject($contactFormData['subject'])
                ->setTo('benkhadajmiaga2020@gmail.com')
                ->setBody(
                    $contactFormData['message'],
                    'text/plain'
                )
            ;

            $mailer->send($message);

            $msg = $translator->trans('Your message has been sent successfully
            ');

            $this->addFlash('success', $msg);
            
            return $this->redirectToRoute('ps_contact');

        }

        return $this->render('contact.html.twig', [
            'email_form' => $form->createView(),
        ]);
    }
}
