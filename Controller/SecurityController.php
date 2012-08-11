<?php

namespace Cornichon\UserBundle\Controller;

use Cornichon\UserBundle\Form\UserSignupType;
use Cornichon\UserBundle\Entity\User;
use Cornichon\UserBundle\Entity\UserGroup;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('CornichonUserBundle:Security:login.html.twig', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }

    public function signupAction()
    {
        $request = $this->getRequest();

        $user = new User();

        $form = $this->createForm(new UserSignupType(), $user);

        if ($request->getMethod() === 'POST') {
            $form->bind($request);
            if ($form->isValid() === true) {

            }
        }

        return $this->render('CornichonUserBundle:Security:signup.html.twig', array(
            'form' => $form->createView()
        ));
    }
}