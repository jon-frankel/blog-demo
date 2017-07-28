<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Author;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthorsController
 * @package AppBundle\Controller
 *
 * @Route("/authors")
 */
class AuthorsController extends Controller
{
    /**
     * @Route("/post", name="post_author", methods={"post"})
     *
     * @param Request $request
     */
    public function putAuthorAction(Request $request)
    {
        $author = new Author();
        $author->setName($request->request->get('name'));
        if ($request->request->get('publisher')) {
            $author->setPublisher($request->request->get('publisher'));
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($author);
        $em->flush();

        return $this->redirectToRoute('get_posts');
    }
}