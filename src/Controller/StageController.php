<?php

namespace App\Controller;



use App\Entity\Stage;
use App\Entity\Vendor;
use App\Form\StageType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class StageController extends AbstractController
{

    /**
     * Permet de modifier le mot de passe
     *
     * @Route("/security/vendor/stage", name="vendor_stage")
     *
     */
    public function stage(Request $request, ObjectManager $manager)
    {

        $stage = new Stage();

        $user = $this->getUser();

        $form = $this->createForm(StageType::class, $stage);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $stage->setVendor($user);

            $manager->persist($stage);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre stage a bien été ajouté..."
            );
            return $this->redirectToRoute('home');

        }
        return $this->render('security_vendor/stage.html.twig', [
            'form' => $form->createView(),
            'vendor' => $user
        ]);
    }

    /**
     * @param Stage $stage
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("stage/delete/{id}", name="stage_delete")
     *
     * @Security("is_granted('ROLE_USER') and user === stage.getVendor()", message="Vous n'avez pas le droit d'accéder à cette ressource !")
     */

    public function stageDelete(Stage $stage)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($stage);
        $em->flush();
        $this->addFlash('success', 'Stage supprimé');
        return $this->redirectToRoute('vendor_stage');
    }

}