<?php
    class Task{
        private $description;

        function __construct($task_description){
            $this->description = $task_description;
        }

        function getDescription(){
            return $this->description;
        }

        function setDescription($new_description)
        {
            $this_description = $new_description;

        }
        function save()
        {
            array_push($_SESSION['list_of_tasks'], $this);
        }

        static function getAll()
        {
            return $_SESSION['list_of_tasks'];
        }

        static function deleteAll()
        {
            return $_SESSION['list_of_tasks'] = array();
        }


    }
 ?>
