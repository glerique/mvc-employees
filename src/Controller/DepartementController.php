<?php

namespace App\Controller;


use App\Lib\Renderer;
use App\Lib\QueryBuilder;
use App\Entity\Departement;
use App\Lib\SessionManager;
use App\Model\DepartementModel;
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;

class DepartementController extends BaseController
{
    public function __construct(
        private readonly DepartementModel $model,
        protected readonly SessionManager $sessionManager
    ){
    }

    public function index(): Response
    {
        $departements = $this->model->findAll();

        return Renderer::render("departement/listing", [
            'departements' => $departements,
            'sessionManager' => $this->sessionManager
        ]);
    }

    public function show(): Response
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
        return Renderer::render("departement/details", compact('departement'));
    }

    public function newView(): Response
    {
        return Renderer::render("departement/nouveau");
    }

    public function new(): Response
    {
        list($departement, $redirectUrl) = $this->createDepartementFromInput();
         if (!$departement) {
            $this->redirectWithError($redirectUrl, "Merci de bien remplir le formulaire");
        }

        $this->model->add($departement);

        return $this->redirectWithSuccess(
            "/mvc-employees/departement/index",
            "Service ajouté avec succès"
        );
    }

    public function editView(): Response
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if (!$id or !is_int($id)) {
            return $this->redirectWithError(
                "/mvc-employees/departement/index",
                "Merci de renseigner un id"
            );
        }

        $departement = $this->model->findById($id);
        if (!$departement) {
            return $this->redirectWithError(
                "/mvc-employees/departement/index",
                "Vous essayé de modifier un service qui n'existe pas !"
            );
        }
        return Renderer::Render("departement/modifier", compact('departement'));
    }

    public function edit(): Response
    {
        list($departement, $redirectUrl) = $this->createDepartementFromInput();

         if (!$departement) {
           return $this->redirectWithError($redirectUrl, "Merci de bien remplir le formulaire");
        }

        $this->model->update($departement);

        return $this->redirectWithSuccess(
            "/mvc-employees/departement/index",
            "Service modifié avec succès"
        );
    }

    public function delete(): Response
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if (!$id) {
            return $this->redirectWithError(
                "/mvc-employees/departement/index",
                "Merci de renseigner un id"
            );
        }

        $model = $this->model;
        $departement = $model->findById($id);
        if (!$departement) {
            return $this->redirectWithError(
                "/mvc-employees/departement/index",
                "Vous essayé de supprimer un service qui n'existe pas !"
            );
        }
        $model->deleteById($departement);

        return $this->redirectWithSuccess(
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

