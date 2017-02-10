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

    // NOTE root page
    $app->get("/", function() use($app) {

        // Contact::deleteAll();
        return $app['twig']->render('address_book_home.html.twig', array( 'list_of_contacts'=>Contact::getAll() ));

    });

    // NOTE Redirect for view contacts button
    $app->post("/", function() use($app) {

        return $app->redirect('/');

    });

    // NOTE from home page 'create new contact' button
    $app->post("/create-contact", function() use($app) {

        $new_contact= new Contact($_POST['name_input'], $_POST['phone_number_input'], $_POST['address_input']);
        $new_contact->save();
        return $app['twig']->render('create_contact.html.twig', array( 'list_of_contacts'=>Contact::getAll() ));

    });

    // NOTE Redirect for create new contact form submit
    $app->post("/create-contact", function() use($app) {

        $new_contact= new Contact($_POST['name_input'], $_POST['phone_number_input'], $_POST['address_input']);
        $new_contact->save();
        return $app->redirect('/create-contact');
    });

    // NOTE from home page 'delete contacts' button
    $app->post("/delete-contacts", function() use($app) {

        Contact::deleteAll();
        return $app['twig']->render('delete_contacts.html.twig');

    });
    return $app;
?>
