<?php

namespace Intro\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Intro\MainBundle\Entity\Enquiry;
use Intro\MainBundle\Form\EnquiryType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IntroMainBundle:Post')->findOneByTitle('Título');
        
        return array();
    }
    
    /**
     * @Route("/about")
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }

    /**
     * @Route("/contact")
     * @Template()
     */
    public function contactAction(Request $request)
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);
        
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $all = $request->request->all();

                $a = $request->get("contact")["name"];
                $b = $request->get("contact")["subject"];
                $sum = $this->add($a, $b);
                // Perform some action, such as sending an email

                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                
//                return $this->redirect($this->generateUrl('intro_main_default_index'), array('enquiry' => $enquiry));
                return array(
                    'enquiry' => $enquiry,
                    'sum' => $sum
                );
            }
        }

        return array(
            'form' => $form->createView()
        );
    }
    
    public function add($a, $b)
    {
        return $a + $b;
    }
}
