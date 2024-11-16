<?php

require_once "libs/router.php";
require_once 'app/controllers/controller.Reviews.php';

$router = new Router();

#                 endpoint             verbo      controller                metodo
$router->addRoute('allreviews'   ,     'GET',     'ControllerReviews',   'getAllReviews');
$router->addRoute('review/:id'  ,      'GET',     'ControllerReviews',   'getReview'   );
$router->addRoute('delreview/:id'  ,   'DELETE',  'ControllerReviews',   'deleteReview');
$router->addRoute('newreview'  ,       'POST',    'ControllerReviews',   'createReview');
$router->addRoute('updatereview/:id'  , 'PUT',    'ControllerReviews',  'updateReview');
$router->setDefaultRoute('ControllerOpiniones', 'default');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

