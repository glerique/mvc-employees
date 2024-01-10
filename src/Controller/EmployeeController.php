<?php

namespace App\Controller;

use DateTime;
use App\Lib\Renderer;
use App\Lib\Pagination;
use App\Entity\Employee;
use App\Controller\Controller;
use App\Model\EmployeeManager;
use App\Model\DepartementManager;


class EmployeeController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new EmployeeManager();
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

        Renderer::render("employee/listing", compact('employees', 'currentPage', 'pages'));
    }

    public function show()
    {
        $id = $_GET['id'];
        if (!$id or !is_int($id)) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Merci de renseigner un id"
            );
        }
        $employee = $this->model->findById($id);
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
        $departementManager = new DepartementManager();
        $departements = $departementManager->findAll();
        Renderer::render("employee/nouveau", compact('departements'));
    }

    public function new()
    {
        $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $birth_date = filter_input(INPUT_POST, 'birth_date', FILTER_SANITIZE_SPECIAL_CHARS);
        $hire_date = filter_input(INPUT_POST, 'hire_date', FILTER_SANITIZE_SPECIAL_CHARS);
        $salary = filter_input(INPUT_POST, 'salary', FILTER_SANITIZE_SPECIAL_CHARS);
        $departementId = filter_input(INPUT_POST, 'departementId', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$last_name || !$first_name || !$birth_date || !$hire_date || !$salary || !$departementId) {
            $this->redirectWithError(
                "/mvc-employees/employee/new",
                "Merci de bien remplir le formulaire"
            );
        }

        $manager = $this->model;
        $employee = new Employee;
        $employee->setLastname($last_name);
        $employee->setFirstName($first_name);
        $employee->setBirthDate(new DateTime($birth_date));
        $employee->setHireDate(new DateTime($hire_date));
        $employee->setSalary($salary);
        $employee->setDepartementId($departementId);
        $manager->add($employee);

        $this->redirectWithSuccess(
            "/mvc-employees/employee/index",
            "Employé ajouté avec succès"
        );
    }

    public function editView()
    {
        $id = $_GET['id'];
        if (!$id or !is_int($id)) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Merci de renseigner un id"
            );
        }
        $manager = $this->model;
        $departementManager = new DepartementManager();
        $employee = $manager->findById($id);
        if (!$employee) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Vous essayez de modifier un employé qui n'existe pas !"
            );
        }
        $departements = $departementManager->findAll();
        Renderer::Render("employee/modifier", compact('employee', 'departements'));
    }

    public function edit()
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $birth_date = filter_input(INPUT_POST, 'birth_date', FILTER_SANITIZE_SPECIAL_CHARS);;
        $hire_date = filter_input(INPUT_POST, 'hire_date', FILTER_SANITIZE_SPECIAL_CHARS);
        $salary = filter_input(INPUT_POST, 'salary', FILTER_SANITIZE_SPECIAL_CHARS);
        $departementId = filter_input(INPUT_POST, 'departementId', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$id || !$last_name || !$first_name || !$birth_date || !$hire_date || !$salary || !$departementId) {
            $this->redirectWithError(
                "/mvc-employees/employee/new",
                "Merci de bien remplir le formulaire !"
            );
        }

        $manager = $this->model;
        $employee = new Employee;
        $employee->setId($id);
        $employee->setLastName($last_name);
        $employee->setFirstName($first_name);
        $employee->setBirthDate(new DateTime($birth_date));
        $employee->setHireDate(new DateTime($hire_date));
        $employee->setSalary($salary);
        $employee->setDepartementId($departementId);
        $manager->update($employee);

        $this->redirectWithSuccess(
            "/mvc-employees/employee/index",
            "Employé modifié avec succès"
        );
    }

    public function delete()
    {
        $id = $_GET['id'];
        if (!$id or !is_int($id)) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Merci de renseigner un id"
            );
        }
        $manager = $this->model;
        $employee = $manager->findById($id);
        if (!$employee) {
            $this->redirectWithError(
                "/mvc-employees/employee/index",
                "Vous essayez de supprimer un employé qui n'existe pas !"
            );
        }
        $manager->deleteById($employee);

        $this->redirectWithSuccess(
            "/mvc-employees/employee/index",
            "Employé supprimé avec succès"
        );
    }
}
