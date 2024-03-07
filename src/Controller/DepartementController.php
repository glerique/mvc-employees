<?php

namespace App\Controller;

use App\Lib\Renderer;
use App\Entity\Departement;
use App\Controller\Controller;
use App\Model\DepartementModel;

class DepartementController extends Controller
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
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);


        $model = $this->model;
        $departement = new Departement(['name' => $name]);
        $model->add($departement);

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
        $model = $this->model;
        $departement = $model->findById($id);
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
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$id || !$name) {
            $this->redirectWithError(
                "/mvc-employees/departement/editView",
                "Merci de bien remplir le formulaire !"
            );
        }

        $model = $this->model;
        $departement = new Departement([
            'id' => $id,
            'name' => $name
        ]);
        $model->update($departement);

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
}
