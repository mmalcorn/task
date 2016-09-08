<!-- //Controller -->

<?php
    require_once(__DIR__ . "/../vendor/autoload.php");
    require_once(__DIR__ . "/../src/Task.php");

    session_start();
    if (empty($_SESSION["list_of_tasks"])){
        $_SESSION["list_of_tasks"] = array();
    }

    $silex_app = new Silex\Application();

    //NOTE: link twig
    $silex_app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__ . '/../views'));


    //NOTE: Make sure that you inlcude the use ($silex_app).
    //      this is what allows us to call the render method
    $silex_app->get("/", function() use ($silex_app) {


        //NOTE: give twig all the variables it needs
        return $silex_app['twig']->render('tasks.html.twig', array('tasks' => Task::getAll()));
    });
        //NOTE: MAKE SURE THAT YOU INCLUDE THE USE ($silex_app), DAMNIT, IT IS EASY TO MISS THE SECOND TIME..
    $silex_app->post("/tasks", function() use ($silex_app) {
        $task = new Task($_POST['description']);
        $task->save();
        return $silex_app['twig']->render('create_task.html.twig', array('new_task' => $task));
    });

    $silex_app->post('/delete_tasks', function() use ($silex_app){

        Task::deleteAll();

        //NOTE: template doesn't need any other information (i.e variables), so we will not pass in an array: 
        return $silex_app['twig']->render('delete_tasks.html.twig');
    });

    return $silex_app;
 ?>
