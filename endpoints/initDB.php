<?php

if (!class_exists('RedBeanPHP\R')) {
    die('no direct loading allowed');
}

use RedBeanPHP\R as R;

// R::fancyDebug();
// R::freeze(true);


// $admin = R::load('users', '2');
// print_r($admin);
// exit;

if (in_array('nuke', $url)) {
    R::nuke();
    initDB();
}


if (in_array('fake', $url)) {
    // fakerData(2, 32, 2, 2);
}






function initDB()
{
    //
    // ceate admin user
    //
    $user = R::dispense('user');
    $user->name = 'admin';
    $user->password = password_hash("password", PASSWORD_DEFAULT);
    $user->email = 'admin@example.com';
    $user->address = 'Main Rd. 22, 12234 Capital City';
    $user->avatar = 'https://i.pravatar.cc/150';
    $user->registrationdate = date("Y-m-d H:i");
    $user->role = 'admin';


    R::store($user);

    //
    // create first customer
    //
    $user = R::dispense('user');
    $user->name = 'user';
    $user->password = password_hash("password", PASSWORD_DEFAULT);
    $user->email = 'user@example.com';
    $user->address = 'Main Rd. 22, 12234 Capital City';
    $user->avatar = 'https://i.pravatar.cc/150';
    $user->registrationdate = date("Y-m-d H:i");
    $user->role = 'user';

    //
    // init projects
    //
    // $project = R::dispense('project');
    // $project->title = 'project';

    // //
    // // init appointments
    // //
    // $appointment = R::dispense('appointment');
    // $appointment->title = 'appointment';
    // $appointment->date = date("Y-m-d H:i");



    //
    // store in database
    //

    // $user->ownCustomerList[] = $user;
    // $user->ownProjectList[] = $project;
    // $user->ownAppointmentList[] = $appointment;

    // $user->ownProjectList[] = $project;
    // $user->ownAppointmentList[] = $appointment;

    // $project->ownAppointmentList[] = $appointment;

    R::store($user);
}


function fakerData($noStaff, $noCustomer, $noProject, $noAppointment)
{
    $faker = Faker\Factory::create('de_DE');

    //
    // staff
    //
    for ($i=0; $i < $noStaff; $i++) {
        // $faker->seed($i);
        $user = R::dispense('staff');
        $user->name = $faker->firstName().' '.$faker->lastName();
        $user->password = password_hash("admin", PASSWORD_DEFAULT);
        $user->email = $faker->email();
        $user->address = $faker->address();
        $user->avatar = 'https://i.pravatar.cc/150';
        $user->registrationdate = date("Y-m-d H:i");
        $user->role = 1;
        $user->permission = 1;

        //
        // customer
        //
        for ($j= 0; $j< $noCustomer ; $j++) {
            // $faker->seed($j+$i);
            $username = $faker->firstName().' '.$faker->lastName();
            $user = R::dispense('customer');
            $user->name = $username;
            $user->password = password_hash("customer", PASSWORD_DEFAULT);
            $user->email = $faker->email();
            $user->address = $faker->address();
            $user->avatar = 'https://i.pravatar.cc/150';
            $user->registrationdate = date("Y-m-d H:i");
            $user->role = 3;
            $user->permission = 3;

            //
            // project
            //
            for ($k=0; $k < $noProject; $k++) {
                // $faker->seed($k+$i+$j);
                $project = R::dispense('project');
                $project->title = explode(' ', $username)[0].'-project-'.$k;

                //
                // appointment
                //
                for ($a=0; $a < $noAppointment ; $a++) {
                    // $faker->seed($a+$k+$i+$j);
                    $appointment = R::dispense('appointment');
                    $appointment->title = explode(' ', $username)[0].'-appointment-'.$a;
                    $appointment->date = $faker->dateTimeBetween('-1 week', '+1 week');


                    //
                    // store in database
                    //
                    $user->ownCustomerList[] = $user;
                    $user->ownProjectList[] = $project;
                    $user->ownAppointmentList[] = $appointment;

                    $user->ownProjectList[] = $project;
                    $user->ownAppointmentList[] = $appointment;

                    $project->ownAppointmentList[] = $appointment;


                    R::store($user);
                } // appointment
            } // project
        } // customer
    } // staff
}




// $user = R::load('staff', 1);
// pprint($user->export());
// foreach ($user->ownCustomerList as $user) {
//     pprint($user->export());
// };











// print_r(R::dump($user));
// echo $user;






// $faker = Faker\Factory::create('de_DE');
// $faker->seed(48329);
// echo $faker->name();
// $faker->seed(48322);
// echo $faker->name();




// $shop = R::dispense('shop');
// $shop->name = 'Antiques';

// $vase = R::dispense('project');
// $vase->price = 25;
// $shop->ownProductList[] = $vase;
// R::store($shop);

// $shop = R::load('shop', 1);
// foreach ($shop->ownProductList as $project) {
//     print_r($project->export());
// } //iterate





// $admin = R::load('users', '2');
// if (!$admin['login']) {
//     $users = R::dispense('users');
//     $users['login'] = 'admin';
//     $users['password'] = password_hash('123', PASSWORD_DEFAULT);
//     $id = R::store($users);
// }




// exit;
//
// DUMMY CONTENT
//

// class_exists('BenMajor\\RedSeed\\RedSeed');
// R::seed('staff', 10, [
//   'forename' => 'nameDE()',
//   'surname' => 'lastnameDE(10,15)',
//   'email' => 'email()',
//   'text' => 'lorem(5)',
//   'color' => 'color()',
//   'date' => 'datetime()',
//   'customer' => function () {
//       return R::seed('customer', 10, [
//         'forename' => 'nameDE()',
//         'surname' => 'lastnameDE(10,15)',
//         'email' => 'email()',
//         'text' => 'lorem(5)',
//         'street' => 'street()',
//         'city' => 'city()',
//         'date' => 'datetime()',
//         'project' => function () {
//             return R::seed('project', 10, [
//                 'bodyparts' => 'bodyparts()',
//                 'text' => 'lorem(5)',
//                 'date' => 'datetime()',
//             ]);
//         }
//       ]);
//   }
// ]);

// pprint(round(1000*(microtime(true)-$start), 0).' ms', 'Executing time');