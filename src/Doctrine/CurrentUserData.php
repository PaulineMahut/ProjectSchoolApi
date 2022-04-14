<?php

namespace App\Doctrine;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Classe;
use App\Entity\User;
use App\Entity\Student;
use App\Entity\Professor;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

class CurrentUserData implements QueryCollectionExtensionInterface, QueryItemExtensionInterface {
    private Security $security;
    public function __construct(Security $security) {
        $this->security = $security;
    }
    
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {   
        if ($resourceClass == Classe::class && in_array("Professor", $this->security->getUser()->getRoles())) {   
            $aliasTable = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere("$aliasTable.id = :classe")->setParameter("classe", $this->security->getUser()->getClasse());
        }
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {
        // if (in_array($resourceClass, self::FILTERED_ENTITY) ) {   
        //     $this->andWhere($queryBuilder);
        // }
    }

    // private function andWhere($queryBuilder) {
    //         $aliasTable = $queryBuilder->getRootAliases()[0];
    //         $queryBuilder->andWhere("$aliasTable.driver = :driver")->setParameter("driver", $this->security->getUser()->getId());
    // }
}
