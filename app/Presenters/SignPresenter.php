<?php
namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

final class SignPresenter extends Presenter
{
    public function __construct(
		private Nette\Database\Explorer $database,
        private Nette\Security\Passwords $passwords
	) {
	}

	public function actionOut(){
        $this->user->logout();
        $this->flashMessage('Odhlášení proběhlo úspěšně.', 'success');
        $this->redirect('Home:');
    }

    protected function createComponentSignInForm(): Form
	{
		$form = new Form;
		$form->addEmail('email', 'Email:')                  // prihlasovaci formular
			->setRequired('Prosím vyplňte svůj e-mail.');

		$form->addPassword('passwd', 'Heslo:')
			->setRequired('Prosím vyplňte své heslo.');

		$form->addSubmit('send', 'Přihlásit');

		$form->onSuccess[] = [$this, 'signInFormSucceeded'];
		return $form;
	}

    public function signInFormSucceeded(Form $form, \stdClass $data): void  // ak bol formular uspesne odoslany, zobrazi sa uvodna obrazovka - zoznam userov
    {
        try {
            $this->getUser()->login($data->email, $data->passwd);
            $this->flashMessage('Úspěšně přihlášeno.', 'success');
            $this->redirect('Home:');

        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError('Nesprávné přihlašovací jméno nebo heslo.');
        }
    }

}
