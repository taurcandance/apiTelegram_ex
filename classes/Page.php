<?php

class Page
{
    protected $twig;

    public function __construct()
    {
        $loader     = new Twig_Loader_Filesystem('templates');
        $this->twig = new Twig_Environment($loader);
    }

    public function render(array $dataToRender = null, string $apiMethodName = null)
    {
        try {
            echo $this->twig->render('index.html.twig', ['response' => $dataToRender, 'methodName' => "$apiMethodName"]);
        } catch (Exception $exception) {
            echo '<pre>Error with Twig template render '.$exception.'</pre>';
        }

        return;
    }
}