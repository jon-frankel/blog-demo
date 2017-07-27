<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TagsController
 * @package AppBundle\Controller
 *
 * @Route("/tags")
 */
class TagsController extends Controller
{
    /**
     * @Route("/put", name="put_tag")
     *
     * @param Request $request
     */
    public function putTagAction(Request $request)
    {
        $tag = new Tag($request->request->get('name'));
        $this->getDoctrine()->getManager()->persist($tag);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('get_posts');
    }
}