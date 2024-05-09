<?php

namespace App\Controller;

use App\Entity\Medal;
use App\Entity\Nation;
use App\Form\MedalType;
use App\Form\NationSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MedalController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(EntityManagerInterface $em): Response
    {
        $top3 = $em->getRepository(Medal::class)->findTop3MedalNation();
        $nationOr = $em->getRepository(Nation::class)->find($top3[0]['nation_id']);
        $nationArgent = $em->getRepository(Nation::class)->find($top3[1]['nation_id']);
        $nationBronze = $em->getRepository(Nation::class)->find($top3[2]['nation_id']);

        $or = [
            'nation' => $nationOr,
            'total' => $top3[0]['total'],
        ];
        $argent = [
            'nation' => $nationArgent,
            'total' => $top3[1]['total'],
        ];
        $bronze = [
            'nation' => $nationBronze,
            'total' => $top3[2]['total'],
        ];

        return $this->render('medal/home.html.twig', [
            'or'        => $or,
            'argent'    => $argent,
            'bronze'    => $bronze,
        ]);
    }

    #[Route('/medal', name: 'app_form_medal')]
    public function form(EntityManagerInterface $em, Request $request): Response
    {
        $medal = new Medal();

        $form = $this->createForm(MedalType::class, $medal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($medal);
            $em->flush();

            $this->addFlash('success', 'La médaille a bien été ajoutée.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('medal/form.html.twig', [
            'medalForm' => $form->createView(),
        ]);
    }

    #[Route('/nation/{nation}', name: 'app_nation')]
    public function nation(Nation $nation): Response
    {
        return $this->render('medal/nation.html.twig', [
            'nation' => $nation,
        ]);
    }

    #[Route('/search', name: 'app_search')]
    public function search(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $form = $this->createForm(NationSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $nation = $em->getRepository(Nation::class)->findOneBy([
                'name' => $form->get('name')->getData(),
            ]);

            if ($nation) {
                return $this->redirectToRoute('app_nation', ['nation' => $nation->getId()]);
            }

            $this->addFlash('danger', sprintf(
                'Aucune nation trouvée avec le nom "%s".',
                $form->get('name')->getData()
            ));
            return $this->redirectToRoute('app_home');
        }

        return $this->render('medal/search.html.twig', [
            'searchForm' => $form->createView(),
        ]);
    }
}
