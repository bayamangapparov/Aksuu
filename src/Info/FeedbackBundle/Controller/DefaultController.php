<?php

namespace Info\FeedbackBundle\Controller;

use Info\FeedbackBundle\Entity\Feedback;
use Info\FeedbackBundle\Form\FeedbackType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $entity = new Feedback();
        $form = $this->createForm(new FeedbackType(), $entity);

        $form->handleRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();


            $message = \Swift_Message::newInstance()
                ->setSubject('Письмо в обратную связь')
                ->setFrom($this->container->getParameter('email_from'))
                ->setTo($this->container->getParameter('email_to'))
                ->setBody(
					$this->getMessage($entity),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);

            return $this->render('InfoFeedbackBundle:Default:sended.html.twig');
        }

        return $this->render('InfoFeedbackBundle:Default:index.html.twig', array(
            "form"  => $form->createView()
        ));
    }
	public function getMessage(Feedback $entity)
	{
		return "Сообщение от ".$entity->getEmail().", \n".$entity->getMessage();
	}
}
