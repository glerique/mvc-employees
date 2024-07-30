<?php

namespace App\Controller;

use App\Lib\Database;
use App\Lib\Renderer;
use App\Lib\Pagination;
use App\Entity\Employee;
use App\Lib\SessionManager;
use App\Model\EmployeeModel;
use App\Controller\BaseController;
use App\Model\DepartementModel;


class EmployeeController extends BaseController
{
    public function __construct(
        private readonly EmployeeModel $employeeModel,
        private readonly DepartementModel $DepartementModel,
        protected readonly SessionManager $sessionManager,
    ){
        $this->model = $employeeModel;
        $this->relationModel = $DepartementModel;
    }

    public function index()
    {
        $id = $_GET['id'];
        if (!$id or !is_int($id)) {
            $this->redirect(
                "/mvc-employees/employee/index/1"
            );
        }

        $total = $this->model->count();
        $pagination = new Pagination($total);
        $pages = $pagination->getPages();
        $currentPage = $pagination->getCurrentPage();
        $perPage = $pagination->getPerPage();
        $employees = $this->model->PaginateFindAll($id, $perPage);
        if (!$employees) {
            $this->redirectWithError(
                "/mvc-employees/employee/index/1",
                "Vous essayez de consulter une page qui n'existe pas !"
            );
        }

        Renderer::render("employee/listing", [
            'employees' => $employees,
            'currentPage' => $currentPage,
            'pages' => $pages,
            'sessionManager' => $this->sessionManager
        ]);
    }

    public function show()
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if (!$id or !is_int($id)) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Merci de renseigner un id"
            );
        }
        $relation = "Departement";
        $employee = $this->model->findById($id, $relation);
        if (!$employee) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Vous essayez de consulter un employee qui n'existe pas !"
            );
        }

        Renderer::render("employee/details", compact('employee'));
    }

    public function newView()
    {
        $departements = $this->relationModel->findAll();
        Renderer::render("employee/nouveau", compact('departements'));
    }

    public function new()
    {
        list($employee, $redirectUrl) = $this->createEmployeeFromInput();

         if (!$employee) {
            $this->redirectWithError($redirectUrl, "Merci de bien remplir le formulaire");
            return;
        }

        $this->model->add($employee);

        $this->redirectWithSuccess(
            "/mvc-employees/employee/index",
            "Employé ajouté avec succès"
        );
    }

    public function editView()
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if (!$id or !is_int($id)) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Merci de renseigner un id"
            );
        }
        $model = "Departement";
        $employee = $this->model->findById($id, $model);

        if (!$employee) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Vous essayez de modifier un employé qui n'existe pas !"
            );
        }

        $departements = $this->relationModel->findAll();
        Renderer::Render("employee/modifier", compact('employee', 'departements'));
    }

    public function edit()
    {
        list($employee, $redirectUrl) = $this->createEmployeeFromInput();

         if (!$employee) {
            $this->redirectWithError($redirectUrl, "Merci de bien remplir le formulaire");
            return;
        }

        $this->model->update($employee);

        $this->redirectWithSuccess(
            "/mvc-employees/employee/index",
            "Employé modifié avec succès"
        );
    }

    public function delete()
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if (!$id or !is_int($id)) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Merci de renseigner un id"
            );
        }
        $model = $this->model;
        $employee = $model->findById($id);
        if (!$employee) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Vous essayez de supprimer un employé qui n'existe pas !"
            );
        }
        $model->deleteById($employee);

        $this->redirectWithSuccess(
            "/mvc-employees/employee/index",
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
            $redirectUrl = $id ? "/mvc-employees/employee/editView/$id" : "/mvc-employees/employee/newView";
            return [null, $redirectUrl];
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

