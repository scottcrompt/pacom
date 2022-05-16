    <!-- Formulaire d'ajout d'un cours -------------------------------->
    <!-- DatePicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

    <script>
      // DatePicker ---------------------------
      $(document).ready(function() {
        $("#datepicker").datepicker({
          minDate: 0,
          dateFormat: 'dd-mm-yy',
        }).datepicker("setDate", "0");
      });

      $(document).ready(function() {
        $("#timepicker").timepicker({
          timeFormat: 'HH:mm',
          interval: 30,
          minTime: '8:00',
          maxTime: '18:00',
          defaultTime: '11',
          dynamic: false,
          dropdown: true,
          scrollbar: true,
        });
      });
    </script>
    <!-- ------------------------------------- -->
    <div class="bg-light">
      <div class="container">
        <div class="py-5 text-center">
          <span class="logo"><img class="d-block mx-auto mb-4" src="/img/logo.jpg" alt="" width="72" height="72"></span>
          <h2>Créer un cours</h2>
        </div>
        <div class="center">
          <div class="row">
            <div class="col-md-0 order-md-0">
              <form action="/cours/register" method="post" class="needs-validation" novalidate>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="date">Date</label>
                    <input type="text" class="form-control" name="date" id="datepicker" value="" autocomplete="off" required>
                    <div class="invalid-feedback">
                      Veuillez choisir une date
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="time">Heure</label>
                    <input type="text" class="form-control" name="time" id="timepicker" value="" autocomplete="off" required>
                    <div class="invalid-feedback">
                      Veuillez choisir une heure
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="nombre de place">Nombre de places</label>
                    <input type="number" class="form-control" name="place" id="place" placeholder="" value="" required>
                    <div class="invalid-feedback">
                      Veuillez choisir un nombre de places.
                    </div>
                  </div>
                <div class="col-md-6 mb-3">
                  <label for="prix">Prix (€)</label>
                  <input type="number" class="form-control" name="prix" id="prix" placeholder="" required>
                  <div class="invalid-feedback">
                    Veuillez choisir un prix.
                  </div>
                </div>
                </div>
                <input type="hidden" name="ecurie" value="1">
                <input type="hidden" name="route" value="/cours">

                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Ajouter</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>