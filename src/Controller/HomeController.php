<?php

namespace App\Controller;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * Undocumented function
     *
     * @Route("/", name="homepage")
     */
    public function home()
    {
        return $this->render('home.html.twig');
    }
    /**
     * Undocumented function
     *
     * @Route("/tarifs", name="tarifs_page")
     */
    public function tarifs()
    {
        return $this->render('taarifs.html.twig');
    }
    /**
     * @Route("/paiment-base", name="pai_base")
     *
     *
     */
    public function base(Request $request)
    {
        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey(
            'sk_test_51HIZ48Gv6xRvjguquFiunIY3604SeD56Y5AgB4srK5lwMQTCevh4hB40Bc0k7OutfPhfGD3ktxZpYS2SEVFHkcEa00osjq5jj8'
        );

        $intent = \Stripe\PaymentIntent::create([
            'amount' => 4900,
            'currency' => 'eur',
            // Verify your integration in this guide by including this parameter
            'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);

        return $this->render('paiement.html.twig');
    }



    /**
     * @Route("/paiment-plus", name="pai_plus")
     *
     *
     */
    public function plus(Request $request)
    {
        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey(
            'sk_test_51HIZ48Gv6xRvjguquFiunIY3604SeD56Y5AgB4srK5lwMQTCevh4hB40Bc0k7OutfPhfGD3ktxZpYS2SEVFHkcEa00osjq5jj8'
        );

        $intent = \Stripe\PaymentIntent::create([
            'amount' => 14900,
            'currency' => 'eur',
            // Verify your integration in this guide by including this parameter
            'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);

        return $this->render('paiement.html.twig');
    }
 /**
     * @Route("/paiment-prem", name="pai_prem")
     *
     *
     */
    public function premium(Request $request)
    {
        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey(
            'sk_test_51HIZ48Gv6xRvjguquFiunIY3604SeD56Y5AgB4srK5lwMQTCevh4hB40Bc0k7OutfPhfGD3ktxZpYS2SEVFHkcEa00osjq5jj8'
        );

        $intent = \Stripe\PaymentIntent::create([
            'amount' => 19900,
            'currency' => 'eur',
            // Verify your integration in this guide by including this parameter
            'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);

        return $this->render('paiement.html.twig');
    }


    
}
