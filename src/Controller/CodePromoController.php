<?php

namespace App\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\CodePromo;
use App\Form\CodePromoType;
use MercurySeries\Flashy\FlashyNotifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/code/promo")
 */
class CodePromoController extends AbstractController
{
    /**
     * @Route("/", name="app_code_promo_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,Request $request , PaginatorInterface $paginator): Response
    {


        $codePromos = $entityManager
            ->getRepository(CodePromo::class)
            ->findAll();
        $codePromos = $paginator->paginate(
            $codePromos,
            $request->query->getInt('page',1),
            4
        );

        return $this->render('code_promo/index.html.twig', [
            'code_promos' => $codePromos,
        ]);
    }
    /**
     * @Route("/", name="redirection")
     */
    public function Redirection(): Response
    {


        return $this->render('code_promo/QR.html.twig', ['controller_name' => 'CodePromoController' ,
        ]);
    }

    /**
     * @Route("/new", name="app_code_promo_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $codePromo = new CodePromo();
        $form = $this->createForm(CodePromoType::class, $codePromo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($codePromo);
            $entityManager->flush();

            return $this->redirectToRoute('app_code_promo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('code_promo/new.html.twig', [
            'code_promo' => $codePromo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idCodepromo}", name="app_code_promo_show", methods={"GET"})
     */
    public function show(CodePromo $codePromo): Response
    {
        return $this->render('code_promo/show.html.twig', [
            'code_promo' => $codePromo,
        ]);
    }

    /**
     * @Route("/{idCodepromo}/edit", name="app_code_promo_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CodePromo $codePromo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CodePromoType::class, $codePromo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_code_promo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('code_promo/edit.html.twig', [
            'code_promo' => $codePromo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idCodepromo}", name="app_code_promo_delete", methods={"POST"})
     */
    public function delete(Request $request, CodePromo $codePromo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$codePromo->getIdCodepromo(), $request->request->get('_token'))) {
            $entityManager->remove($codePromo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_code_promo_index', [], Response::HTTP_SEE_OTHER);
    }
}
