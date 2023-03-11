<?php

namespace App\Controller;

use App\Entity\Roles;
use App\Repository\RolesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\Persistence\ManagerRegistry;


class RolesController extends AbstractController
{

    /**
     * Route et methode pour avoir tous les roles
     */
    #[Route('/api/all-roles', name: 'app_all_roles' , methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): Response
    {
        $roles = $doctrine
            ->getRepository(Roles::class)
            ->findAll();
  
        $data = [];
  
        foreach ($roles as $roles) {
           $data[] = [
               'id' => $roles->getRoleId(),
               'name' => $roles->getNom(),
           ];
        }
  
  
        return $this->json($data);
    }
 
    
    /**
     * Route et methode pour enregistrer des données depuis potman
     */
    // #[Route('/api/project', name: 'project', methods: ['POST'])]
    #[Route('/api/roles/create', name: 'addRoles', methods: ['POST'])]

    public function new(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $data = json_decode($request->getContent());
        $nom = $data->nom;
        // dd(json_decode($request->getContent()));
        
        $roles = new Roles();
        $roles->setNom($nom);

        $entityManager->persist($roles);
        $entityManager->flush();
        
        $data = [$roles->asArray()];
        return new JsonResponse($data, 200, ["Content-Type" => "application/json"]);

        // return $this->json('Created new project successfully with id ' . $roles->getRoleId());
    }
    //Route pour supprimer une mairie par son id
    #[Route('/api/Roles/delete/{id}', name: 'deleteRoles', methods: ['DELETE'])]
    public function deleteRoles(Roles $roles, EntityManagerInterface $delete): JsonResponse
    {
        $delete->remove($roles);
        $delete->flush();
        return new JsonResponse('Role supprimé avec succès', Response::HTTP_OK);
    }
   
    //Route pour modifier un role par son id
    // #[Route('/api/roles/update/{id}', name: 'updateRoles', methods: ['PUT'])]
    // public function updateRoles(Roles $roles, Request $request, EntityManagerInterface $update, SerializerInterface $serializer): JsonResponse
    // {
    //     $roles = $serializer->deserialize($request->getContent(), Roles::class, 'json', ['object_to_populate' => $roles]);
    //     $update->persist($roles);
    //     $update->flush();

    //     $jsonroles = $serializer->serialize($roles, 'json');
    //     return new JsonResponse($jsonroles, Response::HTTP_OK, [], true);
    // }
}   
