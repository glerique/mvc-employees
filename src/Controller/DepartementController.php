<?php

namespace App\Controller;

use App\Lib\Renderer;
use App\Lib\Redirector;
use App\Entity\Departement;
use App\Lib\SessionManager;
use App\Model\DepartementModel;
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class DepartementController extends BaseController
{
    protected const DEFAULT_ROUTE = 'departement_index';

    public function __construct(
        private readonly DepartementModel $model,
        SessionManager $sessionManager,
        Redirector $redirector,
        Renderer $renderer,
        RouterInterface $router,
    ) {
        parent::__construct($sessionManager, $redirector, $renderer, $router);
    }

    public function index(): Response
    {
        $departements = $this->model->findAll();

        return $this->renderer->render("departement/index", [
            'departements' => $departements,
            'sessionManager' => $this->sessionManager,
        ]);
    }

    public function show(Request $request): Response
    {
        $id = $request->get('id');
        $departement = $this->model->findById($id);
        if (!$departement) {
            return $this->redirectWithError(
                $this->getIndexRoute(),
                "Vous essayez de consulter un service qui n'existe pas !"
            );
        }
        return $this->renderer->render("departement/show", compact('departement'));
    }

    public function newView(): Response
    {
        return $this->renderer->render("departement/new");
    }

    public function new(): Response
    {
        $departement = $this->createDepartementFromInput();

        if (!$departement) {
            return $this->redirectWithError(
                $this->getIndexRoute(),
                "Merci de bien remplir le formulaire"
            );
        }

        $this->model->add($departement);

        return $this->redirectWithSuccess(
            $this->getIndexRoute(),
            "Service ajouté avec succès"
        );
    }

    public function editView(Request $request): Response
    {
        $id = $request->get('id');

        $departement = $this->model->findById($id);
        if (!$departement) {
            return $this->redirectWithError(
                $this->getIndexRoute(),
                "Vous essayez de modifier un service qui n'existe pas !"
            );
        }
        return $this->renderer->render("departement/edit", compact('departement'));
    }

    public function edit(): Response
    {
        $departement = $this->createDepartementFromInput();

        if (!$departement) {
            return $this->redirectWithError(
                $this->getIndexRoute(),
                "Merci de bien remplir le formulaire"
            );
        }

        $this->model->update($departement);

        return $this->redirectWithSuccess(
            $this->getIndexRoute(),
            "Service modifié avec succès"
        );
    }

    public function delete(Request $request): Response
    {
        $id = $request->get('id');

        $departement = $this->model->findById($id);
        if (!$departement) {
            return $this->redirectWithError(
                $this->getIndexRoute(),
                "Vous essayez de supprimer un service qui n'existe pas !"
            );
        }
        $this->model->deleteById($departement);

        return $this->redirectWithSuccess(
            $this->getIndexRoute(),
            "Service supprimé avec succès"
        );
    }

    private function createDepartementFromInput(): ?Departement
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$name) {
            return null;
        }

        $departement =  new Departement([
            'id' => $id,
            'name' => $name
        ]);

        return $departement;
    }
}
