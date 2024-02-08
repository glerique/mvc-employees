<section class="hero-banner d-flex align-items-center">
  <div class="container text-center">
    <h2>Fiche employé</h2>
  </div>
</section>
<section class="contact-section area-padding">
  <div class="container">
    <div class="row">      
      <div class="col-lg-12">
        <form class="form-contact contact_form" method="post" action="">
          <div class="row">                      
            <div class="col-12">
              <div class="form-group">
                Nom : <input class="form-control" type="text" name="lastName" value="<?= $employee->getLastName(); ?>" readonly>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                Prénom : <input class="form-control" type="text" name="firstName" value="<?= $employee->getFirstName(); ?>" readonly>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                Date de naissance : <input class="form-control" type="date" name="birthDate"value="<?= $employee->getBirthDate()->format('Y-m-d'); ?>" readonly>                
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                Date d'embauche : <input class="form-control" type="date" name="hireDate" value="<?= $employee->getHireDate()->format('Y-m-d'); ?>" readonly>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                Salaire : <input class="form-control" type="text" name="salary" value="<?= $employee->getSalary(); ?>" readonly>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                Service : <input class="form-control" type="text" name="departement" value="<?= $employee->getDepartement(); ?>" readonly>
              </div>
            </div>   
          </div>          
          <div class="form-group mt-3">            
            <input type="button" class="btn btn-primary" value="Retour" onClick="document.location.href = document.referrer" />
          </div>
        </form>
      </div>
    </div>
  </div>
</section>