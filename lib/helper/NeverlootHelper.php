<?php

/**
 * défini un élément capable de faire replier l'élément suivant
 * @param string $name nom du couple collapser/collapsible
 */
function collapser($name)
{
    echo sprintf('data-collapsing="%s"', $name);
}

/**
 * défini un élément repliable
 * @param string $name nom du couple collapser/collapsible
 * @param bool $showDefault flag à desactiver pour cacher par défaut
 */
function collapsible($name, $showDefault = true)
{
    echo sprintf('data-collapsing="%s" style="%s"',
        $name,
        isset($_COOKIE[$name]) ? '' : $showDefault ? '' : 'display:none;'
    );
}

/**
 * défini un lanceur d'accordéon
 * @param string nom de l'accordéon
 */
function accordion($name)
{
    echo nlAccordion::get()->add($name);
}

/**
 * défini une cible d'accordéon
 * @param string nom de l'accordéon
 * @param bool $showDefault flag à activer pour afficher le 1er contenu par défaut
 */
function accordion_target($name, $showDefault = true)
{
    echo nlAccordion::get()->render($name, $showDefault);
}
