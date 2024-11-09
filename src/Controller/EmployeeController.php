<?php

namespace App\Controller;

use App\Lib\Database;
use App\Lib\Renderer;
use App\Lib\Pagination;
use App\Lib\Redirector;
use App\Entity\Employee;
use App\Lib\SessionManager;
use App\Model\EmployeeModel;
use App\Model\DepartementModel;
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;


class EmployeeController extends BaseController
{
    public function __construct(
        private readonly EmployeeModel $model,
        private readonly DepartementModel $relationModel,
        SessionManager $sessionManager,
        Redirector $redirector,
        Renderer $renderer,
    ) {
        parent::__construct($sessionManager, $redirector, $renderer);
    }

    public function index(): Response
    {
        $id = $_GET['id'];
        if (!$id or !is_int($id)) {
            return $this->redirect(
                "/"
            );
        }

        $total = $this->model->count();
        $pagination = new Pagination($total);
        $pages = $pagination->getPages();
        $currentPage = $pagination->getCurrentPage();
        $perPage = $pagination->getPerPage();
        $employees = $this->model->PaginateFindAll($id, $perPage);
        if (!$employees) {
            return $this->redirectWithError(
                "/",
                "Vous essayez de consulter une page qui n'existe pas !"
            );
        }

        return $this->renderer->render('employee/index', [
            'employees' => $employees,
            'currentPage' => $currentPage,
            'pages' => $pages,
            'sessionManager' => $this->sessionManager,
        ]);
    }

    public function show(): Response
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if (!$id or !is_int($id)) {
            return $this->redirectWithError(
                "/",
                "Merci de renseigner un id"
            );
        }
        $relation = "Departement";
        $employee = $this->model->findById($id, $relation);
        if (!$employee) {
            return $this->redirectWithError(
                "/",
                "Vous essayez de consulter un employee qui n'existe pas !"
            );
        }

        return $this->renderer->render("employee/show", compact('employee'));
    }

    public function newView(): Response
    {
        $departements = $this->relationModel->findAll();
        return $this->renderer->render('employee/new', compact('departements'));
    }

    public function new(): Response
    {
        list($employee) = $this->createEmployeeFromInput();

         if (!$employee) {
            return $this->redirectWithError(
                "/",
                "Merci de bien remplir le formulaire");
        }

        $this->model->add($employee);

        return $this->redirectWithSuccess(
            "/",
            "Employé ajouté avec succès"
        );
    }

    public function editView(): Response
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if (!$id or !is_int($id)) {
            $this->redirectWithError(
                "/",
                "Merci de renseigner un id"
            );
        }
        $model = "Departement";
        $employee = $this->model->findById($id, $model);

        if (!$employee) {
            return $this->redirectWithError(
                "/",
                "Vous essayez de modifier un employé qui n'existe pas !"
            );
        }

        $departements = $this->relationModel->findAll();
        return $this->renderer->Render("employee/edit", compact('employee', 'departements'));
    }

    public function edit(): Response
    {
        list($employee) = $this->createEmployeeFromInput();

         if (!$employee) {
            return $this->redirectWithError(
                "/",
                "Merci de bien remplir le formulaire");
        }

        $this->model->update($employee);

        return $this->redirectWithSuccess(
            "/",
            "Employé modifié avec succès"
        );
    }

    public function delete(): Response
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if (!$id or !is_int($id)) {
            return $this->redirectWithError(
                "/",
                "Merci de renseigner un id"
            );
        }
        $model = $this->model;
        $employee = $model->findById($id);
        if (!$employee) {
            return $this->redirectWithError(
                "/",
                "Vous essayez de supprimer un employé qui n'existe pas !"
            );
        }
        $model->deleteById($employee);

        return $this->redirectWithSuccess(
            "/",
            "Employé supprimé avec succès"
        );
    }

    private function createEmployeeFromInput(): array
        {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
        $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
        $birthDate = filter_input(INPUT_POST, 'birthDate', FILTER_SANITIZE_SPECIAL_CHARS);
        $hireDate = filter_input(INPUT_POST, 'hireDate', FILTER_SANITIZE_SPECIAL_CHARS);
        $salary = filter_input(INPUT_POST, 'salary', FILTER_SANITIZE_SPECIAL_CHARS);
        $departementId = filter_input(INPUT_POST, 'departementId', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$lastName || !$firstName || !$birthDate || !$hireDate || !$salary || !$departementId) {
            return [null];
        }

        $employee = new Employee([
            'id' => $id,
            'lastName' => $lastName,
            'firstName' => $firstName,
            'birthDate' => $birthDate,
            'hireDate' => $hireDate,
            'salary' => $salary,
            'departementId' => $departementId
        ]);

        return [$employee, null];
    }
}

