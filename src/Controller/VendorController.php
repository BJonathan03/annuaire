<?php

namespace App\Controller;

use App\Entity\Vendor;
use App\Entity\Visitor;
use App\Form\VendorType;
use App\Repository\LocalityRepository;
use App\Repository\ServiceRepository;
use App\Repository\VendorRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class VendorController extends AbstractController
{



    public function listingVendors(VendorRepository $repo)
    {
        $vendors = $repo->findAll();
        return $this->render('vendor/liste_vendor.html.twig', [
            'vendors' => $vendors
        ]);
    }

    /**
     *
     * Cette fonction renvoie le listing des vendeurs
     *
     * @Route("/vendors", name="vendors")
     */
    public function listing(PaginatorInterface $paginator, Request $request, VendorRepository $repo, LocalityRepository $repo1, ServiceRepository $repo2)
    {
        $vendors = $repo->findAll();
        $locality = $repo1->findAll();
        $category = $repo2->findAll();

        $result = $paginator->paginate(
            $vendors,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        return $this->render('vendor/liste.html.twig', [
            'controller_name' => 'VendorController',
            'vendors' => $result,
            'locality' => $locality,
            'services' => $category

        ]);
    }

    /**
     * @Route("/search", name="search")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function search(PaginatorInterface $paginator, Request $request){
     /*   $name = $request->query->get('name') ?? null;
        // $locality = $request->query->get('locality') ?? null;
        $search_name = $this->getRepo()->findVendor($name);
        return $this->render('vendor/search.html.twig', [
            'controller_name' => 'vendorController',
            'vendors' => $search_name
        ]);*/


            /** @var VendorRepository $repository */
            $searchName = $request->get('search_name');
            $searchLocality = $request->get('search_locality');
            $searchCategory = $request->get('search_category');

            $repository = $this->getDoctrine()->getRepository(Vendor::class);
            $vendors = $paginator->paginate(
                $repository->findByNameCpCategory($searchName, $searchCategory, $searchLocality),
                $request->query->getInt('page', 1)/*page number*/,
                6/*limit per page*/
            );
            return $this->render('vendor/search.html.twig', [
                'controller_name' => 'vendorController',
                'vendors' => $vendors,
            ]);
    }

    /**
     * @Route("/vendors/{id}", name="vendor_show")
     */

    public function show(Vendor $vendor){
        return $this->render('vendor/show.html.twig', [
            'controller_name' => 'VendorController',
            'vendor'=> $vendor
        ]);
    }


    public function getRepo():VendorRepository
    {
        /**@var VendorRepository $vr */
        $vr = $this->getDoctrine()->getRepository(Vendor::class);
        return $vr;
    }


}
