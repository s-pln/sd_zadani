<?php
namespace App\Model;
use Nextras\Orm\Entity\Entity;

/**
 * @property int $id {primary}
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $passwd
 */
class Usermodel extends Entity{
}