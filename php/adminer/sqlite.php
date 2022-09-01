<?php

function adminer_object()
{
    include_once "plugins/plugin.php";
    include_once "plugins/login-password-less.php";


    // Plugins auto-loader.
    foreach (glob("plugins/*.php") as $filename) {
        include_once "./$filename";
    }

    // Specify enabled plugins here.
    $plugins = [
      new AdminerLoginPasswordLess(password_hash("YOUR_PASSWORD_HERE", PASSWORD_DEFAULT)),
                new AdminerTheme("default-blue"),
        ];




    class AdminerCustomization extends AdminerPlugin
    {
        public function name()
        {
            return 'PHPMiaAdmin';
        }

        public function loginFormField($name, $heading, $value)
        {
            return parent::loginFormField($name, $heading, str_replace('value="server"', 'value="sqlite"', $value));
        }
        // public function database()
        // {
        //     return "../../db/test.sqlite";
        // }
    }

    return new AdminerCustomization($plugins);
}


require __DIR__ . '/../config.php';


$_GET['sqlite']='';
$_GET['db']='../../db/'.$conf['DB_filename'];


include "adminer.php";
