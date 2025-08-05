<?php


class RemoteConnectionMapperHelper
{

    /* the key here is the branch id in the table system_branches */

    protected static array $mapping = [
        '1'      => [
            'name' => 'Wazara',
            'base_url' => 'http://130.255.92.215/',
            'hostname' => '130.255.92.215',
            'username' => 'dev',
            'password' => 'dev@mysql2026',
            'database' => 'dms_wazara',
        ],
        '2'      => [
            'name' => 'Erbil',
            'base_url' => 'http://130.255.92.102/',
            'hostname' => '130.255.92.102',
            'username' => 'dev',
            'password' => 'dev@mysql2026',
            'database' => 'dms_erbil',
        ],
        '3'      => [
            'name' => 'Sulaimania',
            'base_url' => 'https://dms.midyatech.net/',
            'hostname' => '92.204.160.196',
            'username' => 'majid_db',
            'password' => 'cmnbFDSweR$231',
            'database' => 'dms_test_remote',
        ],
//        '4'      => [
//            'name' => 'Duhok',
//            'base_url' => 'http://212.237.124.38/',
//            'hostname' => '212.237.124.38',
//            'username' => 'dev',
//            'password' => 'dev@mysql2026',
//            'database' => 'dms_duhok',
//        ],
        '5'      => [
            'name' => 'Zakho',
            'base_url' => 'http://130.255.92.217/',
            'hostname' => '130.255.92.217',
            'username' => 'dev',
            'password' => 'dev@mysql2026',
            'database' => 'dms_zaxo',
        ],
        '6'      => [
            'name' => 'Rabareen',
            'base_url' => 'http://185.136.150.236/',
            'hostname' => '185.136.150.236',
            'username' => 'dev',
            'password' => 'dev@mysql2026',
            'database' => 'dms_raparin',
        ],

        '7'      => [
            'name' => 'Soran',
            'base_url' => 'http://185.136.150.237/',
            'hostname' => '185.136.150.237',
            'username' => 'dev',
            'password' => 'dev@mysql2026',
            'database' => 'dms_soran',
        ],

        '8'      => [
            'name' => 'Halabga',
            'base_url' => 'http://185.136.150.239/',
            'hostname' => '185.136.150.239',
            'username' => 'dev',
            'password' => 'dev@mysql2026',
            'database' => 'dms_halabja',
        ],

        '9'      => [
            'name' => 'Garamian',
            'base_url' => 'http://185.136.150.238/',
            'hostname' => '185.136.150.238',
            'username' => 'dev',
            'password' => 'dev@mysql2026',
            'database' => 'dms_garmian',
        ],

    ];


    public static function getLocation(string $branch_id): array
    {
        return self::$mapping[$branch_id] ?? [];
    }

    public static function all(): array
    {
        return self::$mapping;
    }
}
