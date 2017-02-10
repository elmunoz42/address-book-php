<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Contact.php";

    session_start();

    if (empty($_SESSION['list_of_contacts'])) {
        $_SESSION['list_of_contacts'] = array();
    }

    $app = new Silex\Application();

    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use($app) {

        return $app['twig']->render('address_book_home.html.twig', array( 'list_of_contacts'=>Contact::getAll() ));

    });

    //Redirect for view contacts button
    $app->post("/", function() use($app) {

        $sample_contact= new Contact("Carlos Munoz Kampff","510-859-8763", "Boones Ferry Road, PDX");
        $sample_contact->save();
        return $app->redirect('/');

    });
    $app->post("/create-contact", function() use($app) {

        return $app['twig']->render('create_contact.html.twig');

    });

    //Redirect for create new contact form submit
    $app->post("/create-contact", function() use($app) {

        $new_contact= new Contact("Carlos Munoz Kampff","510-859-8763", "Boones Ferry Road, PDX");
        $new_contact->save();
        return $app->redirect('/create-contact');

    });
    $app->post("/delete-contacts", function() use($app) {

        return $app['twig']->render('delete_contacts.html.twig');

    });
    return $app;
?>
