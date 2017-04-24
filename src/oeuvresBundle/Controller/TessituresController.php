<?php

namespace oeuvresBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use oeuvresBundle\Entity\Tessitures;

/**
 * Tessitures controller.
 *
 * @Route("/tessitures")
 */
class TessituresController extends Controller
{

    /**
     * Lists all Tessitures entities.
     *
     * @Route("/", name="tessitures")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('oeuvresBundle:Tessitures')->findAll();

        return $this->render('oeuvresBundle:Avancements:index.html.twig', array(
        		'entities' => $entities,
        ));
        
        /*
        return array(
            'entities' => $entities,
        );
        */
    }
    public function legendeAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$entities = $em->getRepository('oeuvresBundle:Tessitures')->findAll();
    	
    	return $this->render('oeuvresBundle:Avancements:legende.html.twig', array(
    			'entities' => $entities,
    	));
    }

    /**
     * Finds and displays a Tessitures entity.
     *
     * @Route("/{id}", name="tessitures_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('oeuvresBundle:Tessitures')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tessitures entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
}
