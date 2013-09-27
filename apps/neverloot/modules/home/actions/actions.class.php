<?php

/**
 * home actions.
 *
 * @package    NeverLoot
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends sfActions
{
    /**
    * Executes index action
    *
    * @param sfRequest $request A request object
    */
    public function executeIndex(sfWebRequest $request)
    {
    }

    /**
     * action de login
     * @param sfWebRequest $request requête courante
     */
    public function executeLogin($request)
    {
        if ($this->getUser()->isAuthenticated()) {
            $this->redirect('@homepage');
        }

        $this->setLayout('no_masthead_layout');

        if(	$request->hasParameter('login') &&
            $request->hasParameter('password'))
        {
            if($this->getUser()->tryLogin(
                $request->getPostParameter('login'),
                $request->getPostParameter('password')
            ))
                $this->redirect(
                    $request->getParameter('url_redirect', '@homepage')
                );

            else
                $this->getUser()->setFlash('error', 'Authentification impossible.');
        }
    }

    /**
     * action d'enregistrement
     * @param sfWebRequest $request requê courante
     */
    public function executeRegister($request)
    {
        $this->setLayout('no_masthead_layout');

        // si formulaire entrant
        if ($request->hasParameter('nom')) {
            $params = $request->getParameterHolder()->getAll();

            foreach ($params as $param) {
                if(empty($param))
                    $this->redirect('@register');
            }

            if ($params['password'] != $params['password2']) {
                $this->getUser()->setFlash('error', 'Mots de passe différents');
                $this->redirect('@register');
            }

            // création du compte
            $isAlreadyRegistred = CompteQuery::create()
                ->select('Compte.Login')
                ->where('Compte.Login=?', $params['login'])
                ->count();

            if ($isAlreadyRegistred) {
                $this->getUser()->setFlash('error', 'Ce compte existe déjà.');
                $this->redirect('@register');
            }

            // droits d'accès par défaut
            $idAcces = RefAccesQuery::create()
                ->select('RefAcces.IdRefAcces')
                ->where('RefAcces.CodeAcces = ?', 'enregistré')
                ->find()
                ->toArray();

            $compte = new Compte();
            $compte->setIdRefAcces(array_pop($idAcces));
            $compte->setLogin($params['login']);
            $compte->setPassword(
                nlMisc::encrypt($params['password'])
            );
            $compte->setNbRaids(0);
            $compte->setNbLoot(0);
            $compte->setPriorite(0);
            $compte->save();

            // création du perso
            $params['id_compte'] = $compte->getIdCompte();
            $params['is_main'] = 1;
            Perso::createFromArray($params)->save();

            // retour au formulaire de login
            $this->getUser()->setAuthenticated(false);
            $this->getUser()->setFlash('info', 'Enregistrement terminé.');
            $this->redirect('@homepage');
        }
    }

    /**
     *
     * @param sfWebRequest $request requete courante
     */
    public function executeImport($request)
    {
        $objets = ObjetQuery::create()
            ->filterByJsonSource('{{%', Criteria::LIKE)
            ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
            ->find();

        foreach ($objets as $objet) {
            $objet->setJsonSource('{'.trim(trim($objet->getJsonSource(),'{'), '}').'}');
            $objet->save();
            echo $objet->getIlevel().' - '.$objet->getNomFr()."<br/>";
        }

        // on vide les tables
        ComptePeer::doDeleteAll();
        SoireePeer::doDeleteAll();

        $conv1 = Propel::getConnection('v1');

        // import des soirées
        $sql = ' SELECT s.*, r.nom as nom_raid
            FROM wow_soiree s, wow_raid r
            where r.id_raid = s.id_raid
        ';

        $stmt = $conv1->prepare($sql);
        $stmt->execute();
        $listeSoirees = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $mapSoirees = array();

        foreach ($listeSoirees as $infosSoireev1) {
            $soiree = new Soiree();
            $soiree->setNom($infosSoireev1['nom']);
            $soiree->setDescription($infosSoireev1['description']);
            $soiree->setDate($infosSoireev1['date']);
            $soiree->setEtat($infosSoireev1['etat'] == 3 ? 2 : $infosSoireev1['etat']);
            $soiree->setRaid(
                RaidQuery::create()->filterByNomFr($infosSoireev1['nom_raid'])->findOne()
            );

            $soiree->save();
            $mapSoirees[$infosSoireev1['id_soiree']] = $soiree->getIdSoiree();
        }

        // import des comptes et utilisateurs
        $sql = ' SELECT
                p.id_perso, p.nom, p.password, p.is_admin, p.nb_loots, p.nb_raids,
                c.id as id_classe,
                s1.id as id_spe1, s2.id as id_spe2,
                wl.id_wishlist, wl.nom as nom_wishlist

            FROM wow_perso p, wow_classe c, wow_spe s1, wow_spe s2, wow_wishlist wl
            where p.id_classe = c.id_classe
                and p.id_spe_1 = s1.id_spe
                and p.id_spe_2 = s2.id_spe
                and p.id_perso = wl.id_perso

            order by p.id
        ';

        $stmt = $conv1->prepare($sql);
        $stmt->execute();
        $listePersos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($listePersos as $infoPersov1) {
            $codeAcces = $infoPersov1['is_admin'] == 1 ? 'admin' : 'membre';

            $compte = new Compte();
            $compte->setLogin($infoPersov1['nom']);
            $compte->setPassword($infoPersov1['password']);
            $compte->setNbRaids($infoPersov1['nb_raids']);
            $compte->setNbLoot($infoPersov1['nb_loots']);
            $compte->setRefAcces(RefAccesQuery::create()->filterByCodeAcces($codeAcces)->findOne());
            $compte->save();

            $perso = new Perso();
            $perso->setNom($infoPersov1['nom']);
            $perso->setIsMain(true);
            $perso->setIdClasse($infoPersov1['id_classe']);
            $perso->setIdSpe1($infoPersov1['id_spe1']);
            $perso->setIdSpe2($infoPersov1['id_spe2']);
            $perso->setCompte($compte);
            $perso->save();

            $mapsRoles = array('tanks' => 1, 'heals' => 2, 'dps' => 3);
            $mapStatus = array(
                10 => 1,
                11 => 6,
                51 => 7,
                52 => 6,
                53 => 4,

            );

            $sql = ' SELECT *
                FROM wow_role_soiree rs
                where rs.id_perso = '.$infoPersov1['id_perso'].'
            ';
            $stmt = $conv1->prepare($sql);
            $stmt->execute();
            $listePersoSoiree = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($listePersoSoiree as $infoPersoSoireev1) {
                $persoSoiree = new PersoSoiree();
                $persoSoiree->setPerso($perso);
                $persoSoiree->setIdSoiree($mapSoirees[$infoPersoSoireev1['id_soiree']]);
                $persoSoiree->setIdStatutPerso(1);
                $persoSoiree->setIdStatutAdmin($mapStatus[$infoPersoSoireev1['etat']]);
                $persoSoiree->setIdRole(empty($infoPersoSoireev1['role']) ? null : $mapsRoles[$infoPersoSoireev1['role']]);
                $persoSoiree->save();
            }

            $wishlist = new Wishlist();
            $wishlist->setNom($infoPersov1['nom_wishlist']);
            $wishlist->setPerso($perso);
            $wishlist->setDescription('whislist '.$perso->getNom().' normal');
            $wishlist->setIdTypeWishlist(1);
            $wishlist->setILevelMin(391);
            $wishlist->setILevelMax(403);
            $wishlist->save();

            $sql = ' SELECT wlo.*, o.nom_fr
                FROM wow_wishlist_objet wlo, wow_objets o
                where wlo.id_wishlist = '.$infoPersov1['id_wishlist'].'
                and wlo.id_objet = o.id_objet
            ';
            $stmt = $conv1->prepare($sql);
            $stmt->execute();
            $listeWlo = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($listeWlo as $infoWlOv1) {
                $mapSlot = array(
                    'Ring 1' => 'Finger 1',
                    'Ring 2' => 'Finger 2',
                    'Waist' => 'Belt'
                );

                $wlo = new WishlistObjet();
                $wlo->setWishlist($wishlist);
                $wlo->setObjet(
                    ObjetQuery::create()
                        ->filterByNomFr($infoWlOv1['nom_fr'])
                        ->filterByHeroique(false)
                        ->findOne()
                );
                $wlo->setSlot(
                    SlotQuery::create()
                        ->filterByCodeMrrobot(isset($mapSlot[$infoWlOv1['emplacement']])
                            ? $mapSlot[$infoWlOv1['emplacement']]
                            : $infoWlOv1['emplacement']
                        )
                        ->findOne()
                );

                $wlo->save();

                if($infoWlOv1['etat'] == 30)
                    $wlo->setLooted(false, 0);
            }
        }
        die;
    }
}
