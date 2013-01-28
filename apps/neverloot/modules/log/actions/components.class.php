<?php

/**
 * log components
 *
 * @package    NeverLoot
 * @subpackage perso
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class logComponents extends sfActions
{
    /**
     * performs a list action on logs
     */
    public function executeList()
    {
        $this->logsCollection = LogQuery::create()
            ->_if(!empty($this->codeFilters))
                ->filterByCode($this->codeFilters, Criteria::IN)
            ->_endif()
            ->_if(!empty($this->tagFilter))
                ->filterByTags('%||'.$this->tagFilter.'||%', Criteria::LIKE)
            ->_endif()
            ->_if(!empty($this->nbLogs))
                ->limit($this->nbLogs)
            ->_endif()
            ->orderByIdLog(Criteria::DESC)
            ->find();
    }
}
