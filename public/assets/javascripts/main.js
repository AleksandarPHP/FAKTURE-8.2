console.log('© Copyright - All rights reserved.');

var hascanceledGlobal = "0";
var hasnotshowupGlobal = "0";

function setCookie(cname, cvalue, exdays) {
  if(window.localStorage) {
      localStorage.setItem(cname, encodeURIComponent(cvalue));
  } else {
      var d = new Date();
      d.setTime(d.getTime() + (exdays*24*60*60*1000));
      var expires = "expires="+ d.toUTCString();
      document.cookie = cname + "=" + encodeURIComponent(cvalue) + ";" + expires + ";path=/";
  }
}

function getCookie(cname) {
  if(window.localStorage) {
      var value = localStorage.getItem(cname);
      if(value !== null)
          return decodeURIComponent(value)
      else
          return "";
  } else {
      var name = cname + "=";
      var decodedCookie = document.cookie;
      var ca = decodedCookie.split(';');
      for(var i = 0; i <ca.length; i++) {
          var c = decodeURIComponent(ca[i]);
          while (c.charAt(0) == ' ') {
          c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
          }
      }
      return "";
  }
}
$(document).ready(function() {
  $('#lista_klijenata').select2();
});

document.addEventListener('DOMContentLoaded', function() {
  let listaKlijenata = $('#lista_klijenata');

  listaKlijenata.on('select2:select', function (e) {
      let clientsId = e.params.data.id;

      let url = '/api/klijenti/' + clientsId; 

      fetch(url)
          .then(function(response) {
              return response.json();
          })
          .then(function(data) {
              $('#client_company').val(data.company);
              $('#jib').val(data.jib);
              $('#client_pdv').val(data.pdv);
              $('#client_address').val(data.address);
              $('#client_city').val(data.city);
              $('#client_postal_code').val(data.postal_code);
              $('#client_email').val(data.email);
              $('#client_individual').val(data.individual);
          })
          .catch(function(error) {
              console.log('Došlo je do greške:', error);
          });
  });
});
function deleteCookie(cname) {
  if(window.localStorage) {
      localStorage.removeItem(cname);
  } else {
      document.cookie = cname + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
  }
}

const buttons = document.querySelectorAll('.change-language .btn');

const checkboxes = document.querySelectorAll('.lang-checkbox');

checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', function() {
        if(this.checked) {
            checkboxes.forEach((cb) => {
                if(cb !== this) { 
                    cb.checked = false;
                }
            });
        }
    });
});

// header date-time
moment.locale('sr'); 
$(document).ready(function() {
  var momentNow = moment();
  $('#date-time').html(momentNow.format('DD.MM.YYYY.') + ' - ' + momentNow.format('HH:mm'));
  setInterval(function() {
    var momentNow = moment();
    $('#date-time').html(momentNow.format('DD.MM.YYYY.') + ' - ' + momentNow.format('HH:mm'));
  }, 1000);
});

// open/close menu
$('.app_header_menu').click(() => {
  $('.app_content_left').addClass('active');
})
$('.app_nav_close').click(() => {
  $('.app_content_left').removeClass('active');
})

$('#filter-form').submit(function() {
  $('#filter-form input, #filter-form select').filter(function() {
    return !this.value;
  }).attr('disabled', true);

  return true;
});

// datepickers
$('.datepicker-input2').daterangepicker({
  singleDatePicker: true,
  locale: {
    format: 'DD/MM/YYYY'
  }
});

$('.datepicker-input').daterangepicker({
  autoUpdateInput: false,
  singleDatePicker: true,
  locale: {
    format: 'DD/MM/YYYY'
  }
});

$('.datepicker-input').on('apply.daterangepicker', function(ev, picker) {
  $(this).val(picker.startDate.format('DD/MM/YYYY'));
});

$('.datepicker-input').on('cancel.daterangepicker', function(ev, picker) {
  $(this).val('');
});

// input files
$(document).on('change','.file_input input', function(e){
  var file = this.files[0]
  if(file) {
    $(this).siblings( "span" ).html(file.name);
  } else {
    $(this).siblings( "span" ).html("");
  }
});

function formatServices(node) {
  return $('<span style="padding-left:' + (20 * node.level) + 'px;">' + node.text + '</span>');
};

// search
$(document).ready(function() {
  if($('#specialists_select_without_clear').length) {
    $('#specialists_select_without_clear').select2({
      language: "sr",
      data: specialistData,
      templateResult: formatServices,
    });

    initializedSelect2();
  }

  if($('#services_select_without_clear').length) {
    $('#services_select_without_clear').select2({
      language: "sr",
      data: serviceData,
      templateResult: formatServices,
    });
  }

  if($('#services_select_filter').length) {
    $('#services_select_filter').select2({
      placeholder: 'Prikaži sve',
      allowClear: true,
      language: "sr",
      data: serviceData,
      templateResult: formatServices,
    });

    var id = $('#services_select_filter').attr('data-id');
    if(typeof id !== 'undefined' && id !== false && id.length) {
      $("#services_select_filter").val(id).trigger('change');
    }
  }

  if($('#services_select').length) {
    $('#services_select').select2({
      placeholder: 'Izaberite uslugu...',
      allowClear: true,
      language: "sr",
      data: serviceData,
      templateResult: formatServices,
    });

    var id = $('#services_select').attr('data-id');
    if(typeof id !== 'undefined' && id !== false && id.length) {
      $("#services_select").val(id).trigger('change');
    }
  }

  if($('#services_select_multiple').length && typeof serviceData !== "undefined") {
    $('#services_select_multiple').select2({
      placeholder: 'Izaberite usluge...',
      language: "sr",
      data: serviceData,
      templateResult: formatServices,
    });

    var id = $('#services_select_multiple').attr('data-ids');
    if(typeof id !== 'undefined' && id !== false && id.length) {
      var ids = id.split(",");
      $("#services_select_multiple").val(ids).trigger('change');
    }
  }

  $('.client_search').select2({
    dropdownParent: $('#termin_new'),
    placeholder: 'Pretraga...',
    language: "sr",
    ajax: {
      delay: 1000,
      url: home + "/pacijenti/list",
      data: function (params) {
        var query = {
          search: params.term,
          page: params.page || 1
        }
  
        return query;
      }
    }
  });
  $('.client_search2').select2({
    dropdownParent: $('#termin_edit'),
    placeholder: 'Pretraga...',
    language: "sr",
    ajax: {
      delay: 1000,
      url: home + "/pacijenti/list",
      data: function (params) {
        var query = {
          search: params.term,
          page: params.page || 1
        }
  
        return query;
      }
    }
  });
  $('.client_search, .client_search2').change(function() {
    $('.userwarning').hide();

    if((typeof $(this).select2('data')[0].has_not_show_up != 'undefined' && $(this).select2('data')[0].has_not_show_up == true) || ($(this).select2('data')[0].id != "" && hasnotshowupGlobal == "1" && typeof $(this).select2('data')[0].has_not_show_up == 'undefined')) {
      $('.notshowup').show();
    } else if((typeof $(this).select2('data')[0].has_canceled != 'undefined' && $(this).select2('data')[0].has_canceled == true) || ($(this).select2('data')[0].id != "" && hascanceledGlobal == "1" && typeof $(this).select2('data')[0].has_canceled == 'undefined')) {
      $('.canceled').show();
    }
  });
});

var isClicked = false;
$(document).ready(function() {
  $('#notification_modal').on('shown.bs.modal', function(){
    $('#addNewNotification').find('#FormSuccess').hide();
    $('#addNewNotification').find('#FormError').hide();
  });
  
  $('#addNewNotification').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var action = $(this).attr('action');
    form.find('button').text('Dodajem...');
    data = form.serialize();
    if(isClicked == false) {
      isClicked = true;
      $.ajax({
          url: action,
          method: "POST",
          headers: { 'Accept': 'application/json' },
          data: data,
          success: function(data) {
            isClicked = false;
            form.trigger("reset");
            var message = data.status;

            form.find('#FormError').hide();
            form.find('#FormSuccess').show().find('.message').html(message);
            form.find('button').text('Sačuvaj');
          }, error: function(data) {
            isClicked = false;
            var message = '';
            $.each(data.responseJSON.errors, function(key, value) {
                $.each(value, function(k, v) {
                    message += v + '<br>';
                });
            });
            form.find('#FormSuccess').hide();
            form.find('#FormError').show().find('.message').html(message);
            form.find('button').text('Sačuvaj');
          }
      });
    }
  });
  
  $('#service_modal').on('shown.bs.modal', function(){
    $('#addNewService').find('#FormSuccess').hide();
    $('#addNewService').find('#FormError').hide();
  });
  
  $('#addNewService').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var action = $(this).attr('action');
    form.find('button').text('Dodajem...');
    data = form.serialize();
    if(isClicked == false) {
      isClicked = true;
      $.ajax({
          url: action,
          method: "POST",
          headers: { 'Accept': 'application/json' },
          data: data,
          success: function(data) {
            isClicked = false;
            form.trigger("reset");
            $("#services_select").val('').trigger('change');
            var message = data.status;

            form.find('#FormError').hide();
            form.find('#FormSuccess').show().find('.message').html(message);
            form.find('button').text('Sačuvaj');
          }, error: function(data) {
            isClicked = false;
            var message = '';
            $.each(data.responseJSON.errors, function(key, value) {
                $.each(value, function(k, v) {
                    message += v + '<br>';
                });
            });
            form.find('#FormSuccess').hide();
            form.find('#FormError').show().find('.message').html(message);
            form.find('button').text('Sačuvaj');
          }
      });
    }
  });

  $('#specialist_modal').on('shown.bs.modal', function(){
    $('#addNewSpecialist').find('#FormSuccess').hide();
    $('#addNewSpecialist').find('#FormError').hide();
  });
  
  $('#addNewSpecialist').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var action = $(this).attr('action');
    form.find('button').text('Dodajem...');
    data = form.serialize();
    if(isClicked == false) {
      isClicked = true;
      $.ajax({
          url: action,
          method: "POST",
          headers: { 'Accept': 'application/json' },
          data: data,
          success: function(data) {
            isClicked = false;
            form.trigger("reset");
            $("#services_select_multiple").val([]).trigger('change');
            var message = data.status;

            form.find('#FormError').hide();
            form.find('#FormSuccess').show().find('.message').html(message);
            form.find('button').text('Sačuvaj');
          }, error: function(data) {
            isClicked = false;
            var message = '';
            $.each(data.responseJSON.errors, function(key, value) {
                $.each(value, function(k, v) {
                    message += v + '<br>';
                });
            });
            form.find('#FormSuccess').hide();
            form.find('#FormError').show().find('.message').html(message);
            form.find('button').text('Sačuvaj');
          }
      });
    }
  });

  $('#client_modal').on('shown.bs.modal', function(){
    $('#addNewClient').find('#FormSuccess').hide();
    $('#addNewClient').find('#FormError').hide();
  });
  
  $('#addNewClient').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var action = $(this).attr('action');
    form.find('button').text('Dodajem...');
    data = form.serialize();
    if(isClicked == false) {
      isClicked = true;
      $.ajax({
          url: action,
          method: "POST",
          headers: { 'Accept': 'application/json' },
          data: data,
          success: function(data) {
            isClicked = false;
            form.trigger("reset");
            var message = data.status;

            form.find('#FormError').hide();
            form.find('#FormSuccess').show().find('.message').html(message);
            form.find('button').text('Sačuvaj');
          }, error: function(data) {
            isClicked = false;
            var message = '';
            $.each(data.responseJSON.errors, function(key, value) {
                $.each(value, function(k, v) {
                    message += v + '<br>';
                });
            });
            form.find('#FormSuccess').hide();
            form.find('#FormError').show().find('.message').html(message);
            form.find('button').text('Sačuvaj');
          }
      });
    }
  });
});

var isClickedNewTermin = false;
$(document).ready(function() {
  $('#termin_new').on('shown.bs.modal', function(){
    $('.FormSuccessMessageGlobal').hide();
    $('#addNewTermin').find('.FormError').hide();
  });
  
  $('#addNewTermin').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var action = $(this).attr('action');
    form.find('button').text('Dodajem...');
    data = form.serialize();
    if(isClickedNewTermin == false) {
      isClickedNewTermin = true;
      $.ajax({
          url: action,
          method: "POST",
          headers: { 'Accept': 'application/json' },
          data: data,
          success: function(data) {
            isClickedNewTermin = false;
            form.find('.client_search').val("").trigger('change');
            form.trigger("reset");
            var message = data.status;

            form.find('.FormError').hide();
            $('.FormSuccessMessageGlobal').show().find('.message').html(message);
            form.find('button').text('Sačuvaj');
            loadTable();
            $('#termin_new').modal('hide');
          }, error: function(data) {
            isClickedNewTermin = false;
            var message = '';
            $.each(data.responseJSON.errors, function(key, value) {
                $.each(value, function(k, v) {
                    message += v + '<br>';
                });
            });
            $('.FormSuccessMessageGlobal').hide();
            form.find('.FormError').show().find('.message').html(message);
            form.find('button').text('Sačuvaj');
          }
      });
    }
  });
});

var isClickedEditTermin = false;
$(document).ready(function() {
  $('#termin_edit').on('shown.bs.modal', function(){
    $('.FormSuccessMessageGlobal').hide();
    $('#editTermin').find('.FormError').hide();
  });
  
  $('#editTermin').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var action = $(this).attr('action');
    form.find('button').text('Dodajem...');
    data = form.serialize();
    if(isClickedEditTermin == false) {
      isClickedEditTermin = true;
      $.ajax({
          url: action,
          method: "POST",
          headers: { 'Accept': 'application/json' },
          data: data,
          success: function(data) {
            isClickedEditTermin = false;
            var message = data.status;

            form.find('.FormError').hide();
            $('.FormSuccessMessageGlobal').show().find('.message').html(message);
            form.find('button').text('Sačuvaj');
            loadTable();
            $('#termin_edit').modal('hide');
          }, error: function(data) {
            isClickedEditTermin = false;
            var message = '';
            $.each(data.responseJSON.errors, function(key, value) {
                $.each(value, function(k, v) {
                    message += v + '<br>';
                });
            });
            $('.FormSuccessMessageGlobal').hide();
            form.find('.FormError').show().find('.message').html(message);
            form.find('button').text('Sačuvaj');
          }
      });
    }
  });
});

var isClickedDeleteTermin = false;
$(document).ready(function() {
  $('#deleteTermin').click(function(e) {
    e.preventDefault();
    if(confirm('Da li ste sigurni?')) {
      var form = $(this).parents().find('form');
      var action = $(this).attr('href');
      data = form.serialize();
      if(isClickedDeleteTermin == false) {
        isClickedDeleteTermin = true;
        $.ajax({
            url: action,
            method: "POST",
            headers: { 'Accept': 'application/json' },
            data: {_token: $('meta[name="csrf-token"]').attr('content'), _method: 'delete'},
            success: function(data) {
              isClickedDeleteTermin = false;
              var message = data.status;

              form.find('.FormError').hide();
              $('.FormSuccessMessageGlobal').show().find('.message').html(message);
              loadTable();
              $('#termin_edit').modal('hide');
            }, error: function(data) {
              isClickedDeleteTermin = false;
              var message = '';
              $.each(data.responseJSON.errors, function(key, value) {
                  $.each(value, function(k, v) {
                      message += v + '<br>';
                  });
              });
              $('.FormSuccessMessageGlobal').hide();
              form.find('.FormError').show().find('.message').html(message);
            }
        });
      }
    }
  });
});

// table_btn
$(document).on("click", ".table_btn", function() {
  $('.FormSuccessMessageGlobal').hide();
  $('#addNewTermin').find('.FormError').hide();
  $('#addNewTermin').find('.client_search').val("").trigger('change');
  
  var services = $(this).attr('data-services') ? $(this).attr('data-services').split(',') : [];
  var data = services.length ? serviceData.filter(function(item) {
    return jQuery.inArray(item.id + "", services) !== -1
  }) : serviceData;

  $("#addNewTermin").find('#services_select_multiple').empty().select2("destroy").select2({
    placeholder: 'Izaberite usluge...',
    language: "sr",
    data: data,
    templateResult: formatServices,
  });

  $("#addNewTermin").find('#services_select_multiple').val([]).trigger('change');
  $('#addNewTermin').trigger("reset");
  var worker = $(this).data('worker');
  var time = $(this).data('time');
  var times = $('#worker_name'+worker).data('times') != "" ? $('#worker_name'+worker).data('times').split(';') : [];
  $('#time_from').val(time);
  var to_time = time.split(':');
  to_time[0] = parseInt(to_time[0]);
  to_time[1] = parseInt(to_time[1]);

  to_time[1] += 5;
  while(to_time[1] >= 60) { to_time[0] += 1; to_time[1] -= 60; }
  to_time = pad(to_time[0], 2) + ':' + pad(to_time[1], 2);
  if($('#time_to option[value="' + to_time + '"]').length)
    $('#time_to').val(to_time);
  else
    $('#time_to').val($('#time_to option:last').val());
  
  $('#time_from option').removeClass('disabled');
  $('#time_to option').removeClass('disabled');

  times.forEach(element => {
    element = element.split('-');
    $('#time_from option[value="'+element[0]+'"]').addClass('disabled').nextAll("*:lt("+(element[1]-1)+")").addClass('disabled');
    if(element[0] != "08:00") $('#time_to option[value="'+element[0]+'"]').nextAll("*:lt("+element[1]+")").addClass('disabled');
    else $('#time_to option[value="08:05"]').addClass('disabled').nextAll("*:lt("+(element[1]-1)+")").addClass('disabled');
  });

  $('#add_datetime').text($('input[name="datum"]').val());
  $('#add_datetime').next().val($('input[name="datum"]').val());
  $('#add_worker').text($('#worker_name'+worker).text());
  $('#add_worker').next().val(worker);
  $('#add_price').val(0);
  $('#add_minutes').text(5);
});

$("#addNewTermin").find('#services_select_multiple').change(function() {
  var price = 0;
  var minutes = 0;
  $(this).val().forEach(function(item) {
    var p = serviceData.find(i => i.id == item).price;
    var m = serviceData.find(i => i.id == item).minutes;
    
    if(p == null) p = 0;
    if(m == null) m = 0;

    price += parseFloat(p);
    minutes += parseInt(m);
  });

  if(minutes < 5) minutes = 5;
  
  $('#add_price').val(price.toFixed(2));
  $('#add_minutes').text(minutes);

  var time = $('#time_from').val();
  var to_time = time.split(':');
  to_time[0] = parseInt(to_time[0]);
  to_time[1] = parseInt(to_time[1]);

  to_time[1] += minutes;
  while(to_time[1] >= 60) { to_time[0] += 1; to_time[1] -= 60; }
  to_time = pad(to_time[0], 2) + ':' + pad(to_time[1], 2);
  if($('#time_to option[value="' + to_time + '"]').length)
    $('#time_to').val(to_time);
  else
    $('#time_to').val($('#time_to option:last').val());
});

$(document).on("click", ".table_btn_edit", function() {
  $('.FormSuccessMessageGlobal').hide();
  $('#editTermin').find('.FormError').hide();
  $('#editTermin').find('.client_search2').val("").trigger('change');

  var services = $(this).attr('data-services') ? $(this).attr('data-services').split(',') : [];
  var data = services.length ? serviceData.filter(function(item) {
    return jQuery.inArray(item.id + "", services) !== -1
  }) : serviceData;

  $("#editTermin").find('#services_select_multiple').empty().select2("destroy").select2({
    placeholder: 'Izaberite usluge...',
    language: "sr",
    data: data,
    templateResult: formatServices,
  });

  $("#editTermin").find('#services_select_multiple').val([]).trigger('change');
  $('#editTermin').trigger("reset");
  var action = $(this).data('action');
  var print_url = $(this).data('print');
  var status = $(this).data('status');
  $('#editTermin').attr('action', action);
  
  if(print_url.length) {
    $('#printBtn').attr('href', print_url);
    $('#printBtn').show();
  } else {
    $('#printBtn').attr('href', print_url);
    $('#printBtn').hide();
  }
  
  $('#editStatus').val(status);

  $('#deleteTermin').attr('href', action);
  var worker = $(this).data('worker');
  var time = $(this).data('time');
  var minutes = $(this).data('minutes');
  var price = $(this).data('price');
  var servicesChoosen = $(this).attr('data-servicesChoosen') ? $(this).attr('data-servicesChoosen').split(',') : [];
  $("#editTermin").find('#services_select_multiple').val(servicesChoosen).trigger('change');
  $('#editTermin').find('.client_search2')
  var client = $(this).data('client');
  var clientname = $(this).data('clientname');
  var hascanceled = $(this).attr('data-hascanceled');
  var hasnotshowup = $(this).attr('data-hasnotshowup');
  hascanceledGlobal = hascanceled;
  hasnotshowupGlobal = hasnotshowup;
  if(client!="" && clientname!="") {
    var newOption = new Option(clientname, client, true, true);
    $('#editTermin').find('.client_search2').append(newOption).trigger('change');

    $('.userwarning').hide();
    if(hasnotshowup == "1") {
      $('.notshowup').show();
    } else if(hascanceled == "1") {
      $('.canceled').show();
    }
  }
  var times = $('#worker_name'+worker).data('times') != "" ? $('#worker_name'+worker).data('times').split(';') : [];
  $('#time_from_edit').val(time);
  var to_time = time.split(':');
  to_time[0] = parseInt(to_time[0]);
  to_time[1] = parseInt(to_time[1]);

  to_time[1] += minutes;
  while(to_time[1] >= 60) { to_time[0] += 1; to_time[1] -= 60; }
  to_time = pad(to_time[0], 2) + ':' + pad(to_time[1], 2);
  $('#time_to_edit').val(to_time);
  
  $('#time_from_edit option').removeClass('disabled');
  $('#time_to_edit option').removeClass('disabled');

  times.forEach(element => {
    element = element.split('-');
    $('#time_from_edit option[value="'+element[0]+'"]').addClass('disabled').nextAll("*:lt("+(element[1]-1)+")").addClass('disabled');
    if(element[0] != "08:00") $('#time_to_edit option[value="'+element[0]+'"]').nextAll("*:lt("+element[1]+")").addClass('disabled');
    else $('#time_to_edit option[value="08:05"]').addClass('disabled').nextAll("*:lt("+(element[1]-1)+")").addClass('disabled');
  });

  $('#edit_specialist').text($('#specialists_select_without_clear').select2('data')[0].text);
  $('#edit_datetime').text($('input[name="datum"]').val());
  $('#edit_worker').text($('#worker_name'+worker).text());
  $('#edit_price').val(price);
  $('#edit_minutes').text(minutes);
});

$("#editTermin").find('#services_select_multiple').change(function() {
  var price = 0;
  var minutes = 0;
  $(this).val().forEach(function(item) {
    var p = serviceData.find(i => i.id == item).price;
    var m = serviceData.find(i => i.id == item).minutes;
    
    if(p == null) p = 0;
    if(m == null) m = 0;

    price += parseFloat(p);
    minutes += parseInt(m);
  });

  if(minutes < 5) minutes = 5;
  
  $('#edit_price').val(price.toFixed(2));
  $('#edit_minutes').text(minutes);

  var time = $('#time_from_edit').val();
  var to_time = time.split(':');
  to_time[0] = parseInt(to_time[0]);
  to_time[1] = parseInt(to_time[1]);

  to_time[1] += minutes;
  while(to_time[1] >= 60) { to_time[0] += 1; to_time[1] -= 60; }
  to_time = pad(to_time[0], 2) + ':' + pad(to_time[1], 2);
  if($('#time_to_edit option[value="' + to_time + '"]').length)
    $('#time_to_edit').val(to_time);
  else
    $('#time_to_edit').val($('#time_to_edit option:last').val());
});

function pad(num, size) {
  var s = num+"";
  while (s.length < size) s = "0" + s;
  return s;
}

function loadTable(termin = null) {
  $('#table-content').parent().addClass('disabled');
  var specialist = $('#specialists_select_without_clear').val();
  var datetime = $('input[name="datum"]').val();
  $.get( home + '/rezervacija/table', { specialist: specialist, datetime: datetime } )
  .done(function( data ) {
    $('#table-content').html(data);
    $('#table-content').parent().removeClass('disabled');
    if(termin != null && $('.table_btn_edit[data-id="'+termin+'"]').length) $('.table_btn_edit[data-id="'+termin+'"]').trigger('click');
  })
  .fail(function() {
    alert('Došlo je do greške, molimo ponovo učitajte stranicu.');
  });
}

$(document).on("change paste keyup", "#jmbg", function() {
  var value = $(this).val();
  if(value.length >= 7) {
    var d = value.substring(0, 2);
    var m = value.substring(2, 4);
    var y = parseInt(value.substring(4, 7));

    if(y > 100) y = '1' + y;
    else y = '2' + y;

    $('#dateOfBirth').val(d+'/'+m+'/'+y);
  }
});


document.addEventListener("DOMContentLoaded", function() {
  const loader = document.getElementById('loader');

  document.querySelectorAll('.sendInvImgSpan').forEach(function(element) {
      element.addEventListener('click', function() {
          loader.style.display = 'flex'; // Prikazi loader
      });
  });
});

// dodaj robu

$(document).on('click', '.services-wrapper .add_btn', function(e) {
  e.preventDefault();
  var name = '';
  var price = '';
  var quantity = '';
  var unit_measurement = '';

  if($(this).closest('.services-wrapper').length > 0) {
    name = $(this).closest('.services-wrapper').find('input[name="naziv"]').val();
    price = $(this).closest('.services-wrapper').find('input[name="cena"]').val();
    quantity = $(this).closest('.services-wrapper').find('input[name="kolicina"]').val();
    unit_measurement = $(this).closest('.services-wrapper').find('input[name="mjerna_jedinica"]').val();
  }

  if (quantity === '') {
      alert('Morate uneti količinu.');
      return;
  }

  if (name === '' && price === '' && unit_measurement === '') {
      alert('Morate uneti naziv, cenu i mjernu jedinicu proizvoda.');
      return;
  }

  addToTable(name, price, quantity, unit_measurement);

});

var loadingAddToTable = false;
function addToTable(name, price, quantity, unit_measurement) {
  if(loadingAddToTable === false) {
    $('body').addClass('body-loading');
    loadingAddToTable = true;
    $.ajax({
      url: url + "/add-to-table",
      method: 'POST',
      headers: { 'Accept': 'application/json' },
      data: {name: name, price: price,quantity: quantity,unit_measurement: unit_measurement, _token: $('meta[name="csrf-token"]').attr('content')},
      success: function(data) {
        $('.popis-robe').html(data.data);
        $('body').removeClass('body-loading');
        $('.services-wrapper').find('input[name="naziv"]').val('');
        $('.services-wrapper').find('input[name="cena"]').val('');
        $('.services-wrapper').find('input[name="kolicina"]').val('');
        $('.services-wrapper').find('input[name="mjerna_jedinica"]').val('');
        loadingAddToTable = false;
      }, error: function(data) {
        isClicked = false;
        var message = '';
        alert('greska');
      }
    });
  }
}

$(document).on('click', '.text-center .fa-trash', function(e) {
  e.preventDefault();
  var id = $(this).data('row-id');

  deleteFromTable(id);
});

var loadingDeleteRow = false;
function deleteFromTable(id) {
  if(loadingDeleteRow === false) {
    $('body').addClass('body-loading');
    loadingDeleteRow = true;
    $.ajax({
      url: url + "/delete-to-table",
      method: 'POST',
      headers: { 'Accept': 'application/json' },
      data: {id: id, _token: $('meta[name="csrf-token"]').attr('content')},
      success: function(data) {
        loadingDeleteRow = false;
        $('.popis-robe').html(data.data);
        $('body').removeClass('body-loading');
        clickedRemoveCart = false;
      },
      error: function() {
          alert('Došlo je do greške prilikom brisanja elementa.');
      }
    });
  }
}

$(document).on('click', '.status-item', function(e) {
  e.preventDefault();
  var item = $(this).data('status-id');
  var rowId = $(this).parent().data('inv-id');

  changeStatus(item, rowId);
});

var loadingChangeStatus = false;
function changeStatus(item, rowId) {
  if(loadingChangeStatus === false) {
    $('body').addClass('body-loading');
    loadingChangeStatus = true;
    $.ajax({
      url: url + "/change-status/" + rowId,
      method: 'PUT',
      headers: { 'Accept': 'application/json' },
      data: {id: rowId, status: item, _token: $('meta[name="csrf-token"]').attr('content')},
      success: function(data) {
        loadingChangeStatus = false;
        $('body').removeClass('body-loading');
        location.reload();
      },
      error: function() {
        alert('Došlo je do greške prilikom procesa.');
      }
    });
  }
}