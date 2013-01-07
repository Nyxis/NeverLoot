<?php

/**
 * classe regroupant les utilitaires de NeverLoot
 * @package neverloot
 * @subpackage lib
 */
abstract class nlMisc
{

    /**
     * indexe une collection sur le champ en paramètre
     * et la revoie sous forme de tableau
     * @param  string $index      champ sur lequel indexer
     * @param  mixed  $collection collection ou tableau à indexer
     * @return array
     */
    public static function indexBy($index, $collection)
    {
        $return = array();

        if(($collection instanceof PropelCollection) && $collection->isEmpty())

            return $return;

        if(is_array($collection) && empty($collection))

            return $return;

        $method = sprintf('get%s',
            ucfirst($index)
        );

        foreach ($collection as $key => $value) {
            $return[$value->$method()] = $value;
        }

        return $return;
    }

    const SALT1 = 'NL';
    const SALT2 = '2011';

    /**
     * fonction d'encryptage de l'appli
     * @param  string $str chaine non cryptée
     * @return string chaine cryptée
     */
    public static function encrypt($str)
    {
        return md5($str);

        // return md5(sprintf('%s-%s_%s',
            // self::SALT1,
            // $str,
            // self::SALT2
        // ));
    }

}
