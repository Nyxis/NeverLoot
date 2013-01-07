<?php

/**
 * perso actions.
 *
 * @package    NeverLoot
 * @subpackage perso
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class persoComponents extends sfActions
{
    //---------------------------------------------------------------
    // composants de la fiche perso
    //---------------------------------------------------------------

    /**
     * module d'affichage de la fiche perso
     * @param sfRequest $request A request object
     */
    public function executePerso(sfWebRequest $request)
    {
        if (empty($this->perso)) {
            if($request->hasParameter('id_perso'))
                $this->perso = PersoQuery::create()
                    ->filterByIdPerso($request->getParameter('id_perso'))
                    ->findOne();

            else
                $this->perso = $this->getUser()->load();
        }

        $this->classe = $this->perso->getClasse();
        $this->spe1 = $this->perso->getSpeRelatedByIdSpe1();
        $this->spe2 = $this->perso->getSpeRelatedByIdSpe2();
    }

    /**
     * composant d'affichage de la liste des priorités pour la liste perso en entrée
     * @param sfWebRequest $request requete courante
     */
    public function executeListePrio($request)
    {
        if(!$this->listePersos) // pas de persos -> on prend tout
            $listePersos = PersoQuery::create()
                ->find()->getData();

        elseif(!is_array($this->listePersos))
            $listePersos = $this->listePersos->getData();

        else
            $listePersos = $this->listePersos;

        if(!usort($listePersos, array('Perso', 'triParPrio' ))) die;

        $this->listePersos = $listePersos;
    }

    /**
     * affiche un formulaire de nouveau personnage
     * @param sfWebRequest $request requete courante
     */
    public function executeForm($request)
    {
        $this->listeClasses = ClasseQuery::create()->find();
        $listeSpecs = array();

        foreach ($this->listeClasses as $classe) {
            $listeSpe = $classe->getSpes();
            foreach($listeSpe as $spe)
                $listeSpecs[$classe->getIdClasse()][$spe->getIdSpe()] = array(
                    'id' => $spe->getIdSpe(),
                    'nom' => $spe->getNom()
                );
        }

        $this->listeSpecs = json_encode($listeSpecs);
    }
}
