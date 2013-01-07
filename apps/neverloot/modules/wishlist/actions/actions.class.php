<?php

/**
 * perso actions.
 *
 * @package    NeverLoot
 * @subpackage perso
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class wishlistActions extends nlActions
{
    /**
     * action de création / édition d'une wishlist
     * @param sfWebRequest $request requete courante
     */
    public function executeEdit($request)
    {
        $this->forward404Unless(
            $request->hasParameter('id_perso')
        );

        $this->forward404Unless(
            $this->getUser()->isAdmin()
            || $this->getUser()->load()->isMine(
                $request->getParameter('id_perso', false)
            )
        );

        $params = $request->getParameterHolder()->getAll();

        // création - récup de la wishlist
        if ($request->hasParameter('id_wishlist')) {
            $wishlist = WishlistQuery::create()->findPk(
                $request->getParameter('id_wishlist', false)
            );

            $wishlist->fromArray($params, BasePeer::TYPE_FIELDNAME);
            $wishlist->save();
        } else {
            $wishlist = new Wishlist();
            $wishlist->fromArray($params, BasePeer::TYPE_FIELDNAME);
            $wishlist->save();

            // création des liens avec objets
            $listeSlots = SlotQuery::create()->find();
            foreach ($listeSlots as $slot) {
                $wlObjet = new WishlistObjet();
                $wlObjet->setIdWishlist($wishlist->getIdWishlist());
                $wlObjet->setIdSlot($slot->getIdSlot());
                $wlObjet->save();
            }
        }

        $perso = PersoQuery::create()->findPk(
            $request->getParameter('id_perso', false)
        );

        $this->redirect('persoFiche', array(
            'id_perso' => $perso->getIdPerso(),
            'nom' => $perso->getNom()
        ));
    }

    /**
     * action d'importation d'une wishlist MrRobot
     * @param sfWebRequest $request requete courante
     */
    public function executeImport($request)
    {
        // wl a éditer
        $this->forward404Unless(
            $request->hasParameter('id_wishlist')
        );

        $wishlist = WishlistQuery::create()->findPk(
            $request->getParameter('id_wishlist', false)
        );

        $this->forward404Unless($wishlist);

        // vérification auth (admin ou détenteur)
        $this->forward404Unless(
            $this->getUser()->isAdmin()
            || $this->getUser()->load()->isMine(
                $wishlist->getIdPerso()
            )
        );

        // liste des slots
        $listeSlots = SlotQuery::create()->find();
        $listeSlots = nlMisc::indexBy('codeMrrobot', $listeSlots);

        // lancement du parsing
        $importData = $request->getParameter('importData', '');
        $importData = str_replace("\r",'', $importData);

        $rs = '';
        foreach (explode("\n", $importData) as $line) {
            if(!strlen(trim($line)))
                continue;

            $rs .= $line.'#';
        }

        $tableItems = array();

        // contruction de regex de capture à partir des slots
        $mapRegex = array();
        foreach ($listeSlots as $emplacement => $slot) {
            $mapRegex[$emplacement] = '/'.$emplacement.'\#'
                .'\(([0-9]+)\)' // ilvl
                .' ([^\#]+)\#'  // nom
                .'(([^\#]+) - ([^\#]+))?' // drop
                .'\#/';
        }

        foreach ($mapRegex as $emplacement => $regex) {
            if(!preg_match($regex, $rs, $matchesLine))
                continue;

            $infos = array(
                'ilvl' => $matchesLine[1],
                'nom_objet' => $matchesLine[2],
                'location' => isset($matchesLine[4]) ? $matchesLine[4] : 'World',
                'zone' => isset($matchesLine[5]) ? trim($matchesLine[5], '#') : 'Dragon Soul'
            );

            $item = ObjetQuery::create()
                ->filterByNomEn($infos['nom_objet'])
                ->filterByIlevel($infos['ilvl'])
                ->findOne();

            if(!$item)
                continue;

            $wishlist->addItem( // ajout à la wl
                $item, $listeSlots[$emplacement]
            );
        }

        $perso = $wishlist->getPerso();
        $this->redirect('persoFiche', array(
            'id_perso' => $perso->getIdPerso(),
            'nom' => $perso->getNom()
        ));
    }

    /**
     * action d'édition d'un objet
     * @param sfWebRequest $request requete courante
     */
    public function executeEditObjet($request)
    {
        $this->forward404Unless(
            $request->hasParameter('process')
            && $wlObjet = WishlistObjetQuery::create()->findPk(
                $request->getParameter('id_wishlist_objet', false)
            )
        );

        // vérification auth (admin ou détenteur)
        $perso = $wlObjet->getWishlist()->getPerso();
        $this->forward404Unless(
            $this->getUser()->isAdmin()
            || $this->getUser()->load()->isMine($perso)
        );

        // récup de l'objet
        $wlObjet->setObjet(ObjetQuery::create()->findPk(
            $request->getParameter('id_objet', false)
        ));

        // ajout de loot
        if($request->getParameter('process', false) == 'add')
            $wlObjet->setLooted(
                $temp = false,
                $this->getUser()->isAdmin() ? $request->getParameter('cost', 0) : 0
            );

        // retrait de loot
        elseif($request->getParameter('process', false) == 'remove')
            $wlObjet->unsetLooted($temp = false);

        // sauvegarde
        $wlObjet->save();

        $this->redirect('persoFiche', array(
            'id_perso' => $perso->getIdPerso(),
            'nom' => $perso->getNom()
        ));
    }
}
