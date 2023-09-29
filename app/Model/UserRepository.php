<?php
namespace App\Model;

use Nextras\Orm\Collection\ICollection;
use Nextras\Orm\Repository\Repository;

class UserRepository extends Repository {
    static function getEntityClassNames(): array
    {
        return [Usermodel::class];
    }

    public function findHomepageOverview()
	{
		return $this->findAll()->orderBy('id', ICollection::ASC);
	}

}