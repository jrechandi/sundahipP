<?php
/**
 * Tools:       Herramientas varias
 *
 * @package     Sunahip
 * @subpackage  Common
 * @author      Reynier Perez Mira <reynierpm@gmail.com>
 */

namespace Sunahip\CommonBundle\Tools;

class StringTools
{

    /**
     * Genera una cadena aleatoria del tamaño especificado
     *
     * @param int $length
     *
     * @return String
     */
    public static function generateRandomString($length = 250)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    /**
     * Genera una cadena numerica aleatoria del tamaño especificado
     *
     * @param int $length
     *
     * @return String
     */
    public static function generateRandomNumeric($length = 250)
    {
        $characters = '0123456789';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    /**
     * Autogeneracion del alias de usuario
     *
     * @param string $alias
     * @param string $fqcn
     * @param EntityManager $objectManager
     *
     * @return string
     */
    public static function generateAlias($alias, $fqcn = null, $objectManager = null)
    {
        $alias = StringTools::replaceCharacters($alias);

        if ($fqcn !== null && is_object($objectManager)) {
            $entity = $objectManager->getRepository($fqcn)->findOneByAlias($alias);

            if ($entity) {
                $inc = ((int)filter_var($alias, FILTER_SANITIZE_NUMBER_INT)) + 1;
                $base = str_replace(' ', '', trim(StringTools::replaceCharacters($alias)));

                $alias = $base . $inc;
                $alias = StringTools::generateAlias($alias, $fqcn, $objectManager);
            }
        }

        return $alias;
    }

    /**
     * Remplaza caracteres con tildes por sus homologos
     *
     * @param $string
     *
     * @return string
     */
    public static function replaceCharacters($string)
    {
        $ts = array(
            "/[À-Å]/",
            "/Æ/",
            "/Ç/",
            "/[È-Ë]/",
            "/[Ì-Ï]/",
            "/Ð/",
            "/Ñ/",
            "/[Ò-ÖØ]/",
            "/×/",
            "/[Ù-Ü]/",
            "/[Ý-ß]/",
            "/[à-å]/",
            "/æ/",
            "/ç/",
            "/[è-ë]/",
            "/[ì-ï]/",
            "/ð/",
            "/ñ/",
            "/[ò-öø]/",
            "/÷/",
            "/[ù-ü]/",
            "/[ý-ÿ]/"
        );
        $tn = array(
            "A",
            "AE",
            "C",
            "E",
            "I",
            "D",
            "N",
            "O",
            "X",
            "U",
            "Y",
            "a",
            "ae",
            "c",
            "e",
            "i",
            "d",
            "n",
            "o",
            "x",
            "u",
            "y"
        );
        return str_replace(' ', '', preg_replace($ts, $tn, $string));
    }

}
