<?php

/**
 * Skeleton subclass for representing a row from the 'wow_compte' table.
 *
 *
 *
 * This class was autogenerated by Propel 1.6.4-dev on:
 *
 * Wed Feb  1 14:56:23 2012
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.lib.model
 */
class Compte extends BaseCompte
{
    /**
     * méthode de crédit d'un personnage
     * @param  int   $credit montant à créditer
     * @return Perso
     */
    public function crediter($credit)
    {
        $this->setNbRaids(floatval($this->getNbRaids()) + floatval($credit));

        return $this;
    }

    /**
     * calcule le ratio du perso
     * @uses setPriorite()
     */
    public function calculerPriorite()
    {
        $nbRaids = $this->getNbRaids();
        $nbLoot = $this->getNbLoot();

        $this->setPriorite(round((($nbLoot < 1 ? 1 : $nbLoot) / ($nbRaids < 1 ? 1 : $nbRaids)) * 10, 2));

        return $this;
    }

    /**
     * incrémente le nb de loots de ce compte avec le parametre
     * @param int $nb
     */
    public function addLoot($nb = 1)
    {
        $this->setNbLoot(intval($this->getNbLoot())+$nb);
        $this->save();
    }

    /**
     * surcharge du set pour recalculer le ratio à chaque modif
     * @param int $nbLoot défini le nb loots
     */
    public function setNbLoot($nbLoot)
    {
        $ret = parent::setNbLoot($nbLoot);
        $this->calculerPriorite();

        return $ret;
    }

    /**
     * surcharge du set pour recalculer le ratio à chaque modif
     * @param int $nbRaids défini le nb raids
     */
    public function setNbRaids($nbRaids)
    {
        $ret = parent::setNbRaids($nbRaids);
        $this->calculerPriorite();

        return $ret;
    }


    //---------------------------------------------------------------
    // fonctions de récup des persos
    //---------------------------------------------------------------

    /**
     * teste si le perso en paramètre m'appartient
     * @param  string|Perso $perso id ou perso à tester
     * @return bool
     */
    public function isMine($perso)
    {
        if($perso instanceof Perso)
            $perso = $perso->getIdPerso();

        return PersoQuery::create()
            ->filterByIdCompte($this->getIdCompte())
            ->filterByIdPerso($perso)
            ->count() > 0;
    }

    /**
     * renvoie le perso principal du compte
     * @return Perso
     */
    public function getMain()
    {
        return PersoQuery::create()
            ->filterByIdCompte($this->getIdCompte())
            ->filterMain()
            ->findOne();
    }

    /**
     * renvoie les rerolls du compte
     * @return array
     */
    public function getRerolls()
    {
        return PersoQuery::create()
            ->filterByIdCompte($this->getIdCompte())
            ->filterReroll()
            ->find();
    }

    /**
     * renvoie la liste des persos liés à ce compte
     * @return array
     */
    public function getListePersos()
    {
        return PersoQuery::create()
            ->filterByIdCompte($this->getIdCompte())
            ->orderByIsMain('desc')
            ->orderByNom()
            ->find();
    }

} // Compte
