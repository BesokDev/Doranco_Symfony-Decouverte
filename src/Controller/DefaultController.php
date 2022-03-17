<?php

namespace App\Controller;

use App\Entity\Candidat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="show_home", methods={"GET"})
     */
    public function home(EntityManagerInterface $entityManager): Response
    {

        $candidats = $entityManager->getRepository(Candidat::class)->findAll();

        return $this->render('default/home.html.twig', [
            'candidats' => $candidats,
        ]);
    }

    /**
     * @Route("/creer-candidat", name="create_candidat", methods={"GET|POST"})
     */
    public function createCandidat(Request $request, EntityManagerInterface $entityManager): Response
    {

//{# ==========!!!========== CODE A EFFACER AVANT DE COMMENCER =========!!!========= #}//
        if( !file_exists($this->getParameter('form_dir') . '/CandidatFormType.php')) {
            $this->addFlash('warning', 'Il vous faut faire le formulaire <strong>CandidatFormType</strong> en ligne de commande, <strong>puis</strong> faire son traitement dans le <strong>DefaultController</strong>. À vos claviers ! Bon courage');
            return $this->redirectToRoute('show_home');
        }
        return $this->redirectToRoute('show_home');
//{# ==========!!!========== CODE A EFFACER AVANT DE COMMENCER =========!!!========= #}//



       # Faire le traitement ici (après avoir effacé le code ci-dessus



    } // END function

} // END class