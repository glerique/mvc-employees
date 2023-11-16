<div class="container">
        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Identifiant</th>
                            <th>Service</th>                           
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php

                        foreach ($departements as $departement) {
                            echo '<tr>
                            <td><a href="/mvc-employees/departement/show/'.$departement->getId().'"> ' . $departement->getId() . '</a></td>                            
                            <td>' . $departement->getName() . '</td>                            
                            <td><a href="/mvc-employees/departement/editView/'.$departement->getId().'">Modifier</a></td>
                            <td><a href="/mvc-employees/departement/delete/'.$departement->getId().'">Supprimer</a></td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>