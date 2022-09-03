<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="app_user")
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/user/show/{id}", name="app_user_show")
     */
    public function show(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/user/create", name="app_user_create")
     */
    public function create(Request $request)
    {
        $user = new User;
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('notice', 'User has been added successfully');
            return $this->redirectToRoute('app_user');
        }
        return $this->render('user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/update/{id}", name="app_user_update")
     */
    public function update(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('notice', 'User has been updated successfully');
            return $this->redirectToRoute('app_user');
        }
        return $this->render('user/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="app_user_delete")
     */
    public function delete(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        $this->addFlash('notice', 'User has been deleted successfully');
        return $this->redirectToRoute('app_user');
    }
}
