<?php

namespace App\Controller;

use App\Lib\Renderer;
use App\Lib\QueryBuilder;
use App\Entity\Departement;
use App\Controller\BaseController;
use App\Model\DepartementModel;

class DepartementController extends BaseController
{

    private $model;

    public function __construct(DepartementModel $departementModel)
    {
        $this->model = $departementModel;
       
    }

    public function index()
    {

        $departements = $this->model->findAll();

        Renderer::render("departement/listing", compact('departements'));
    }

    public function show()
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

        if (!$id) {
            $this->redirectWithError(
                "/mvc-employees/departement/index",
                "Merci de renseigner un id"
            );
        }
        $departement = $this->model->findById($id);
        if (!$departement) {
            $this->redirectWithError(
                "/mvc-employees/departement/index",
                "Vous essayé de consulter un service qui n'existe pas !"
            );
        }
        Renderer::render("departement/details", compact('departement'));
    }

    public function newView()
    {
        Renderer::render("departement/nouveau");
    }

    public function new()
    {
        list($departement, $redirectUrl) = $this->createDepartementFromInput();        
         if (!$departement) {
            $this->redirectWithError($redirectUrl, "Merci de bien remplir le formulaire");
            return;
        }     
        
        $this->model->add($departement);

        $this->redirectWithSuccess(
            "/mvc-employees/departement/index",
            "Service ajouté avec succès"
        );
    }

    public function editView()
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if (!$id or !is_int($id)) {
            $this->redirectWithError(
                "/mvc-employees/departement/index",
                "Merci de renseigner un id"
            );
        }
       
        $departement = $this->model->findById($id);
        if (!$departement) {
            $this->redirectWithError(
                "/mvc-employees/departement/index",
                "Vous essayé de modifier un service qui n'existe pas !"
            );
        }
        Renderer::Render("departement/modifier", compact('departement'));
    }

    public function edit()
    {
        list($departement, $redirectUrl) = $this->createDepartementFromInput();

         if (!$departement) {
            $this->redirectWithError($redirectUrl, "Merci de bien remplir le formulaire");
            return;
        }    
        
        $this->model->update($departement);

        $this->redirectWithSuccess(
            "/mvc-employees/departement/index",
            "Service modifié avec succès"
        );
    }

    public function delete()
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if (!$id) {
            $this->redirectWithError(
                "/mvc-employees/departement/index",
                "Merci de renseigner un id"
            );
        }

        $model = $this->model;
        $departement = $model->findById($id);
        if (!$departement) {
            $this->redirectWithError(
                "/mvc-employees/departement/index",
                "Vous essayé de supprimer un service qui n'existe pas !"
            );
        }
        $model->deleteById($departement);

        $this->redirectWithSuccess(
            "/mvc-employees/departement/index",
            "Service supprimé avec succès"
        );
    }

    private function createDepartementFromInput(): array
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);        
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);        
        if (!$name) {
            $redirectUrl = $id ? "/mvc-employees/departement/editView/$id" : "/mvc-employees/departement/newView";
            return [null, $redirectUrl];
        }

        $departement =  new Departement([
            'id' => $id,
            'name' => $name            
        ]);

        return [$departement,null];
    }
}

