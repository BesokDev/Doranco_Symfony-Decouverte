<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// extends : mot-clé pour hériter les méthodes de la class AbstractController
class DefaultController extends AbstractController
{
    // Dans une class dans symfony, il y aura très souvent deux parties:
    // (une class (php) est un objet, et ça ne peut contenir que des propriétés et des méthodes.)
    /*
     * 1 partie : déclaration et initialisation des propriétés (de la class)
     * 2 ème partie : déclaration et initialisation des méthodes (de la class)
    */


    // les fonctions sont appelées "action"
    /**
     * @Route("/accueil", name="show_home", methods={"GET"})
     */
    public function home(EntityManagerInterface $entityManager): Response
    {

        $employes = $entityManager->getRepository(Employe::class)->findAll();

        // $this = la class elle-même
        // render() -> méthode de AbstractController
        return $this->render('default/home.html.twig', [
            'employes' => $employes
        ]);
    }

    /**
     * @Route("/requete", name="default_request", methods={"GET"})
     */
    public function request(Request $request)
    {
        // dd() = fonction de debug (dump and die)
        dd($request);
    }

    /**
     * Cette action nous permet d'afficher un formulaire ET d'exécuter son traitement.
     * Nous avons injecté 2 dépendances : Request et EntityManagerInterface => cela nous permet d'utiliser ces objets dans notre fonction (action)
     *
     * @Route("/creer-employe", name="create_employe", methods={"GET|POST"})
     */
    public function createEmploye(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Instanciation d'un nouvel objet de type Employe()
        $employe = new Employe();

        // Variabilisation de notre type de formulaire à partir de la class créée précédemmment.
        $form = $this->createForm(EmployeFormType::class, $employe);
        // handleRequest() nous permet de récupérer les données du formulaire automatiquement.
        $form->handleRequest($request);

        // Condition de vérification de l'état du formulaire et sa validité
        if($form->isSubmitted() && $form->isValid()) {

            // la méthode persist() permet d'insérer en BDD les données contenues dans $employe
            $entityManager->persist($employe);

            // la méthode flush() DOIT ABSOLUMENT suivre après un persist().
                    // Elle permet de vider $entityManager pour la prochaine insertion en BDD.
            $entityManager->flush();

            // Le traitement du formulaire est terminé.
                // On redirige à ce moment-là l'utilisateur sur la page d'accueil
            return $this->redirectToRoute('show_home');
        }

        return $this->render('form/create_employe.html.twig', [
            // Tableau de paramètres [] : ici on 'passe' notre Form à notre vue
            'form' => $form->createView()
        ]);
    } // END function

    /**
     * @Route("/modifier-un-employe/{id}", name="update_employe", methods={"GET|POST"})
     */
    public function updateEmploye(
        Employe $employe,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {

        // Variabilisation de notre type de formulaire à partir de la class créée précédemmment.
        $form = $this->createForm(EmployeFormType::class, $employe);
        // handleRequest() nous permet de récupérer les données du formulaire automatiquement.
        $form->handleRequest($request);

        // Condition de vérification de l'état du formulaire et sa validité
        if($form->isSubmitted() && $form->isValid()) {

            // la méthode persist() permet d'insérer en BDD les données contenues dans $employe
            $entityManager->persist($employe);

            // la méthode flush() DOIT ABSOLUMENT suivre après un persist().
            // Elle permet de vider $entityManager pour la prochaine insertion en BDD.
            $entityManager->flush();

            // Le traitement du formulaire est terminé.
            // On redirige à ce moment-là l'utilisateur sur la page d'accueil
            return $this->redirectToRoute('show_home');
        }

        return $this->render('form/create_employe.html.twig', [
            // Tableau de paramètres [] : ici on 'passe' notre Form à notre vue
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/supprimer-un-employe/{id}", name="delete_employe", methods={"GET"})
     */
    public function deleteEmploye(Employe $employe, EntityManagerInterface $entityManager): RedirectResponse
    {
        $entityManager->remove($employe);

        // On doit flush() pour supprimer en BDD
        $entityManager->flush();

        return $this->redirectToRoute('show_home');
    }

    /**
     * @Route("/voir-un-employe/{id}", name="show_employe", methods={"GET"})
     */
    public function showEmploye(Employe $employe): Response
    {
//        $entityManager->getRepository(Employe::class)->findBy(['id' => $employe->getId()]);

        return $this->render('default/show_employe.html.twig', [
            'employe' => $employe
        ]);
    }
} // END class