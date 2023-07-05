<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$base = parse_url($path, PHP_URL_PATH);
$query = parse_url($path, PHP_URL_QUERY);

//PetController
Routing::get('', 'PetController');
Routing::get('home', 'PetController');
Routing::get('pet', 'PetController');
Routing::post('addPetForm', 'PetController');
Routing::post('changeCity', 'PetController');

//DefaultController
Routing::get('login', 'DefaultController');
Routing::get('register', 'DefaultController');
Routing::get('statute', 'DefaultController');
Routing::get('contact', 'DefaultController');
Routing::get('privacyPolicy', 'DefaultController');
Routing::get('addPet', 'DefaultController');

//SecurityController
Routing::post('checkLogin', 'SecurityController');
Routing::post('checkRegister', 'SecurityController');

//SessionController
Routing::post('logout', 'SessionController');

Routing::run($base, $query);