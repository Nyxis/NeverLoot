<?php

/**
 * surcharges des actions pour implémenter des comportements génériques
 *
 * @package    NeverLoot
 * @subpackage lib
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class nlActions extends sfActions
{
    //---------------------------------------------------------------
    // actions génériques
    //---------------------------------------------------------------

    /**
     * action générique d'appels de composants via ajax
     * @param sfRequest $request A request object
     */
    public function executeAjaxComponent(sfWebRequest $request)
    {
        $this->forward404Unless(
            $request->isXmlHttpRequest()
            && $request->hasParameter('component')
        );

        return $this->forwardComponent(
            $request->getParameter('component')
        );
    }


    /**
     * renvoie sur un template de component
     * @param string $component composant à appeler
     * @param string $module    module du composant (prend le courant par défaut)
     */
    protected function forwardComponent($component, $module = false)
    {
        if(empty($module))
            $module = $this->getRequestParameter('module');

        $this->component = $component;
        $this->module = $module;

        $this->setTemplate('component', 'home');

        return sfView::SUCCESS;
    }

}
