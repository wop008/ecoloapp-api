<?php

namespace App\Service;

use Unirest;


class APIService
{
    const API_URL = 'https://fr.openfoodfacts.org/api/v0/produit/';
    const FIELDS_TO_CHECK = ['product_name', 'quantity', 'origins', 'image_url', 'labels', 'brands', 'packaging'];

    public function getProduit(string $codebarre)
    {
        // Disables SSL cert validation temporary
        Unirest\Request::verifyPeer(false);

        return Unirest\Request::get(self::API_URL.$codebarre.'.json');
    }

    public function formatProduitResponse($response)
    {
        $produitAPI = $response->body->product;

        $this->checkMissingFields($produitAPI);

        $nom = $produitAPI->product_name;
        $quantite = $produitAPI->quantity;
        $origine = $produitAPI->origins;
        $img_url = $produitAPI->image_url;
        $labels = $this->deleteDuplicates(explode(',', $produitAPI->labels));
        $marques = $this->deleteDuplicates(explode(',', $produitAPI->brands));
        $emballages = $this->deleteDuplicates(explode(',', $produitAPI->packaging));

        $this->deleteDuplicates($emballages);

        $produit = array('nom'      =>  $nom,
                        'qte'       =>  $quantite,
                        'origine'   =>  $origine,
                        'imgUrl'    => $img_url,
                        'labels'    =>  $labels,
                        'marques'   =>  $marques,
                        'emballages' =>  $emballages
                        );

        return $produit;
    }

    public function checkMissingFields($obj)
    {
        foreach (self::FIELDS_TO_CHECK as $field) {
            if (!property_exists($obj, $field))
                $obj->{$field} = '';
        }
    }

    public function produitExists($response)
    {
        if(property_exists($response->body, 'product') && $response->body->product->code !== "")
            return true;

        return false;
    }

    public function deleteDuplicates($values)
    {
        // Formatage des valeurs
        for($i = 0; $i < sizeof($values); $i++)
        {
            $values[$i] = UtilsService::formatNom($values[$i]);
        }

        // Nombre d'occurrences de chaque valeur et suppression des doublons
        $occurenceNumbers = array_count_values($values);
        foreach ($occurenceNumbers as $occurrenceNumber)
        {
            while($occurrenceNumber > 1)
            {
                $valueToDelete = array_search($occurrenceNumber, $occurenceNumbers);
                $indexToDelete = array_search($valueToDelete, $values);
                unset($values[$indexToDelete]);
                $values = array_values($values);
                $occurrenceNumber--;
            }
        }

        return $values;
    }
}
