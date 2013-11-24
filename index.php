<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once './dao/security/User.php';
include_once './daoImplementation/security/UserDao.php';
include_once './daoImplementation/security/NameDao.php';
include_once './utilities/QueryParameter.php';

$UserDao = new UserDao();
$user = new User();
$user->Id = 5;
$dbUser = $UserDao->GetList();


$NameDao = new NameDao();

$users = $UserDao->GetFilteredList(QueryParameter::Where("username", "admin"));

foreach ($users as $value) {
    print $value->Email;
}

?>