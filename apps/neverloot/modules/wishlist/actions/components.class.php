<?php

/**
 * wishlist actions.
 *
 * @package    NeverLoot
 * @subpackage wishlist
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class wishlistComponents extends sfActions
{
    //---------------------------------------------------------------
    // composant des wishlists
    //---------------------------------------------------------------

    /**
     * composant de l'affichage de la liste des wishlists d'un personnage
     * @param sfWebRequest $request requete courante
     */
    public function executeListe($request)
    {
        // liste de types
        $listeTypeWishlist = TypeWishlistQuery::create()->find();
        $listeTypeWishlist = nlMisc::indexBy('idTypeWishlist', $listeTypeWishlist);

        // wl du perso
        $listeWishlists = WishlistQuery::create()
            ->filterByPerso($this->perso)
            ->orderByIdTypeWishlist()
            ->find();

        $wlDisplayed = array(); // contruction des paramètres
        $first = true;
        foreach ($listeWishlists as $wishlist) {
            $wlDisplayed[] = array(
                'compo' => 'fiche',
                'params' => array(
                    'wishlist' => $wishlist,
                    'perso' => $this->perso,
                    'first' => $first
                )
            );

            $first = false;
            unset($listeTypeWishlist[$wishlist->getIdTypeWishlist()]);
        }

        // on ajoute les types possibles
        $wlTotal = array();
        foreach ($wlDisplayed as $wlParams) {
            $liste = array_merge(
                array($wlParams['params']['wishlist']->getTypeWishlist()), $listeTypeWishlist
            );

            $wlParams['params']['listeTypesWishlist'] = $liste;
            $wlTotal[] = $wlParams;
        }

        // si il reste des types à attribuer, on rajoute le formulaire de création à la fin
        if (!empty($listeTypeWishlist)) {
            $wlTotal[] = array(
                'compo' => 'new',
                'params' => array(
                    'perso' => $this->perso,
                    'listeTypesWishlist' => $listeTypeWishlist
                )
            );
        }

        $this->wlDisplayed = $wlTotal;
    }

    /**
     * action d'affichage d'une wishlist
     * @param sfWebRequest $request requete courante
     */
    public function executeFiche($request)
    {
        $listeWlObjets = array();

        // liste des tokens ramassés en raid
        $con = Propel::getConnection(ObjetPeer::DATABASE_NAME);
        $sql = ' SELECT o.*
            FROM wow_source_objet so1, wow_objet o, wow_source_objet so2
            WHERE so1.code = "token"
            AND so1.id_type = o.id_objet
            AND o.id_source_objet = so2.id_source_objet
            AND so2.code = "boss"';

        $stmt = $con->prepare($sql);
        $stmt->execute();

        $formatter = new PropelObjectFormatter();
        $formatter->setClass('Objet');
        $listeIdTokens = array_keys(
            nlMisc::indexBy('IdObjet', $formatter->format($stmt))
        );

        // objets récupérés en raid
        $listeWlObjets['raid'] = array(
            'picto' => 'skull.png',
            'label' => 'En raid',
            'data' =>
                WishlistObjetQuery::create()
                    ->join('Objet')
                    ->join('Objet.SourceObjet')
                    ->leftJoin('Attribution')

                    // ramassé directement
                    ->condition('wl_id', 'WishlistObjet.IdWishlist = ? ', $this->wishlist->getIdWishlist())
                    ->condition('source_raid', 'SourceObjet.Code in ?', array('trashs', 'zone', 'boss'))
                    ->condition('attrib', 'Attribution.IdAttribution is null')
                    ->combine(array('wl_id', 'source_raid','attrib'), 'and', 'looted')

                    // via un token
                    ->condition('wl_id', 'WishlistObjet.IdWishlist = ? ', $this->wishlist->getIdWishlist())
                    ->condition('source_token', 'SourceObjet.Code = ?', 'token')
                    ->condition('token_raid', 'SourceObjet.IdType in ?', $listeIdTokens)
                    ->condition('attrib', 'Attribution.IdAttribution is null')
                    ->combine(array('wl_id','source_token','token_raid','attrib'), 'and', 'tokenized')

                    // assemblage
                    ->where(array('looted', 'tokenized'), 'or')
                    ->orderBy('WishlistObjet.IdSlot')
                    ->find()
                    ->getData()
        );

        // objets achetés ou craft ou ailleurs
        $listeWlObjets['bought'] = array(
            'picto' => 'coins.png',
            'label' => 'Hors raids',
            'data' => WishlistObjetQuery::create()
                ->filterByIdAttribution(null)
                ->filterByIdWishlist($this->wishlist->getIdWishlist())

                ->useObjetQuery(null, ModelCriteria::INNER_JOIN)
                    ->leftJoin('SourceObjet')
                    ->condition('craft_achat','SourceObjet.Code in ?', array('craft', 'achat'))
                    ->condition('inconnu', 'Objet.IdSourceObjet is null')
                    ->where(array('craft_achat', 'inconnu'), 'or')
                ->endUse()

                ->orderBy('WishlistObjet.IdSlot')
                ->find()
                ->getData()
        );

        // objets obtenus
        $listeWlObjets['obtained'] = array(
            'picto' => 'wl_spe1.png',
            'label' => 'Obtenus',
            'data' => WishlistObjetQuery::create()
                ->innerJoin('Attribution')
                ->where('WishlistObjet.IdWishlist = ? ', $this->wishlist->getIdWishlist())
                ->orderBy('WishlistObjet.IdSlot')
                ->find()
                ->getData()
        );

        // slots vides
        $listeWlObjets['empty'] = array(
            'picto' => 'empty.png',
            'label' => 'Emplacements vides',
            'data' => WishlistObjetQuery::create()
                ->filterByIdWishlist($this->wishlist->getIdWishlist())
                ->filterByIdObjet(null)
                ->orderByIdSlot()
                ->find()
                ->getData()
        );

        $this->listeWlObjets = $listeWlObjets;
    }

    /**
     * formulaire d'édition / création d'une wishlist
     * @param sfWebRequest $request requete courante
     */
    public function executeForm($request)
    {
        $this->confIlvl = array(
            'range'  => true,
            'min'    => 476,
            'max'    => 516,
            'values' => array(476, 496),
        );

        $this->edit = !$this->wishlist->isNew();

        if($this->edit)
            $this->confIlvl['values'] = array(
                $this->wishlist->getIlevelMin(),
                $this->wishlist->getIlevelMax()
            );
    }

    /**
     * composant d'une nouvelle wishlist
     * @param sfWebRequest $request requete courante
     */
    public function executeNew($request)
    {
        $this->wishlist = new Wishlist();
    }

    /**
     * composant d'édition d'un objet dans une wishlist
     * @param sfWebRequest $request requete courante
     */
    public function executeEditWlObjet($request)
    {
        $this->forward404Unless(
            $request->hasParameter('id_wishlist_objet')
        );

        $wlObjet = WishlistObjetQuery::create()->findPk(
            $request->getParameter('id_wishlist_objet', false)
        );

        $this->forward404Unless($wlObjet);

        $wishlist = $wlObjet->getWishlist();
        $perso = $wishlist->getPerso();

        // vérification auth (admin ou détenteur)
        $this->forward404Unless(
            $this->getUser()->isAdmin()
            || $this->getUser()->load()->isMine(
                $wishlist->getIdPerso()
            )
        );

        // récupération des objets possibles pour ce slot
        $this->listeObjets = ObjetQuery::create()

            // ilevel
            ->condition('imin', 'Objet.Ilevel >= ?', $wishlist->getIlevelMin())
            ->condition('imax', 'Objet.Ilevel <= ?', $wishlist->getIlevelMax())
            ->combine(array('imin', 'imax'), 'and', 'ilvl')

            // slots
            ->condition('slot1', 'Objet.IdSlot1 = ? ', $wlObjet->getSlot()->getIdSlot())
            ->condition('slot2', 'Objet.IdSlot2 = ?', $wlObjet->getSlot()->getIdSlot())
            ->combine(array('slot1', 'slot2'), 'or', 'slot')

            // type armure
            ->condition('armor', 'Objet.IdArmorType = ? ', $perso->getClasse()->getIdArmorType())
            ->condition('no_type', 'Objet.IdArmorType IS NULL')
            ->combine(array('armor', 'no_type'), 'or', 'armor')

            // classe
            ->condition('classes', 'Objet.Classes like ? ', '%'.$perso->getClasse()->getNom().'%')
            ->condition('no_classes', 'Objet.Classes = ""')
            ->combine(array('classes', 'no_classes'), 'or', 'classe')

            // assemblage
            ->where(array('ilvl','slot','armor','classe'), 'and')
            ->orderBy('Objet.Ilevel', 'desc')
            ->find();

        $this->wlObjet = $wlObjet;
    }
}
