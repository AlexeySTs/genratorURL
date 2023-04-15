<?php
    use Route;
    use View;
    use UserController;

    return [

        //new Route('Path','Controller','Method'),

        new Route('/profile',UserController::profile()),
        new Route('/',function() {
            return View::getPage('home');
        },


    ]
?>