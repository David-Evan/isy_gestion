<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class GravatarExtension extends AbstractExtension
{
    const GRAVATAR_DEFAULT_URL = 'http://projects.exanys.fr/discovery/images/default-avatar.png';
    const GRAVATAR_SIZE = 100;

    public function getFilters()
    {
        return array(
            new TwigFilter('gravatar', array($this, 'getGravatar')),
        );
    }

    public function getGravatar($email){
        $gravURL = 'https://www.gravatar.com/avatar/'. md5( strtolower( trim( $email ) ) ) 
                    .'?d=' . urlencode( self::GRAVATAR_DEFAULT_URL )
                    .'&s=' . self::GRAVATAR_SIZE;

        return $gravURL;
     }
}