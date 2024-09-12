  @yield('modals')
  <div class="modal default_modal fade" id="client_modal" style="z-index: 100001">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><b><i class="fas fa-user-plus"></i> Novi pacijent</b></h5>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ url('pacijenti') }}" method="post" id="addNewClient">
            <div id="FormError" style="display:none;">
              <div class="alert alert-danger">
                <strong>Greška!</strong><br>
                <div class="message"></div>
              </div>
            </div>
            <div id="FormSuccess" style="display:none;">
              <div class="alert alert-success">
                <strong>Uspjeh!</strong><br>
                <div class="message"></div>
              </div>
            </div>
            @csrf
            <div class="row">
              <div class="col-md-6">
                <h5 class="field_title">Ime *</h5>
                <input type="text" class="default_input" required name="first_name">
              </div>
              <div class="col-md-6">
                <h5 class="field_title">Prezime *</h5>
                <input type="text" class="default_input" required name="last_name">
              </div>
              <div class="col-12">
                <h5 class="field_title">Broj telefona *</h5>
                <input type="text" class="default_input" required name="phone">
              </div>
            </div>
            <button type="submit" class="button">Sačuvaj</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal default_modal fade" id="termin_new">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><b>Novi termin</b></h5>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ url('rezervacija') }}" method="post" id="addNewTermin">
            <div class="FormError" style="display:none;">
              <div class="alert alert-danger">
                <strong>Greška!</strong><br>
                <div class="message"></div>
              </div>
            </div>            
            @csrf
            <div class="row">
              <div class="col-md-6">
                <h5 class="field_title">Usluge *</h5>
                <div class="services_select_wrap mb-3">
                  <select id="services_select_multiple" class="default_select" multiple="multiple" name="services[]"></select>
                </div>
              </div>
              <div class="col-md-6">
                <h5 class="field_title">Datum *</h5>
                <p id="add_datetime"></p>
                <input type="hidden" name="datetime" />
              </div>
              <div class="col-6">
                <h5 class="field_title">Vrijeme od *</h5>
                <select class="default_select" required id="time_from" name="time_from">
                  <option value="">--:--</option>
                  @foreach (Config::get('times_from') as $time)
                  <option value="{{ $time }}">{{ $time }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-6">
                <h5 class="field_title">Vrijeme do</h5>
                <select class="default_select" required id="time_to" name="time_to">
                  <option value="">--:--</option>
                  @foreach (Config::get('times_to') as $time)
                  <option value="{{ $time }}">{{ $time }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12">
                <h5 class="field_title">Specijalista *</h5>
                <p id="add_worker"></p>
                <input type="hidden" name="worker" />
                <h5 class="field_title">Pacijent *</h5>
                <div class="client_wrap">
                  <select class="client_search" required name="client_id">
                    <option value=""></option>
                  </select>
                  <a href="#" class="client_add" data-toggle="modal" data-target="#client_modal"><i class="fa fa-user-plus"></i></a>
                </div>
                <div class="col termin_status userwarning notshowup" style="display: none; margin-bottom: 20px;">
                  <span class="canceled">Nije se pojavljivao</span>
                </div>
                <div class="col termin_status userwarning canceled" style="display: none; margin-bottom: 20px;">
                  <span class="canceled">OTKAZIVAO</span>
                </div>
              </div>
              <div class="col-6">
                <h5 class="field_title">Cijena usluge u KM *</h5>
                <input type="text" class="default_input" name="price" id="add_price">
              </div>
              <div class="col-6">
                <h5 class="field_title">Predviđeno vrijeme trajanja</h5>
                <p id="add_minutes"></p>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <button type="submit" class="button">Sačuvaj</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal default_modal fade" id="termin_edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><b>Termin</b> <a href="#" id="printBtn" class="button button_gray" target="_blank"><i class="fas fa-print"></i> Print</a></h5>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ url('termini/0') }}" method="post" id="editTermin">
            @method('PUT')
            <div class="FormError" style="display:none;">
              <div class="alert alert-danger">
                <strong>Greška!</strong><br>
                <div class="message"></div>
              </div>
            </div>
            @csrf
            <div class="row">
              <div class="col-md-6">
                <h5 class="field_title">Usluge *</h5>
                <div class="services_select_wrap mb-3">
                  <select id="services_select_multiple" class="default_select" multiple="multiple" name="services[]"></select>
                </div>
              </div>
              <div class="col-md-6">
                <h5 class="field_title">Datum *</h5>
                <p id="edit_datetime"></p>
              </div>
              <div class="col-6">
                <h5 class="field_title">Vrijeme od *</h5>
                <select class="default_select" required id="time_from_edit" name="time_from">
                  <option value="">--:--</option>
                  @foreach (Config::get('times_from') as $time)
                  <option value="{{ $time }}">{{ $time }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-6">
                <h5 class="field_title">Vrijeme do</h5>
                <select class="default_select" required id="time_to_edit" name="time_to">
                  <option value="">--:--</option>
                  @foreach (Config::get('times_to') as $time)
                  <option value="{{ $time }}">{{ $time }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12">
                <h5 class="field_title">Specijalista *</h5>
                <p id="edit_worker"></p>
                <h5 class="field_title">Pacijent *</h5>
                <div class="client_wrap">
                  <select class="client_search2" required name="client_id">
                    <option value=""></option>
                  </select>
                  <a href="#" class="client_add" data-toggle="modal" data-target="#client_modal"><i class="fa fa-user-plus"></i></a>
                </div>
                <div class="col termin_status userwarning notshowup" style="display: none; margin-bottom: 20px;">
                  <span class="canceled">Nije se pojavljivao</span>
                </div>
                <div class="col termin_status userwarning canceled" style="display: none; margin-bottom: 20px;">
                  <span class="canceled">OTKAZIVAO</span>
                </div>
              </div>
              <div class="col-6">
                <h5 class="field_title">Cijena usluge u KM *</h5>
                <input type="text" class="default_input" name="price" id="edit_price">
              </div>
              <div class="col-6">
                <h5 class="field_title">Predviđeno vrijeme trajanja</h5>
                <p id="edit_minutes"></p>
              </div>
              <div class="col-12">
                <h5 class="field_title">Status</h5>
                <select class="default_select" id="editStatus" name="status">
                  <option value="">Regularan</option>
                  <option value="not_show_up">Nije se pojavio</option>
                  <option value="canceled">Otkazao</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <button type="submit" class="button">Sačuvaj</button>
                <a href="{{ url('termini/0') }}" class="modal_delete" id="deleteTermin"><i class="fas fa-trash-alt"></i></a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- javascripts -->
  <script type="text/javascript">
    var home = "{{ url('/') }}";
    document.addEventListener("DOMContentLoaded", function() {
    const loader = document.getElementById('loader');

    // Proverite da li je loaderHidden postavljen u sesiji
    const loaderHidden = {{ session('loaderHidden', 'false') ? 'true' : 'false' }};

    if (loaderHidden) {
        loader.style.display = 'none'; // Sakrij loader
    }
});
  </script>
  @yield('variables')
  <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js" integrity="sha256-AdQN98MVZs44Eq2yTwtoKufhnU+uZ7v2kXnD5vqzZVo=" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
  <script src="//cdn.jsdelivr.net/npm/@fullcalendar/core@4.4.0/main.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/@fullcalendar/core@4.4.0/locales-all.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.4.0/main.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/i18n/sr.js"></script>
  <script src="{{ asset('assets/javascripts/main.js?v=1.9') }}"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
  @yield('scripts')
</body>

</html>