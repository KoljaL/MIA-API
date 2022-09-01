<?php

use RedBeanPHP\R as R;

/**
 *
 * getProjectsFromCustomer($id)
 *
 * It returns an array of all the projects that belong to a customer
 *
 * @param id The id of the customer
 *
 * @return array of projects
 */
function getProjectsFromCustomer($id)
{
    $customer = R::load('customer', $id);

    $data = [];
    foreach ($customer->ownProjectList as $project) {
        $data[] = $project->export();
    };
    return $data;
}