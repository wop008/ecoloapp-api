<?php
/**
 * Created by PhpStorm.
 * User: benja
 * Date: 27/03/2019
 * Time: 12:33
 */

namespace App\Service;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UtilsService
{
    public static function serialiseResponse($object)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $json = $serializer->serialize($object, 'json');

        return $json;
    }

    public static function formatNom($nom)
    {
        $nom = mb_strtolower(trim($nom));
        if(strpos($nom, ':') !== false) {
            $nom = explode(':', $nom);
            return $nom[1];
        }

        return $nom;
    }

    public static function constructFinalJson($firstArray, $secondArray)
    {
        $firstArray = self::serialiseResponse($firstArray);
        $secondArray = self::serialiseResponse($secondArray);

        $finalJson = json_encode(array_merge(json_decode($firstArray, true), json_decode($secondArray, true)));
        return $finalJson;
    }
}