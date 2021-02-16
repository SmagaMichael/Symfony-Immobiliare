<?php

namespace App\Controller;

use App\Entity\RealEstate;
use App\Services\SuperCart;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add(RealEstate $realEstate, SuperCart $superCart): Response
    {
        if($realEstate->getSold()){
            $this->addFlash('danger', 'Trop tard, l\'annonce est vendu');
        }else if($superCart->hasItem($realEstate->getId())){
            $this->addFlash('danger', 'Vous avez deja choisi cette annonce');
        }else{
            $superCart->addItem($realEstate);
        }


        //Ajouter l'annonce dans la session
        $superCart->addItem($realEstate);
        //Rediriger vers la page de l'annonce
        return $this->redirectToRoute('real_estate_show', [
           'id' => $realEstate->getId(),
           'slug' => $realEstate->getSlug(),
        ]);
    }

    /**
     * @Route ("/cart/remove/{id}", name="cart_remove")
     *
     */

    public function remove(realEstate $realEstate,  SuperCart $superCart){
       $superCart->removeItem($realEstate->getId());
       return $this->redirectToRoute('cart_index');
    }






    /**
     * @Route ("/cart", name="cart_index")
     *
     */

    public function index(SuperCart $superCart, $stripeKey){

        Stripe::setApiKey($stripeKey);

        $total = $superCart->total();
        if ($total >= 999999){
            $total = 999999;
        }


        $clientSecret = null;

        if ($total > 0){
            $paymentIntent = PaymentIntent::create([
                'amount' => $total * 100,
                'currency' => 'eur',
            ]);
            $clientSecret = $paymentIntent->client_secret;
        }




        return $this->render('cart/index.html.twig', [
            'items' => $superCart->getItems(),
            'clientSecret' => $clientSecret,
        ]);
    }

    /**
     * @Route("/cart/success/{id}", name="cart_success")
     */
    public function success($id, $stripeKey, SuperCart $superCart, MailerInterface $mailer){

        Stripe::setApiKey($stripeKey);


        $paymentIntent = PaymentIntent::retrieve($id);


        //Envoyer le mail...
        $email = (new Email())
            ->from('commande@immobiliare.com')
            ->to($this->getUser()->getEmail())
            ->subject('Votre commande')
            ->html($this->renderView('emails/order.html.twig', [
                'paymentIntent' => $paymentIntent,
                'cart' => $superCart,
                'user' => $this->getUser(),
            ]));

        $mailer->send($email);


        //Vider le panier
        $superCart->clear();

        return $this->render('cart/success.html.twig');
    }
}
