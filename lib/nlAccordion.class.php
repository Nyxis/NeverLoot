<?php
/**
 * classe de gestion des boites accordéons dans never loot
 */
class nlAccordion
{
    /** référence sur instance unique de la classe */
    protected static $instance = null;

    /**
     * renvoie l'instance unique de la classe
     * @return nlAccordion
     */
    public static function get()
    {
        return is_null(self::$instance) ? new nlAccordion() : self::$instance;
    }

    /**
     * constructeur
     */
    protected function __construct()
    {
        self::$instance = $this;
    }

    /** liste des accordéons hashés nom => compteur */
    protected $accordions = array();

    /**
     * renvoie les infos de l'élément en cours en json
     * @param  string $name nom
     * @return string
     */
    protected function renderData($name)
    {
        return sprintf('data-acc_name="%s" data-acc_id="%s"',
            $name, $this->accordions[$name]
        );
    }

    /**
     * ajoute un élément d'accordéon
     * @param string $name nom de l'accordéon
     */
    public function add($name)
    {
        if(!isset($this->accordions[$name]))
            $this->accordions[$name] = 0;

        $this->accordions[$name]++;

        return $this->renderData($name);
    }

    /**
     * renvoie l'état d'un élément d'accordéon
     * @param  bool   $show affiche l'élément ou non
     * @return string
     */
    public function render($name, $showDefault = true)
    {
        $show = false;

        // 1er élément, pas de cookie et affiché par défaut -> on affiche
        if(!isset($_COOKIE[$name]) && $showDefault && $this->accordions[$name] == 1)
            $show = true;

        // si la valeur du cookie est celle de l'id de l'élément d'accordéon
        if(isset($_COOKIE[$name]) && $this->accordions[$name] == $_COOKIE[$name])
            $show = true;

        return sprintf('%s style="%s"',
            $this->renderData($name),
            $show ? '' : 'display:none;'
        );
    }

}
