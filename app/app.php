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

    // search_input button
    $app->post("/search_input", function() use($app) {

        $all_contacts = Contact::getAll();
        // $search_input = (string) ('/'.$_POST['search_input'].'.'.$_POST['search_input'].'/');
        $search_input = strtoupper($_POST['search_input']);
        $search_input_array = str_split($search_input);
        // $search_input = "Ben";preg_match("/P.P/",     "PHP")
        // $_POST['search_input']
        $tempArr = array();
        foreach($all_contacts as $contact)
        {
            $current_contact_name = strtoupper($contact->getName());
            $current_contact_name_array = str_split($current_contact_name);
            $first_letter = $current_contact_name_array[0];
            if($first_letter==$search_input_array[0])
            {
                array_push($tempArr, $contact);
            }
        }
        return $app['twig']->render('search_input.html.twig', array('tempArr' => $tempArr));

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
