<?php

namespace App\Form;

use App\Entity\Main\Address;
use Symfony\Component\Form\DataTransformerInterface;

class AddressTransformer implements  DataTransformerInterface
{

    /**
     * {@inheritdoc}
     */
    public function transform($data)
    {
        if ( $data !== null) {
            return  $data;
        }
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($data)
    {
        $address = explode(',', $data);
        return  $this->buildAddress(...$address);
    }

    private  function  buildAddress($street, $city, $number): Address
    {
        $address = new Address();
        $address->setStreet($street)
            ->setCity($city)
            ->setNumber($number);
        return $address;
    }
}