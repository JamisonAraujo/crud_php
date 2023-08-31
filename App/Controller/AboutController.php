<?php

    class AboutController{
        public function index(){
            $about = file_get_contents('App/View/About.html');
            echo $about;
        }
    }