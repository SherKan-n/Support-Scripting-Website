<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    $route['default_controller'] = 'home';
    $route['404_override'] = '';
    $route['translate_uri_dashes'] = FALSE;

    $route['login']             = 'home/login';
    $route['register']          = 'home/register';
    $route['profile']           = 'home/profile';
    $route['search']            = 'home/search';
    $route['tops']              = 'home/tops';
    $route['market']            = 'home/market';
    $route['top']               = 'home/top';
    $route['banlist']           = 'home/banlist';
    $route['online_users']      = 'home/online_users';
    $route['staff']             = 'home/staff';
    $route['upgrade']           = 'home/upgrade';
    $route['logout']            = 'home/logout';
    $route['forgot']            = 'home/forgot_password';
    $route['punish_user']       = 'home/punish_user';
    $route['policy']            = 'home/policy';
	$route['notifications']     = 'home/notifications';
    $route['minigames']         = 'home/minigames';
    
    $route['resetti'] = 'home/resetti';
