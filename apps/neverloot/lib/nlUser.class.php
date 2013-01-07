<?php

class nlUser extends sfBasicSecurityUser
{
    /** compte correspondant à la session */
    protected $compte;

    /**
     * tente de log l'utilisateur avec les données en paramètre
     * @param  string $login
     * @param  string $password
     * @return bool   log ou non
     */
    public function tryLogin($login, $password)
    {
        $compte = CompteQuery::create()
            ->filterByLogin($login)
            ->filterByPassword(nlMisc::encrypt($password))
            ->findOne();

        if(empty($compte))

            return false;

        $this->setAuthenticated(true);

        $access = $compte->getRefAcces();
        $this->addCredential($access->getCodeAcces());

        $this->setAttribute('id_compte', $compte->getIdCompte());
        $this->setAttribute('login', $compte->getLogin());

        $this->compte = $compte;

        return true;
    }

    /**
     * charge l'utilisateur correspondant à la session active
     * @return Perso
     */
    public function load()
    {
        if(!$this->isAuthenticated())
            throw new Exception('Impossible de charger un utilisateur non authentifié');

        if(!empty($this->compte))

            return $this->compte;

        $this->compte = CompteQuery::create()
            ->findPK($this->getAttribute('id_compte'));

        return $this->compte;
    }

    /**
     * teste si l'utilisateur en cours est un admin ou non
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasCredential('admin');
    }

}
