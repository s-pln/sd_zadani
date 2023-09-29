<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Model\UserRepository;
use App\Model\Usermodel;
use App\Model\ModelU;
use Nextras\Orm\Collection\ICollection;

final class HomePresenter extends Nette\Application\UI\Presenter
{
    /** @var Usermodel */
	private $user_model;

    /** @var ModelU @inject */
	public $user_u;

    /** @var ICollection|Usermodel[] */
	public $user_collection;

    public function __construct(
		private Nette\Database\Explorer $database,
	) {
	}

    public function renderDefault(): void
    {
        if (!$this->getUser()->isLoggedIn()) { // kto nie je prihlaseny, redirect na prihlasovanie
            $this->redirect('Sign:in');
        }
        $this->template->users = $this->database->table('usermodel');
        // $this->user_collection = $this->user_u->usrs->findHomepageOverview();
    }

    

}
