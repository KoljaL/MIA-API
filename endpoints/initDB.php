<?php

if (!class_exists('RedBeanPHP\R')) {
    die('no direct loading allowed');
}

use RedBeanPHP\R as R;

if (in_array('nuke', $url)) {
    R::nuke();
    initDB();
}

/**
 * initDB()
 *
 * thanks to readbeanPHP, this funktion creates the user table and the users at once
 * the old data get removed
 *
 */
function initDB()
{
    // ceate admin user
    $user = R::dispense('user');
    $user->name = 'admin';
    $user->password = password_hash("password", PASSWORD_DEFAULT);
    $user->email = 'admin@example.com';
    $user->address = '401 E Pecan St Portageville, Missouri(MO), 63873';
    $user->avatar = 'https://avatars.steamstatic.com/00033ada8b51fb23bb355f331aafaebe1e3daf37_full.jpg';
    $user->registrationdate = date("Y-m-d H:i");
    $user->role = 'admin';
    R::store($user);

    // create first user
    $user = R::dispense('user');
    $user->name = 'user';
    $user->password = password_hash("password", PASSWORD_DEFAULT);
    $user->email = 'user@example.com';
    $user->address = '217 Slade Rd Edgefield, South Carolina(SC), 29824';
    $user->avatar = 'https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/11/11bebfc655f8ed89cf001267361e665d58b47f96_full.jpg';
    $user->registrationdate = date("Y-m-d H:i");
    $user->role = 'user';
    R::store($user);

    // create second user
    $user = R::dispense('user');
    $user->name = 'Alice';
    $user->password = password_hash("password", PASSWORD_DEFAULT);
    $user->email = 'alice+bob@secure.net';
    $user->address = '301 S 7th St Petersburg, Indiana(IN), 47567';
    $user->avatar = 'https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/01/018446c622afc97c48301a9f876b720f87c31a62_full.jpg';
    $user->registrationdate = date("Y-m-d H:i");
    $user->role = 'user';
    R::store($user);
}