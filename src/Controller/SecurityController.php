<?php

namespace App\Controller;

use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;



class SecurityController extends AbstractController
{
   public function registration()
   {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
            ]);
   }
}
