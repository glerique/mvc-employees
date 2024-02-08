<section class="hero-banner d-flex align-items-center">
  <div class="container text-center">
    <h2>Ajouter un employé</h2>
  </div>
</section>
<section class="contact-section area-padding">
  <div class="container">
    <div class="row">      
      <div class="col-lg-12">
        <form class="form-contact contact_form" method="post" action="/mvc-employees/employee/new">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                Nom : <input class="form-control" type="text" name="lastName">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                Prénom : <input class="form-control" type="text" name="firstName">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                Date de naissance : <input class="form-control" type="date" name="birthDate">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                Date d'embauche : <input class="form-control" type="date" name="hireDate">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                Salaire : <input class="form-control" type="text" name="salary">
              </div>
            </div>
            <div class="col-12">
            <div class="form-group">
                <label for="service">Services : </label>
                <select class="form-control" name ="departementId">
                  <?php foreach($departements as $departement){
                  echo '<option value ='.$departement->getId().'>'.$departement->getName().'</option>';
                }
                  ?>
                </select>
              </div>
            </div>   
          </div>          
          <div class="form-group mt-3">
            <input type="submit" class="btn btn-primary" name="ajouter" value="poster">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>