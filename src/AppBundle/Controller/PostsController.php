<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PostsController
 * @package AppBundle\Controller
 *
 * @Route("/posts")
 */
class PostsController extends Controller
{
    /**
     * @Route("/", name="get_posts")
     * @Template
     *
     * @param Request $request
     */
    public function indexAction()
    {
        $context = [
            'posts' => $this->getDoctrine()->getRepository(Post::class)->findAll(),
            'authors' => $this->getDoctrine()->getRepository(Author::class)->findAll(),
        ];

        return $context;
    }

    /**
     * @Route("/put", name="put_post", methods={"post"})
     *
     * @param Request $request
     */
    public function putPostAction(Request $request)
    {
        $post = new Post();
        $post->setTitle($request->request->get('title'));
        $post->setBody($request->request->get('body'));

        $author = $this->getDoctrine()->getRepository(Author::class)->find($request->request->get('author'));
        $post->setAuthor($author);

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        return $this->redirectToRoute('get_posts');
    }
}