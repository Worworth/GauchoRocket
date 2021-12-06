<?php
class PerfilController
{
    private $perfilModel;
    private $printer;

    public function __construct($perfilModel, $printer)
    {
        $this->perfilModel = $perfilModel;
        $this->printer = $printer;
    }
    public function show()
    {   
        
        echo $this->printer->render("view/perfilView.html");
    }
}