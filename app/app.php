<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Contact.php";

    session_start();

    if (empty($_SESSION['list_of_contacts'])) {
        $_SESSION['list_of_contacts'] = array();
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use($app) {

          return $app['twig']->render('address_book_home.html.twig', array( 'list_of_contacts'=>Contact::getAll() ));

    });
    $app->post("/create-contact", function() use($app) {

          return $app['twig']->render('create_contact.html.twig');

    });
    $app->post("/delete-contacts", function() use($app) {

          return $app['twig']->render('delete_contacts.html.twig');

    });
    return $app;
?>
