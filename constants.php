<?php 

class Constants
{
    const API_KEY = 'fcc0186adfa898f9ded3d6d20f009c175ff83967';
    const SCHOOL_ID = 'A1930499544';


    public static function getApiKey()
    {
        return self::API_KEY;
    }

    public static function getSchoolId()
    {
        return self::SCHOOL_ID;
    }
}

?>