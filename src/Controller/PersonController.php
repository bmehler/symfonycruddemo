<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    #[Route('/persons', name: 'persons')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $persons = $doctrine->getRepository(Person::class)->findAll();
        return $this->render('person/index.html.twig', ['persons' => $persons]);
    }

    #[Route('/person/new', name: 'person_new', methods: ['GET', 'POST'])]
    public function new(ManagerRegistry $doctrine, Request $request): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($person);
            $entityManager->flush();

            $this->addFlash(
                'new',
                'New Employee ' . $person->getFirstname() . ' ' . $person->getLastname() . ' added!'
            );
            return $this->redirectToRoute('persons');
        }

        return $this->renderForm('person/new.html.twig', [
            'person' => $person,
            'form' => $form,
        ]);

    }

    #[Route('/person/{id}', name: 'person_show', methods: ['GET'])]
    public function show(Person $person): Response
    {

        if (!$person) {
            throw $this->createNotFoundException(
                'No person found for id '.$id
            );
        }

        return $this->render('person/show.html.twig', ['person' => $person]);
    }

    #[Route('/person/edit/{id}', name: 'person_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Person $person, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($person);
            $entityManager->flush();

            $this->addFlash(
                'edit',
                'Employee ' . $person->getFirstname() . ' ' . $person->getLastname() . ' edited!'
            );

            return $this->redirectToRoute('persons', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('person/edit.html.twig', [
            'person' => $person,
            'form' => $form,
        ]);
    }

    #[Route('/person/delete/{id}', name: 'person_delete', methods: ['POST'])]
    public function delete(Request $request, Person $person, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete'.$person->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($person);
            $entityManager->flush();

             $this->addFlash(
                'delete',
                'Employee ' . $person->getFirstname() . ' ' . $person->getLastname() . ' deleted!'
            );
        }

        return $this->redirectToRoute('persons', [], Response::HTTP_SEE_OTHER);
    }
}
