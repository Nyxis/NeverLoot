<?php

/**
 * perso actions.
 *
 * @package    NeverLoot
 * @subpackage perso
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class persoActions extends nlActions
{
    //---------------------------------------------------------------
    // actions de la fiche perso
    //---------------------------------------------------------------

    /**
     * action d'affichage de la fiche perso
     * @param sfWebRequest $request requete courante
     */
    public function executeFiche($request)
    {
        $this->forward404Unless(
            $request->hasParameter('id_perso')
        );

        $this->perso = PersoQuery::create()
            ->filterByIdPerso($request->getParameter('id_perso'))
            ->filterByNom($request->getParameter('nom'))
            ->findOne();

        $this->forward404Unless($this->perso);

        // teste si l'utilisateur visualise sa propre fiche
        $this->edit = (
            $this->getUser()->load()->isMine($this->perso)
            || $this->getUser()->isAdmin());

        // liste des droits d'accès
        $this->listeAcces = RefAccesQuery::create()->find();
    }

    /**
     * action d'édition d'une fiche perso
     * @param sfWebRequest $request requete courante
     */
    public function executeEdit($request)
    {
        $perso = PersoQuery::create()->findPk(
            $request->getParameter('id', false)
        );

        // on n'édite que son perso si pas admin
        $this->forward404Unless(
            $perso
            || (!$this->getUser()->load()->isMine($perso)
                && !$this->getUser()->isAdmin())
        );

        $params = $request->getParameterHolder()->getAll();
        $perso->fromArray($params, BasePeer::TYPE_FIELDNAME);
        $perso->save();

        $compte = $perso->getCompte();
        $compte->fromArray($params, BasePeer::TYPE_FIELDNAME);
        $compte->save();

        $this->redirect('persoFiche', array(
            'id_perso' => $perso->getIdPerso(),
            'nom' => $perso->getNom()
        ));
    }

    /**
     * action d'édition d'une fiche perso
     * @param sfWebRequest $request requete courante
     */
    public function executeNew($request)
    {
        $this->forward404Unless(
            $request->hasParameter('id_compte')
            || ($this->getUser()->load()->getIdCompte() == $request->getParameter('id_compte', false)
                && !$this->getUser()->isAdmin())
        );

        $perso = new Perso();
        $params = $request->getParameterHolder()->getAll();
        $perso->fromArray($params, BasePeer::TYPE_FIELDNAME);
        $perso->setIsMain(0);
        $perso->save();

        $this->redirect('persoFiche', array(
            'id_perso' => $perso->getIdPerso(),
            'nom' => $perso->getNom()
        ));
    }

    /**
     * action de listing des persos
     * @param sfWebRequest $request requete courante
     */
    public function executeListeChampions($request)
    {
        $this->listePerso = PersoQuery::create()
            ->filterByIsMain(true)
            ->useCompteQuery()
                ->useRefAccesQuery(null, Criteria::INNER_JOIN)
                    ->filterByCodeAcces(array('admin', 'champion'))
                ->endUse()
            ->endUse()
            ->orderBy('Nom')
            ->with('Compte')
            ->find();
    }

    /**
     * action de listing des membres
     * @param sfWebRequest $request requete courante
     */
    public function executeListeMembres($request)
    {
        $this->listePerso = PersoQuery::create()
            ->filterByIsMain(true)
            ->useCompteQuery()
                ->useRefAccesQuery(null, Criteria::INNER_JOIN)
                    ->filterByCodeAcces(array('membre', 'enregistré'))
                ->endUse()
            ->endUse()
            ->orderBy('Nom')
            ->with('Compte')
            ->find();
    }
}
