<?php namespace VS\ApplicationBundle\Component;

class I18N
{
    public static function Languages()
    {
        return [
            'en_US' => 'English',
            'bg_BG' => 'Bulgarian'
        ];
    }
    
    public static function LanguagesAvailable()
    {
        $langs      = self::Languages();
        $envLangs   = explode( ',', $_ENV['LANGUAGES'] );
        
        $ret        = [];
        foreach( $envLangs as $l ) {
            $ret[$l]    = isset( $langs[$l] ) ? $langs[$l] : 'Unknown';
        }
        
        return $ret;
    }
}
