<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\Comments;
use AppBundle\Form\CommentType;

class BlogController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AppBundle:Post')->fetchAllActivePosts();

        return $this->render('AppBundle:Blog:index.twig.html', array(
            'posts' => $posts,
        ));
    }

    public function postAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AppBundle:Post')->fetchActivePostById($id);

        if(!$post) {
            throw new NotFoundHttpException( 'Invalid id. Try again' );
        }

        $comment = new Comments();
        $form = $this->createCommentForm($id, $comment);

        return $this->render('AppBundle:Blog:show.twig.html', array(
            'post' => $post[0],
            'comments' => $this->getComments($id),
            'form' => $form->createView(),
        ));
    }

    public function postCommentAction($postId)
    {
        $comment = new Comments();
        $form = $this->createCommentForm($postId, $comment);
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $comment->setPost($em->getRepository('AppBundle:Post')->findOneById($postId));
            $em->persist($comment);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('post_details', array('id' => $postId)));
    }

    private function getComments($postId)
    {
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository('AppBundle:Comments')->findAllCommentsByPostId($postId);
        return $comments;
    }

    private function createCommentForm($id, Comments $comment)
    {
        $form = $this->createForm(new CommentType(), $comment, array(
            'action' => $this->generateUrl('post_comment', array('postId'=> $id)),
            'method' => 'POST',
        ));
       
        return $form;
    }
}