<?php
/**
 * Created by PhpStorm.
 * User: busti
 * Date: 22-02-19
 * Time: 22:20
 */

namespace App\Controller;


use App\Entity\Register;
use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/service", name="admin_service")
     * @Security("is_granted('ROLE_ADMIN')", message="Seul l'administrateur peut accéer à cette partie du sîte !")
     * @IsGranted("ROLE_ADMIN")
     */

    public function gestionService(ServiceRepository $repo){
        $services = $repo->findAll();

        return $this->render('admin/service.html.twig', [
            'services' => $services,
        ]);
    }

    /**
     * @Route("/admin/service/{id}", name="admin_service_update")
     * @Security("is_granted('ROLE_ADMIN')", message="Seul l'administrateur peut accéer à cette partie du sîte !")
     */

    public function formservice(Service $service, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            //persist n'est pas obligatoire car l'entité existe déjà
            $manager->persist($service);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les données du profile ont été enregistrées avec succès !"
            );
        }

        return $this->render('admin/update_service.html.twig', [
            'form' => $form->createView()
        ]);
    }
}