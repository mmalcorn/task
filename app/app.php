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
        //  <form action='/tasks' method='post'>
        //      <label for='description'>Task Description</label>
        //      <input id='description' name='description' type='text'>
        //
        //      <button type='submit'>Add task</button>
        // </form>
        // ";
        //
        // $output = $output . "
        // <form action='/delete_tasks' method='post'>
        //     <button type='submit'>delete</button>
        // </form>
        // ";

        //NOTE: give twig all the variables it needs
        return $silex_app['twig']->render('tasks.html.twig', array('tasks' => Task::getAll()));
    });

    $silex_app->post("/tasks", function() {
        $task = new Task($_POST['description']);
        $task->save();
        return "
            <h1>You created a task!</h1>
            <p>" . $task->getDescription() . "</p>
            <p><a href='/'>View your list of things to do.</a></p>
        ";
    });

    $silex_app->post('/delete_tasks', function(){

        Task::deleteAll();

        return "
            <h1>List Cleared!</h1>
            <p><a href='/'>Home</a></p>
        ";
    });

    return $silex_app;
 ?>
