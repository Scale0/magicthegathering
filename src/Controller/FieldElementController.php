<?php

namespace App\Controller;

use App\Entity\FieldElement;
use App\Form\FieldElementType;
use App\Repository\FieldElementRepository;
use App\Service\MapService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/field/element")
 */
class FieldElementController extends AbstractController
{
    private $mapService;

    public function __construct(MapService $mapService)
    {
        $this->mapService = $mapService;
    }

    /**
     * @Route("/", name="field_element_index", methods={"GET"})
     * @param FieldElementRepository $fieldElementRepository
     *
     * @return Response
     */
    public function index(FieldElementRepository $fieldElementRepository): Response
    {
        $tiles = $this->mapService->generate();
        $fieldElements = [];
        for ($i = 1; $i <= max(array_keys($tiles)); $i++) {
            if (array_key_exists($i, $tiles)) {
                for ($j = 1; $j <= max(array_keys($tiles[$i])); $j++) {
                    if (array_key_exists($j, $tiles[$i])) {
                        $fieldElements[$i][$j] =
                            [
                                'path' => 'field_element_edit',
                                'id' => $tiles[$i][$j]['id'],
                                'symbol' => $tiles[$i][$j]['symbol']
                            ];
                    } else {
                        $fieldElements[$i][$j] =
                            ['path' => 'field_element_new'];
                    }
                }
                $fieldElements[$i][$j] = ['path' => 'field_element_new'];
            }
        }
        for ($k = 1; $k <= $j; $k++) {
            $fieldElements[$j][$k] = ['path' => 'field_element_new'];
        }

        return $this->render(
            'field_element/index.html.twig',
            [
                'field_elements' => $fieldElements,
                'empty_tile' => $this->mapService->getEmptyTile()->getSymbol()
            ]
        );
    }

    /**
     * @Route("/new", name="field_element_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $fieldElement = new FieldElement();
        $form = $this->createForm(FieldElementType::class, $fieldElement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()
                ->getManager()
            ;
            $entityManager->persist($fieldElement);
            $entityManager->flush();

            return $this->redirectToRoute('field_element_index');
        }
        if ($request->query->has('x') && $request->query->has('y')) {
            $fieldElement->setX((int) $request->query->get('x'));
            $fieldElement->setY((int) $request->query->get('y') ?? '');
            $fieldElement->setFieldType($this->mapService->getEmptyTile());
            $form = $this->createForm(FieldElementType::class, $fieldElement);
        }

        return $this->render(
            'field_element/new.html.twig',
            [
                'field_element' => $fieldElement,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="field_element_show", methods={"GET"})
     * @param FieldElement $fieldElement
     *
     * @return Response
     */
    public function show(FieldElement $fieldElement): Response
    {
        return $this->render(
            'field_element/show.html.twig',
            [
                'field_element' => $fieldElement,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="field_element_edit", methods={"GET","POST"})
     * @param Request      $request
     * @param FieldElement $fieldElement
     *
     * @return Response
     */
    public function edit(Request $request, FieldElement $fieldElement): Response
    {
        $form = $this->createForm(FieldElementType::class, $fieldElement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush()
            ;

            return $this->redirectToRoute('field_element_index');
        }

        return $this->render(
            'field_element/edit.html.twig',
            [
                'field_element' => $fieldElement,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="field_element_delete", methods={"DELETE"})
     * @param Request      $request
     * @param FieldElement $fieldElement
     *
     * @return Response
     */
    public function delete(Request $request, FieldElement $fieldElement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fieldElement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()
                ->getManager()
            ;
            $entityManager->remove($fieldElement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('field_element_index');
    }
}
