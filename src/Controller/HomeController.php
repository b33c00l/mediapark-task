<?php

namespace App\Controller;

use App\Entity\Ads;
use App\Repository\AdsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @var AdsRepository
     */
    private $adsRepository;


    public function __construct(AdsRepository $adsRepository)
    {
        $this->adsRepository = $adsRepository;
    }

    /**
     * @Route("/", name="home", methods="GET")
     */
    public function index(Request $request) : Response
    {
        $page = $request->query->get('page', 1);
        $perPage = 5;
        $ads = $this->adsRepository->getAllForPage($page, $perPage);
        $total = count($this->adsRepository->findAll());
        $pages = ceil($total/$perPage);

        return $this->render('home/index.html.twig', [
            'ads' => $ads,
            'pages' => $pages
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods="GET")
     */
    public function show(Ads $ad): Response
    {
        return $this->render('home/show.html.twig', ['ad' => $ad]);
    }

}
