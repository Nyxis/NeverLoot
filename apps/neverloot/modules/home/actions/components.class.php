<?php

/**
 * home components.
 *
 * @package    NeverLoot
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeComponents extends sfComponents
{
    /**
     * composant d'affichage du menu
     * @param sfWebRequest $request requête courante
     */
    public function executeMenu($request)
    {
        $menu = sfConfig::get('mod_home_components_menu');

        // liste des persos
        $paramsPersos = array();
        $listePersos = $this->getUser()->load()->getListePersos();
        foreach ($listePersos as $perso) {
            $paramsPersos[$perso->getNom()] = array(
                'txt' => $perso->getNom(),
                'route' => 'persoFiche',
                'params' => array(
                    'nom' => $perso->getNom(),
                    'id_perso' => $perso->getIdPerso()
                )
            );
        }

        $menu['roster']['children']['fiche']['children'] = $paramsPersos;

        // liste des soirées
        $listeSoirees = array(
            'prev' => SoireeQuery::create()
                ->filterPrev()
                ->orderByDate('desc')
                ->limit(10)
                ->find(),

            'next' => SoireeQuery::create()
                ->filterNext()
                ->orderByDate('asc')
                ->limit(10)
                ->find()
        );

        foreach ($listeSoirees as $key => $listeSoiree) {
            if (!$listeSoiree->isEmpty()) {
                $first = $listeSoiree->getFirst();
                $menu['calendrier']['children'][$key]['route'] = 'raidFiche';
                $menu['calendrier']['children'][$key]['params'] = array('id' => $first->getIdSoiree());

                foreach($listeSoiree as $soiree)
                    $menu['calendrier']['children'][$key]['children'][] = array(
                        'txt' => sprintf('%s - %s',
                            $soiree->getDate('d/m'),
                            $soiree->getNom()
                        ),
                        'route' => 'raidFiche',
                        'params' => array('id' => $soiree->getIdSoiree())
                    );
            }
        }

        /*
        // raids et boss
        $listeRaids = RaidQuery::create()->find();
        if(!empty($listeRaids))
            foreach ($listeRaids as $raid) {
                $listeBossRaid = BossQuery::create()
                    ->filterByRaid($raid)
                    ->orderByOrdre()
                    ->find();

                if(empty($listeBossRaid))
                    continue;

                $menuBoss = array();
                foreach($listeBossRaid as $boss)
                    $menuBoss[$boss->getNomFr()] = array(
                        // 'route' => 'boss',
                        'params' => array(
                            'id_boss' => $boss->getIdBoss(),
                            'nom_boss' => $boss->getNomFr(),
                            'nom_raid' => $raid->getNomFr()
                        ),
                        'txt' => $boss->getNomFr()
                    );

                $menu['raid']['children'][$raid->getNomFr()] = array(
                    // 'route' => 'raid',
                    'params' => array(
                        'id_raid' => $raid->getidRaid(),
                        'nom_raid' => $raid->getNomFr()
                    ),
                    'txt' => $raid->getNomFr(),
                    'children' => $menuBoss
                );
            }
        */

        $this->menu = $menu;
    }

}
