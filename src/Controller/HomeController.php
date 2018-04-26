<?php

namespace App\Controller;

use App\Repository\AdsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home", methods="GET")
     */
    public function index(AdsRepository $adsRepository) : Response
    {
        return $this->render('home/index.html.twig', ['ads' => $adsRepository->findAll()]);
    }

}
