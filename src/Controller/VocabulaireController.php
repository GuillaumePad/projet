<?php

namespace App\Controller;

use App\Entity\Vocabulaire;
use App\Form\VocabulaireType;
use App\Repository\VocabulaireRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class VocabulaireController extends AbstractController
{
    /**
     * @Route("/vocabulaire/detail/{id}", name="vocabulaire_detail")
     */
    public function detailFront($id, VocabulaireRepository $vocabulaireRepository):Response{
        return $this->render("vocabulaire/detail.html.twig", [
            "vocabulaire"=>$vocabulaireRepository->find($id)]);
    }

    /**
     * @Route("/admin/vocabulaire", name="vocabulaire_index", methods={"GET"})
     */
    public function index(VocabulaireRepository $vocabulaireRepository): Response
    {
        return $this->render('vocabulaire/index.html.twig', [
            'vocabulaires' => $vocabulaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/vocabulaire", name="dico")
     */
    public function dicp(VocabulaireRepository $vocabulaireRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $vocabulaires=$vocabulaireRepository->findBy(['active'=>1], ["kana"=>"ASC"]);
        $pagination = $paginator->paginate(
            $vocabulaires, // Les données à paginer
            $request->query->getInt('page', 1), // le numéro de la page
            5 // le nombre par page
        );
        return $this->render('vocabulaire/index-front.html.twig', [
            'vocabulaires' => $pagination,
        ]);
    }
    /**
     * @Route("/vocabulaire/new", name="vocabulaire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $vocabulaire = new Vocabulaire();
        $form = $this->createForm(VocabulaireType::class, $vocabulaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vocabulaire);
            $entityManager->flush();

            return $this->redirectToRoute('vocabulaire_index');
        }

        return $this->render('vocabulaire/new.html.twig', [
            'vocabulaire' => $vocabulaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/vocabulaire/{id}", name="vocabulaire_show", methods={"GET"})
     */
    public function show(Vocabulaire $vocabulaire): Response
    {
        return $this->render('vocabulaire/show.html.twig', [
            'vocabulaire' => $vocabulaire,
        ]);
    }

    /**
     * @Route("/vocabulaire/{id}/edit", name="vocabulaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vocabulaire $vocabulaire): Response
    {
        $form = $this->createForm(VocabulaireType::class, $vocabulaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vocabulaire_index');
        }

        return $this->render('vocabulaire/edit.html.twig', [
            'vocabulaire' => $vocabulaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/vocabulaire/{id}", name="vocabulaire_delete", methods={"POST"})
     */
    public function delete(Request $request, Vocabulaire $vocabulaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vocabulaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vocabulaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vocabulaire_index');
    }
}
