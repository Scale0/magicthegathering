<?php

namespace App\Controller;

use App\Entity\FieldType;
use App\Form\FieldTypeType;
use App\Repository\FieldTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/field/type")
 */
class FieldTypeController extends AbstractController
{
    /**
     * @Route("/", name="field_type_index", methods={"GET"})
     */
    public function index(FieldTypeRepository $fieldTypeRepository): Response
    {
        return $this->render('field_type/index.html.twig', [
            'field_types' => $fieldTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="field_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $fieldType = new FieldType();
        $form = $this->createForm(FieldTypeType::class, $fieldType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fieldType);
            $entityManager->flush();

            return $this->redirectToRoute('field_type_index');
        }

        return $this->render('field_type/new.html.twig', [
            'field_type' => $fieldType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="field_type_show", methods={"GET"})
     */
    public function show(FieldType $fieldType): Response
    {
        return $this->render('field_type/show.html.twig', [
            'field_type' => $fieldType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="field_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FieldType $fieldType): Response
    {
        $form = $this->createForm(FieldTypeType::class, $fieldType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('field_type_index');
        }

        return $this->render('field_type/edit.html.twig', [
            'field_type' => $fieldType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="field_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, FieldType $fieldType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fieldType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fieldType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('field_type_index');
    }
}
