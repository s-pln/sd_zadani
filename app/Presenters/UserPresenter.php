<?php
namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

final class UserPresenter extends Presenter
{
	public function __construct(
		private Nette\Database\Explorer $database,  // databaza
        private Nette\Security\Passwords $passwords,  // pre hashovanie hesla
	) {
	}

 	public function renderShow(int $userId): void
	{
        if (!$this->getUser()->isLoggedIn()) { // kto nie je prihlaseny, redirect na prihlasovanie
            $this->redirect('Sign:in');
        }

        $usr = $this->database->table('usermodel')->get($userId);
        if (!$usr) {
            $this->error('Stránka nebyla nalezena', 404);  // ak sa snazim pristupovat k neexistujucemu userovi => ERR 404
        }
		$this->template->usr = $usr;
	}

    public function handledelete(int $userId): void
	{
        if (!$this->getUser()->isLoggedIn()) {  // kontrola prihlasenia, k tejto akcii sa teoreticky da pristupovat cez URL
            $this->error('Pro tuto akci je potřeba se přihlásit.', 404);
        }

        $this->database->table('usermodel')->get($userId)->delete(); // mazanie usera
        $this->flashMessage('Požívatel smazán');
        $this->redirect('Home:');
	}

    public function renderCreate(): void // kto nie je prihlaseny, redirect na prihlasovanie
	{
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }

	}

    protected function createComponentUserForm(): Form // UserForm - formular pre vytvorenie noveho usera, alebo pre jeho editovanie 
    {
        $form = new Form;
        $form->addText('name', 'Jméno:')
            ->setRequired();
        $form->addText('surname', 'Příjmení:')
            ->setRequired();
        $form->addEmail('email', 'E-mail:')
            ->setRequired();
        $form->addPassword('passwd', 'Heslo:');
        $form->addPassword('passwd2', 'Zopakovat heslo:');

        $form->addSubmit('send', 'Uložit');
        $form->onSuccess[] = [$this, 'userFormSucceeded'];

        return $form;
    }

    public function userFormSucceeded(Form $form, array $data): void  // ak bol UserForm uspesne odoslany
    {
        if (!$this->getUser()->isLoggedIn()) {  // kontrola prihlasenia, k tejto akcii sa teoreticky da pristupovat cez URL
            $this->error('Pro tuto akci je potřeba se přihlásit.', 404);
        }

        $userId = $this->getParameter('userId');  // ak dostavame ID ide o editovanie, inak vytvarame noveho usera

        if($data['passwd'] == $data['passwd2']){ // kontrola 2x zadaneho hesla

            unset($data['passwd2']); // uvolnenie druheho hesla, to sa neuklada

            if ($userId) {  // editovanie
                if($data['passwd'] == ''){  // ak nebolo zadane heslo, heslo sa nemeni
                    unset($data['passwd']);
                }else{
                    $data['passwd'] = $this->passwords->hash($data['passwd']);  // ak bolo zadane heslo, musime ho zahashovat
                }
                $user = $this->database  //// ukladanie
                    ->table('usermodel')
                    ->get($userId);
                $user->update($data);
        
            }else if($data['passwd'] != ''){  // novy user
                $data['passwd'] = $this->passwords->hash($data['passwd']); // hashovanie hesla

                $user = $this->database // ukladanie
                ->table('usermodel')
                ->insert($data);

                $this->flashMessage("Užívatel byl úspěšně přidán.", 'success');  // sprava pre pouzivatela
            }else{
                $this->flashMessage("Vyplňte heslo.", 'error');
            }

            
            $this->redirect('User:show', $user->id);  // presmerovanie na detail usera
        }else{
            $this->flashMessage("Hesla se neshodují.", 'error');
        }
        
    }

    public function renderEdit(int $userId): void  // obrazovka pre editovanie hesla
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
        
        $usr = $this->database  // nacitanie usera
            ->table('usermodel')
            ->get($userId);

        if (!$usr) {  // kontrola ci user existuje
            $this->error('Používatel se nenašel');
        }

        $this->template->usr = $usr;
        $this->getComponent('userForm')
            ->setDefaults($usr->toArray());
    }




}
