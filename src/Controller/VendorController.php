<?php

namespace App\Controller;

use App\Entity\Vendor;
use App\Entity\Visitor;
use App\Form\VendorType;
use App\Repository\LocalityRepository;
use App\Repository\VendorRepository;
use Doctrine\Common\Persistence\ObjectManager;
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
    public function listing(VendorRepository $repo, LocalityRepository $repo1)
    {
        $vendors = $repo->findAll();
        $locality = $repo1->findAll();
        return $this->render('vendor/liste.html.twig', [
            'controller_name' => 'VendorController',
            'vendors' => $vendors,
            'locality' => $locality,
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

    /**
     * @Route("/vendors/search", name="vendor_search")
     *
     */

    public function searchVendor(Request $request){
        $name = $request->query->get('name') ?? null;
        $locality = $request->query->get('locality') ?? null;

        $search_name = $this->getRepo()->findVendor($name, $locality);
        return $this->render('vendor/search.html.twig', [
            'controller_name' => 'vendorController',
            'vendors' => $search_name
        ]);
    }


    public function getRepo():VendorRepository
    {
        /**@var VendorRepository $vr */
        $vr = $this->getDoctrine()->getRepository(Vendor::class);
        return $vr;
    }


}
