<?php

namespace App\Controller;

use App\Entity\Vendor;
use App\Repository\VendorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/vendors", name="vendors")
     */
    public function listing(VendorRepository $repo)
    {
        $vendors = $repo->findAll();
        return $this->render('vendor/liste.html.twig', [
            'controller_name' => 'VendorController',
            'vendors' => $vendors
        ]);
    }



    /**
     * @Route("/vendor/{id}", name="vendor_show")
     */

    public function show(VendorRepository $repo, Vendor $vendor){
        $vendors = $repo->findAll();
        return $this->render('vendor/show.html.twig', [
            'controller_name' => 'VendorController',
            'vendors' => $vendors,
            'vendor'=> $vendor
        ]);
    }

}
