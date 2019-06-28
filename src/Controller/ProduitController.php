<?php

namespace App\Controller;

use App\Service\ProduitService;
use App\Service\TriService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\UtilsService;
use App\Entity\User;
use App\Entity\Produit;

class ProduitController extends AbstractController
{
    public function scan(string $uid, string $codebarre)
    {
        $em = $this->getDoctrine()->getManager();

        $produitService = new ProduitService($em);
        $triService = new TriService();
        $utilsService = new UtilsService();

        $produit = $produitService->scanProduct($codebarre);
        $user = $this->getDoctrine()->getRepository(User::class)->find($uid);

        if ($produit instanceof Produit) {
            $user->addProduit($produit);
            $em->persist($user);
            $em->flush();
        } else {
            return new Response($produit);
        }

        $trashCan = $triService->trashCanChoice($produit);
        $response = $utilsService->constructFinalJson($trashCan, $produit);

        return new Response($response);
    }
}
