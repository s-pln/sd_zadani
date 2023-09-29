<?php 
namespace App\Auth;
use Nette;
use Nette\Security\SimpleIdentity;
use Nette\Security\IIdentity;
use Nette\Database\Explorer;
use Nette\Security\Passwords;
use Nette\Security\Authenticator;

class MyAuthenticator implements Authenticator
{
	public function __construct(
		private Explorer $database,
		private Passwords $passwords
	) {
	}

	public function authenticate(string $email, string $password): SimpleIdentity
	{
		$row = $this->database->table('usermodel')
			->where('email', $email)
			->fetch();

		if (!$row) {
			throw new Nette\Security\AuthenticationException('User not found.');
		}

		if (!$this->passwords->verify($password, $row->passwd)) {
			throw new Nette\Security\AuthenticationException('Invalid password.');
		}

		return new SimpleIdentity(
			$row->id,
			['guest'], // role, nebo pole více rolí
			['email' => $row->email],
		);
	}
}
