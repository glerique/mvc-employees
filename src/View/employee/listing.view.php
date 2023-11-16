<div class="container">
</div>
<div class="container">
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Identifiant</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de naissance</th>
                        <th>Date d'embauche</th>
                        <th>Salaire</th>
                        <th>Service</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>

                    </tr>
                </thead>

                <tbody>
                    <?php

                    foreach ($employees as $employee) {

                        echo '<tr>
                            <td><a href="/mvc-employees/employee/show/' . $employee->getId() . '"> ' . $employee->getId() . '</a></td>                            
                            <td>' . $employee->getLastName() . '</td>
                            <td>' . $employee->getFirstName() . '</td>
                            <td>' . $employee->getBirthDate()->format('d-m-Y') . '</td>
                            <td>' . $employee->getHireDate()->format('d-m-Y') . '</td>
                            <td>' . $employee->getSalary() . '</td>
                            <td>' . $employee->getDepartement() . '</td>
                            <td><a href="/mvc-employees/employee/editView/' . $employee->getId() . '">Modifier</a></td>
                            <td><a href="/mvc-employees/employee/delete/' . $employee->getId() . '">Supprimer</a></td>
                            </tr>';
                    }
                    ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination">
                    <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                    <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                        <a href="/mvc-employees/employee/index/<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                    </li>
                    <?php for ($page = 1; $page <= $pages; $page++) : ?>
                        <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                        <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                            <a href="/mvc-employees/employee/index/<?= $page ?>" class="page-link"><?= $page ?></a>
                        </li>
                    <?php endfor ?>
                    <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                    <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                        <a href="/mvc-employees/employee/index/<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>