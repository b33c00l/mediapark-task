<?php

namespace App\Controller;

use App\Entity\Ads;
use App\Entity\User;
use App\Form\AdsType;
use App\Repository\AdsRepository;
use DateTime;
use DateTimeNow;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/ads")
 */
class AdsController extends Controller
{
    /**
     * @Route("/", name="ads_index", methods="GET")
     */
    public function index(AdsRepository $adsRepository, UserInterface $user ): Response
    {

//        $ads = $adsRepository->findAll();
//        dump($user->getAds());
//        exit;
        return $this->render('ads/index.html.twig', ['ads' => $user->getAds()]);
    }

    /**
     * @Route("/new", name="ads_new", methods="GET|POST")
     */
    public function new(Request $request, UserInterface $user
    ): Response
    {
        $ad = new Ads();
        $form = $this->createForm(AdsType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ad->setDate(new Datetime);
            $ad->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($ad);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('ads/new.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ads_show", methods="GET")
     */
    public function show(Ads $ad): Response
    {
        return $this->render('ads/show.html.twig', ['ad' => $ad]);
    }

    /**
     * @Route("/{id}/edit", name="ads_edit", methods="GET|POST")
     */
    public function edit(Request $request, Ads $ad): Response
    {
        $form = $this->createForm(AdsType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ads_index', ['id' => $ad->getId()]);
        }

        return $this->render('ads/edit.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ads_delete", methods="DELETE")
     */
    public function delete(Request $request, Ads $ad): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ad->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ad);
            $em->flush();
        }

        return $this->redirectToRoute('ads_index');
    }
}
