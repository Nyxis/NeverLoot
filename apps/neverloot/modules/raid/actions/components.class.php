<?php

/**
 * raid components.
 *
 * @package    NeverLoot
 * @subpackage raid
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class raidComponents extends sfComponents
{
    //---------------------------------------------------------------
    // CRUD soirée
    //---------------------------------------------------------------

    /**
     * composant d'affichage des infos de la soirée
     * @param sfWebRequest $request requete courante
     */
    public function executeForm($request)
    {
        // liste des raids
        $this->listeRaids = RaidQuery::create()
            ->orderByIdRaid(Criteria::DESC)
            ->find();

        // liste des status
        $this->listeStatus = $this->soiree->getListeStatus();
    }

    /**
     * composant d'affichage du formulaire d'édition de la composition d'un raid
     * @param sfWebRequest $request requete courante
     */
    public function executeEditCompo($request)
    {
        $this->compo = $this->soiree->getCompo();
    }

    /**
     * compo d'affichage de la liste des inscrits
     * @param sfWebRequest $request requete courante
     */
    public function executeListeInscrits($request)
    {
        $this->listeInscrits = PersoQuery::create()
            ->useCompteQuery()
                ->useRefAccesQuery()
                    ->filterByCodeAcces(array('admin', 'champion'))
                ->endUse()
            ->endUse()
            ->filterByIsMain(true)
            ->ordreByRole()
            ->find();

        // $this->listeInscrits = $this->soiree->getListeInscrits();
    }


    //---------------------------------------------------------------
    // composants boss et raid
    //---------------------------------------------------------------

    /**
     * composant d'affichage de la composition d'un raid
     * @param sfWebRequest $request requete courante
     */
    public function executeCompo($request)
    {
        $this->compo = $this->soiree->getCompo();
    }


    /**
     * composant général d'affichage de la liste des
     * boss et des attribs de loots
     * @param sfWebRequest $request requête courante
     */
    public function executeGestionLoot($request)
    {
        if(empty($this->soiree) && $request->hasParameter('id_soiree'))
            $this->soiree = SoireeQuery::create()->findPk(
                $request->getParameter('id_soiree', false)
            );

        $this->listeBoss = $this->soiree->getRaid()->getListeBoss();
    }

    /**
     * composant d'affichage d'une fiche de boss
     * @param sfWebRequest $request requête courante
     */
    public function executeFicheBoss($request)
    {
        if(empty($this->boss))
            throw new Exception('boss nécessaire');

        if(empty($this->listePersos)) // pas de liste en param
            $this->listePersos = PersoQuery::create()->find(); // on prend tout

        $this->boss->setListePersos($this->listePersos);
        $this->itemLists = array(
            'normal' => nlMisc::indexBy('IdObjet', $this->boss->getListeObjets(false)),
            'heroique' => nlMisc::indexBy('IdObjet', $this->boss->getListeObjets(true)),
        );

        // détection du mode d'affichage
        $this->displayHm = false;
        if ($request->hasParameter('current_item')) {
            $this->currentItem = $request->getParameter('current_item', false);
            foreach($this->itemLists as $liste)
                foreach($liste as $item)
                    foreach($item->getGenerated() as $gen)
                    if ($gen->getIdObjet() == $this->currentItem->getIdObjet()) {
                        $this->displayHm = $this->currentItem->getHeroique();

                        return sfView::SUCCESS;
                    }
        }
    }
}
