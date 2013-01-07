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


    //---------------------------------------------------------------
    // action d'imports
    //---------------------------------------------------------------

    /**
     *
     */
    protected function createSource($type, $idType, $code)
    {
        $source = SourceObjetQuery::create()
            ->filterByType($type)
            ->filterByIdType($idType)
            ->filterByCode($code)
            ->findOne();

        if($source)

            return $source;

        $source = new SourceObjet();
        $source->setType($type);
        $source->setIdType($idType);
        $source->setCode($code);
        $source->save();

        return $source;
    }

    /**
     *
     */
    protected function getSource($infos, $item)
    {
        if(empty($infos['source']))
            throw new Exception(sprintf('Pas de source ("%s")',
                $infos['id']
            ));

        // 1 : craft
        // 2 : raid
        // 5 : marchands

        $source = array_pop($infos['source']);

        if ($source == 5) {
            $mapLibToken = array(
                1 => array('Couronne%', 'Heaume%'),
                3 => array('Epaulières%', 'Mantelet%'),
                5 => array('Plastron%'),
                7 => array('Jambières%'),
                10 => array('Gantelets%')
            );

            // token -> objet à classe définie
            if (!empty($infos['reqclass']) && !empty($mapLibToken[$infos['slot']])) {
                // on retrouve le token
                $token = ObjetQuery::create()
                    ->condition('ilevel', 'Objet.Ilevel = ?', $infos['level'])
                    ->condition('slot', 'Objet.IdSlot1 IS NULL', null)
                    ->condition('classes', 'Objet.Classes LIKE ?', '%'.$item->getClasses().'%')
                    ->combine(array('ilevel', 'slot', 'classes'), 'and', 'base');

                $cond = array();
                foreach ($mapLibToken[$infos['slot']] as $key => $namePart) {
                    $condName = $infos['slot'].'_'.$key;
                    $token = $token->condition($condName, 'Objet.NomFr LIKE ?', $namePart);
                    $cond[] = $condName;
                }

                $token = $token
                    ->combine($cond, 'or', 'nom')
                    ->where(array('base', 'nom'), 'and')
                    ->findOne();

                if (!$token) {
                    return $this->createSource(
                        'Vaillances', null, 'achat'
                    );
                }

                return $this->createSource(
                    'Objet', $token->getIdObjet(), 'token'
                );
            }

            // objet vendu en vaillances
            return $this->createSource(
                'Vaillances', null, 'achat'
            );
        }

        if(empty($infos['sourcemore']))
            throw new Exception(sprintf('Pas de sourcemore ("%s")',
                $infos['id']
            ));

        $sourcemore = $infos['sourcemore'][0];

        if ($source == 2) {
            if(empty($sourcemore['z']))
                throw new Exception(sprintf('Pas de zone ("%s")',
                    $infos['id']
                ));

            $zone = $sourcemore['z'];

            if(empty($this->mapRaidBoss[$zone]))
                throw new Exception(sprintf('Raid non supporte ("%s" / %s)',
                    $infos['id'], $zone
                ));

            if(count($sourcemore) == 1) // trash loot

                return $this->createSource(
                    'Raid', $this->mapRaidBoss[$zone]->getIdRaid(), 'trashs'
                );

            if((!empty($sourcemore['bd']) || !empty($sourcemore['dd']))
                && count($sourcemore) == 2
            ) // loot partagé

                return $this->createSource(
                    'Raid', $this->mapRaidBoss[$zone]->getIdRaid(), 'zone'
                );

            if(empty($sourcemore['n']))
                throw new Exception(sprintf('Pas de nom défini ("%s")',
                    $infos['id']
                ));

            // on cherche le boss dans le raid
            $nom = $sourcemore['n'];
            foreach ($this->mapRaidBoss[$zone]->getBosss() as $boss) {
                if($boss->getCadavreFr() == $nom)

                    return $this->createSource(
                        'Boss', $boss->getIdBoss(), 'boss'
                    );
            }

            throw new Exception(sprintf('Boss inconnu ("%s" / %s)',
                $infos['id'], $sourcemore['n']
            ));
        }

        if ($source == 1) {
            return $this->createSource(
                'Craft', null, 'craft'
            );
        }

        throw new Exception(sprintf('Source non supportée ("%s" / %s)',
            $infos['id'], $source
        ));
    }

    protected $mapRaidBoss;

    /**
     *
     * @param sfWebRequest $request requete courante
     */
    public function executeSyncObjets($request)
    {
        // ObjetQuery::create()
            // ->update(array(
               // 'IdSourceObjet' => null
            // ));

        // $listeRaids = RaidQuery::create()
            // ->find();

        // $this->mapRaidBoss = nlMisc::indexBy('IdZone', $listeRaids);

        $listeObjets = ObjetQuery::create()
            // ->filterByJsonSource('%[2]%')
            // ->filterByIdObjet('76359')
            ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
            // ->limit(100)
            ->find();

        foreach ($listeObjets as $objet) {
            try {
                // calcul des objets source
                // $json = json_decode($objet->getJsonSource(), true);

                // $objet->setSourceObjet(
                    // $this->getSource($json, $objet)
                // );

                $objet->save();
            } catch (Exception $e) {
                echo '<pre>';
                echo $objet->getNomFr();
                echo "\n";
                echo $e->getMessage();
                echo "\n";
                echo $objet->getJsonSource();
                echo "\n";
                echo '</pre>';
                continue;
            }
        }

        die;
    }

}
