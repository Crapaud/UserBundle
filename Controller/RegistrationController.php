<?php

namespace Cornichon\UserBundle\Controller;

use Cornichon\UserBundle\Form\UserSignupType;
use Cornichon\UserBundle\Entity\User;
use Cornichon\UserBundle\Entity\UserGroup;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegistrationController extends Controller
{

    public function signupAction()
    {
        $request = $this->getRequest();

        $user = new User();

        $form = $this->createForm(new UserSignupType(), $user);

        if ($request->getMethod() === 'POST') {
            $form->bind($request);
            if ($form->isValid() === true) {
                $em = $this->get('doctrine')->getEntityManager();

                $factory = $this->container->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($password);

                $group = $em->getRepository('CornichonUserBundle:UserGroup')
                            ->findOneBy(array('role' => 'ROLE_USER'));
                     
                if (false === $group instanceof UserGroup) {
                    throw new \RuntimeException("No User Role");
                }

                $user->addGroup($group);

                $em->persist($user);
                $em->flush();

                $this->redirect("/");
            }
        }

        return $this->render('CornichonUserBundle:Security:signup.html.twig', array(
            'form' => $form->createView()
        ));
    }
}