<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Property;
use App\Form\PropertyType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class PropertyController extends AbstractController
{
    #[Route('/property', name: 'property')]
    public function index(): Response
    {
        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
        ]);
    }

    #[Route('/property/create', name: 'property.create')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $property = new Property();
        $createPropertyForm = $this->createForm(PropertyType::class, $property);
        $createPropertyForm->handleRequest($request);

        if($createPropertyForm->isSubmitted() && $createPropertyForm->isValid()) {
            $em->persist($property);
            $em->flush();
            return $this->redirectToRoute('property.index');
        }
        return $this->render('property/create.html.twig', [
            'form' => $createPropertyForm
        ]);
    }
    
}
