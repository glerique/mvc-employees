<?php

namespace App\Model;

use App\Model\Model;

class DepartementModel extends Model
{
    protected $table = 'departement';
    protected $class  = 'App\Entity\Departement';

    public function getEntityData($departement): array
    {
        return [
            'id' => $departement->getId(),
            'name' => $departement->getName()
        ];
    }
}
