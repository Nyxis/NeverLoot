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


    //---------------------------------------------------------------
    // logs
    //---------------------------------------------------------------

    /**
     * create a new log and save it
     * @param string $code
     * @param array  $var  template vars
     * @param array  $tags log tags
     * @param PDO    $con
     */
    protected function createLog($code, $vars = array(), array $tags = array(), $con = null)
    {
        $logMessage = str_replace("\n", '', $this->getPartial('log/'.$code, $vars));

        $log = new Log();
        $log->setCode($code);
        $log->setMessage($logMessage);
        $log->setTags('||'.implode('||', $tags).'||');
        $log->setDate(time());
        $log->save($con);
    }

}
