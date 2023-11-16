<section class="hero-banner d-flex align-items-center">
  <div class="container text-center">
    <h2>modifier un employé</h2>   
  </div>
</section>
<section class="contact-section area-padding">
  <div class="container">
    <div class="row">      
      <div class="col-lg-12">
        <form class="form-contact contact_form" method="post" action="/mvc-employees/employee/edit">
          <div class="row">
          <div class="col-12">
              <div class="form-group">
                <input class="form-control" type="hidden" name="id" value="<?= $employee->getId(); ?>">
              </div>
            </div>            
            <div class="col-12">
              <div class="form-group">
                Nom : <input class="form-control" type="text" name="last_name" value="<?= $employee->getLastName(); ?>">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                Prénom : <input class="form-control" type="text" name="first_name" value="<?= $employee->getFirstName(); ?>">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                Date de naissance : <input class="form-control" type="date" name="birth_date"value="<?= $employee->getBirthDate(); ?>">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                Date d'embauche : <input class="form-control" type="date" name="hire_date" value="<?= $employee->getHireDate(); ?>">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                Salaire : <input class="form-control" type="text" name="salary" value="<?= $employee->getSalary(); ?>">
              </div>
            </div>
             <div class="col-12">
            <div class="form-group">
                <label for="service">Services : </label>
                <select class="form-control" name ="departementId">
                <?php 
                foreach ($departements as $departement){ ?>
                  <option value ="<?= $departement->getId();?>"<?= ($departement->getId() === $employee->getDepartementId()) ? "selected" : "" ?>><?= $departement->getName(); ?> </option>
                  <?php } ?>
                  ?>
                </select>
              </div>
            </div>  
          </div>          
          <div class="form-group mt-3">
            <input type="submit" class="btn btn-primary" name="modifier" value="modifier">
            <input type="button" class="btn btn-primary" value="Retour" onClick="document.location.href = document.referrer" />
          </div>
        </form>
      </div>
    </div>
  </div>
</section>