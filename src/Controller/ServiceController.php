<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{


    public function listingServices(ServiceRepository $repo){

        $services = $repo->findAll();
        return $this->render('service/liste_service.html.twig', [
            'services' => $services
        ]);
    }

    public function imageDuMois(ServiceRepository $repo){

        $services = $repo->findOneBy(['front' => 1 ]);
        return $this->render('service/liste_image.html.twig', [
            'services' => $services
        ]);
    }


    /**
     * @Route("/", name="home")
     */

    public function index(ServiceRepository $repo)
    {
        $services = $repo->findAll();
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
            'services' => $services
        ]);
    }

    /**
     * @Route("/service", name="service")
     */
    public function listing(ServiceRepository $repo)
    {
        $services = $repo->findAll();
        return $this->render('service/liste.html.twig', [
            'controller_name' => 'ServiceController',
            'services' => $services
        ]);
    }

    /**
     * @Route("/service/{id}", name="service_show")
     */

    public function show(ServiceRepository $repo, Service $service){
        $services = $repo->findAll();
        return $this->render('service/show.html.twig', [
            'controller_name' => 'ServiceController',
            'services' => $services,
            'service'=> $service
        ]);
    }

}
