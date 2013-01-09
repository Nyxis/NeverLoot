<?php

/**
 * raid actions.
 *
 * @package    NeverLoot
 * @subpackage raid
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class raidActions extends nlActions
{
    //---------------------------------------------------------------
    // CRUD des soirées
    //---------------------------------------------------------------

    /**
     * action d'affichage d'une soirée
     * @param sfWebRequest $request requete courante
     */
    public function executeFiche($request)
    {
        $this->soiree = SoireeQuery::create()->findPK(
            $request->getParameter('id')
        );
    }

    /**
     * action d'export des compositions de raid
     * @param sfWebRequest $request requete courante
     */
    public function executeExport($request)
    {
        $this->executeFiche($request);

        $this->setLayout(false);
        $this->getResponse()->setHttpHeader('Access-Control-Allow-Origin', '*');
        $this->getResponse()->setHttpHeader('Content-Type', 'application/javascript');
    }


    /**
     * action de création d'une soirée de raid
     * @param sfWebRequest $request requete courante
     */
    public function executeNew($request)
    {
        $this->soiree = new Soiree();
    }

    /**
     * action d'édition d'une soirée
     * @param sfWebRequest $request requete courante
     */
    public function executeEdit($request)
    {
        if ($request->hasParameter('id')) { // vient d'une autre page
            $this->soiree = SoireeQuery::create()->findPk(
                $request->getParameter('id', false)
            );

            $this->forward404Unless(
                $this->soiree
            );

            return sfView::SUCCESS;
        } else { // vient d'un formulaire
            // récupération de la soirée
            $idSoiree = $request->getParameter('id_soiree', false);
            if(!empty($idSoiree))
                $soiree = SoireeQuery::create()->findPk($idSoiree);
            else {
                $soiree = new Soiree();
                $idSoiree = null;
            }

            $this->forward404Unless($soiree);

            // mise à jour
            $soiree->fromArray(
                $request->getParameterHolder()->getAll(),
                BasePeer::TYPE_FIELDNAME
            );

            $soiree->setIdSoiree($idSoiree);
            $soiree->save();

            // maj de la compo
            if ($request->hasParameter('compojson')) {
                // récup de personnes déja inscrites
                $listePersoSoiree = nlMisc::indexBy('IdPerso',
                    PersoSoireeQuery::create()
                        ->filterByIdSoiree($soiree->getIdSoiree())
                        ->find()
                );

                // récup des status
                $listeStatus = nlMisc::indexBy('Code', RefStatutPersoQuery::create()->find());

                // récup des roles
                $listeRoles = nlMisc::indexBy('Code', RoleQuery::create()->find());

                // mise à jour avec les infos
                $compo = json_decode($request->getParameter('compojson', false));
                foreach($compo as $statut => $listeIdPersos)
                    foreach ($listeIdPersos as $idPerso) {
                        // si il y a déja une entrée de ce perso pour cette soirée
                        if (isset($listePersoSoiree[$idPerso])) {
                            $persoSoiree = $listePersoSoiree[$idPerso];
                            unset($listePersoSoiree[$idPerso]);
                        } else {
                            $persoSoiree = new PersoSoiree();
                            $persoSoiree->setIdPerso($idPerso);
                            $persoSoiree->setIdSoiree($soiree->getIdSoiree());
                            $persoSoiree->setIdStatutPerso($listeStatus['accepte']->getIdRefStatutPerso());
                        }

                        // remplissage des infos
                        if (isset($listeRoles[$statut])) {
                            $persoSoiree->setIdRole($listeRoles[$statut]->getIdRole());
                            $persoSoiree->setIdStatutAdmin($listeStatus['confirme']->getIdRefStatutPerso());
                        } elseif (isset($listeStatus[$statut])) {
                            $persoSoiree->setIdStatutAdmin($listeStatus[$statut]->getIdRefStatutPerso());
                        }

                        $persoSoiree->save();
                    }

                // suppression des entrées encore présentes
                foreach($listePersoSoiree as $persoSoiree)
                    $persoSoiree->delete();
            }

            // redirect sur la fiche
            $this->redirect('raidEdit', array(
                'id' => $soiree->getIdSoiree()
            ));
        }
    }

    //---------------------------------------------------------------
    // actions de la fiche raid
    //---------------------------------------------------------------

    /**
     * ajoute l'objet en paramètre a perso en paramètre
     * @param sfWebRequest $request requête courante
     */
    public function executeAddLoot($request)
    {
        $this->forward404Unless(
            $request->hasParameter('liste_id_wl_objet')
            // && $request->isXmlHttpRequest()
        );

        $listeIdWlObjet = json_decode($request->getParameter('liste_id_wl_objet', array()));
        $listeWlObjets = WishlistObjetQuery::create()
            ->join('Wishlist')->with('Wishlist')
            ->join('Wishlist.TypeWishlist')->with('TypeWishlist')
            ->join('Wishlist.Perso')->with('Perso')
            ->join('Perso.Compte')->with('Compte')
            ->filterByIdWishlistObjet($listeIdWlObjet)
            ->find();

        if($listeWlObjets->isEmpty())
            $this->forwardComponent('gestionLoot');

        foreach($listeWlObjets as $wlObjet)
            $wlObjet->setLooted(
                $temp = true,

                // les loots ne comptent pas pour les rerolls
                $wlObjet->getWishlist()->getPerso()->getIsMain() ? null : 0,

                $request->getParameter('id_soiree', false)
            );

        $request->setParameter('current_item', $wlObjet->getObjet());
        $this->forwardComponent('gestionLoot');
    }

    /**
     * retire l'objet à la liste de persos en paramètres
     * @param sfWebRequest $request requête courante
     */
    public function executeRemoveLoot($request)
    {
        $this->forward404Unless(
            $request->hasParameter('liste_id_wl_objet')
            && $request->isXmlHttpRequest()
        );

        $listeIdWlObjet = json_decode($request->getParameter('liste_id_wl_objet', array()));
        $listeWlObjets = WishlistObjetQuery::create()
            ->join('Wishlist')->with('Wishlist')
            ->join('Wishlist.TypeWishlist')->with('TypeWishlist')
            ->join('Wishlist.Perso')->with('Perso')
            ->join('Perso.Compte')->with('Compte')
            ->filterByIdWishlistObjet($listeIdWlObjet)
            ->find();

        if($listeWlObjets->isEmpty())
            $this->forwardComponent('gestionLoot');

        foreach($listeWlObjets as $wlObjet)
            $wlObjet->unsetLooted($temp = true);

        $request->setParameter('current_item', $wlObjet->getObjet());
        $this->forwardComponent('gestionLoot');
    }

    /**
     * action de recyclage d'un objet (dez - attrib non bis)
     * @param sfWebRequest $request requete courante
     */
    public function executeRecycleLoot($request)
    {
        $this->forward404Unless(
            $request->hasParameter('id_objet')
            && $request->isXmlHttpRequest()
        );

        $objet = ObjetQuery::create()->findPk($request->getParameter('id_objet'));
        if (!$objet) {
            $this->forwardComponent('gestionLoot');
        }

        $attribution = new Attribution();
        $attribution->setTmp(false);
        $attribution->setIdObjet($objet->getIdObjet());
        $attribution->setIdSoiree($request->getParameter('id_soiree', null));
        $attribution->setDisenchant($request->getParameter('disenchant', null));
        $attribution->save();

        $request->setParameter('current_item', $objet);
        $this->forwardComponent('gestionLoot');
    }

    /**
     * action de fermeture d'une soirée
     * crédite les raids, valide les loots
     * @param sfWebRequest $request requete courante
     */
    public function executeClose($request)
    {
        $this->forward404Unless(
            $soiree = SoireeQuery::create()
                ->filterByIdSoiree($request->getParameter('id_soiree', false))
                ->filterByEtat(array(Soiree::VALIDEE, Soiree::CREE))
                ->findOne()
        );

        $con = Propel::getConnection('propel');
        $con->beginTransaction();

        try {
            $soiree->setEtat(Soiree::LOCK);
            $soiree->save($con);

            $listePersosSoiree = $soiree->getPersoSoireesJoinPerso($con);
            foreach ($listePersosSoiree as $persoSoiree) {
                $perso = $persoSoiree->getPerso($con);

                // calcul du crédit (nb raid)
                $credit = $soiree->getGain() * $persoSoiree->getRefStatutPersoRelatedByIdStatutAdmin($con)->getCoef();
                $perso->crediter($credit)
                    ->save($con);

                // loot temporaires
                AttributionQuery::create($con)
                    ->filterByIdSoiree($soiree->getIdSoiree())
                    ->filterByIdPerso($perso->getIdPerso())
                    ->filterByTmp(true)
                    ->update(array(
                        'Tmp' => false
                    ));
            }

            $soiree->setEtat(Soiree::CLOSED);
            $soiree->save($con);

            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            throw $e;
        }

        $this->redirect('raidFiche', array('id' => $soiree->getIdSoiree()));
    }
}
