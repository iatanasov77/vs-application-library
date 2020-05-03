<?php namespace VS\ApplicationBundle\Component;

class I18N
{
    public static function Languages()
    {
        return [
            'en'    => 'English',
            'en_US' => 'English',
            'bg'    => 'Bulgarian',
            'bg_BG' => 'Bulgarian'
        ];
    }
    
    public static function LanguagesAvailable()
    {
        $langs      = self::Languages();
        $envLangs   = explode( ',', $_ENV['LANGUAGES'] );
        
        $ret        = [];
        foreach( $envLangs as $l ) {
            $ret[$l]    = isset( $langs[$l] ) ? $langs[$l] : 'Lang not available in this environement';
        }
        
        return $ret;
    }
}
