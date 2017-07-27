<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Entity\Post;
use AppBundle\Entity\Tag;
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
            'tags' => $this->getDoctrine()->getRepository(Tag::class)->findAll(),
        ];

        return $context;
    }

    /**
     * @Route("/post", name="post_post", methods={"post"})
     *
     * @param Request $request
     */
    public function postPostAction(Request $request)
    {
        $post = new Post();
        $post->setTitle($request->request->get('title'));
        $post->setBody($request->request->get('body'));

        $author = $this->getDoctrine()->getRepository(Author::class)->find($request->request->get('author'));
        $post->setAuthor($author);

        if ($request->request->get('tags')) {
            $tags = $this->getDoctrine()->getRepository(Tag::class)->findBy(['id' => $request->request->get('tags')]);
            $post->setTags($tags);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        return $this->redirectToRoute('get_posts');
    }

    /**
     * @Route("/delete/{post}", name="delete_post")
     *
     * @param Post $post
     */
    public function deletePostAction(Post $post)
    {
        $this->getDoctrine()->getManager()->remove($post);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('get_posts');
    }
}