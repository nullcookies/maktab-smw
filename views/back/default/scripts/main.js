$(document).ready(function () {
  
  if($('textarea.ck-editor').length){
    $( 'textarea.ck-editor' ).ckeditor({
      toolbar: [
        [ 'Maximize', 'Source', 'Templates', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'TextColor', 'BGColor', '-', 'Blockquote', 'CreateDiv', '-', 'Link', 'Unlink', 'Image', 'Table', 'HorizontalRule', 'Iframe' ],
        [ 'Styles', 'Format', 'Font', 'FontSize' ]
      ]
    });
  }

  $('body').on('click', '.options-template-remove', function(e){
    e.preventDefault();
    $(this).closest('.options-template').remove();
  });

  $('body').on('click', '.option-value-remove', function(e){
    e.preventDefault();
    $(this).closest('.option-values-template').remove();
  });

  

  $('body').on('click', '.product-option-add', function(e){
    e.preventDefault();
    var type = $(this).data('type');
    var templateContainer;

    templateContainer = $('.options-' + type + '-template-raw')[0].outerHTML;
    $(templateContainer.replace(/\?\?\?/ig, $('.options-template:not(.options-template-raw)').length)).removeClass('options-template-raw').removeClass('options-' + type + '-template-raw').appendTo($('.options-container')).show();
  });

  $('body').on('click', '.option-value-add', function(e){
    e.preventDefault();
    var container = $(this).closest('.option-values-container');
    if(container.length){
      var optionTemplate = container.find('.option-values-template').eq(-1)[0].outerHTML;
      var checkRegex = /\[values\]\[(\d+)\]/gi;
      var found = checkRegex.exec(optionTemplate);
      if(found){
        var newOptionValueKey = parseInt(found[1]) + 1;
        optionTemplate = optionTemplate.replace(/(.*?\[values\]\[)(\d{1,})(\].*?)/ig, "$1" + newOptionValueKey + "$3");
        container.find('.option-values-template-container').append(optionTemplate);
        container.find('.option-values-template').eq(-1).find('input[type=text]').val('');
      }
        
    }
  });

  $('.school-group-start-11').on('change', function(){
      var currentYear = +$(this).val();
      if($('.school-group-end-11').length){
        $('.school-group-end-11').find('option[value=' + (currentYear + 11) + ']').prop('selected', true);
      }
  });

  $('.school-group-end-11').on('change', function(){
      var currentYear = +$(this).val();
      if($('.school-group-start-11').length){
        $('.school-group-start-11').find('option[value=' + (currentYear - 11) + ']').prop('selected', true);
      }
  });

  $('#price, #discount, #priceshow').on('input change', function(){

    if($('#price').length && $('#discount').length && $('#priceshow').length){
      
      $('#priceshow').html('<i class="fa fa-circle-notch-o fa-spin"></i>');
      var priceshow;
      var price = parseInt($('#price').val());
      var discount = parseInt($('#discount').val());
      if(isNaN(price)) price = 0;
      if(isNaN(discount)) discount = 0;
      priceshow = (discount > 0) ? (price * (1 - discount / 100)) : price;
      
      $('#priceshow').html(priceshow);
    }
  });

  $('#price').on('input change', function(){
    if($('#price_for_block').length && $('#price_for_dal').length){
      var unitInDal = parseInt($('#unit_in_dal').val());
      var unitInBlock = parseInt($('#unit_in_block').val());
      var unitPrice = parseInt($('#price').val());
      if(isNaN(unitInDal)) unitInDal = 0;
      if(isNaN(unitInBlock)) unitInBlock = 0;
      if(isNaN(unitPrice)) unitPrice = 0;
      $('#price_for_block').val(unitInBlock * unitPrice);
      $('#price_for_dal').val(unitInDal * unitPrice);
    }
  });

  $('#unit_in_block').on('input change', function(){
    if($('#price_for_block').length && $('#price').length){
      var unitInBlock = parseInt($('#unit_in_block').val());
      var unitPrice = parseInt($('#price').val());
      if(isNaN(unitInBlock)) unitInBlock = 0;
      if(isNaN(unitPrice)) unitPrice = 0;
      $('#price_for_block').val(unitInBlock * unitPrice);
    }
  });
  $('#unit_in_dal').on('input change', function(){
    if($('#price_for_dal').length && $('#price').length){
      var unitInDal = parseInt($('#unit_in_dal').val());
      var unitPrice = parseInt($('#price').val());
      if(isNaN(unitInDal)) unitInDal = 0;
      if(isNaN(unitPrice)) unitPrice = 0;
      $('#price_for_dal').val(unitInDal * unitPrice);
    }
  });

  $('.quarter-btn').on('shown.bs.tab', function(){
    $('.quarter-btn').removeClass('active');
    $(this).addClass('active');
  });

  $('.print-contract-table').on('click', function(){
    
    var printingCSS = '<style>table{border-collapse:collapse;font-size:12px;}table td, table th{border:1px solid #333; padding: 5px;}table tr:nth-child(2n) td{background-color: #f0f0f0;}</style>';
    var htmlToPrint = printingCSS + $('#' + $(this).data('target')).html();

    $('body').append('<iframe id="printFrame">'); //добавляем эту переменную с iframe в наш body (в самый конец)
    var doc = $('#printFrame')[0].contentDocument || $('#printFrame')[0].contentWindow.document;
    var win = $('#printFrame')[0].contentWindow || $('#printFrame')[0];
    doc.getElementsByTagName('body')[0].innerHTML = htmlToPrint;
    //console.log(doc.getElementsByTagName('body')[0].innerHTML);
    win.print();
    $('#printFrame').remove();
  });

  var dataTableLanguage = {
    "processing": "Подождите...",
    "search": "Поиск:",
    "lengthMenu": "Показать _MENU_ записей",
    "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
    "infoEmpty": "Записи с 0 до 0 из 0 записей",
    "infoFiltered": "(отфильтровано из _MAX_ записей)",
    "infoPostFix": "",
    "loadingRecords": "Загрузка записей...",
    "zeroRecords": "Записи отсутствуют.",
    "emptyTable": "В таблице отсутствуют данные",
    "paginate": {
      "first": "Первая",
      "previous": "Предыдущая",
      "next": "Следующая",
      "last": "Последняя"
    },
    "aria": {
      "sortAscending": ": активировать для сортировки столбца по возрастанию",
      "sortDescending": ": активировать для сортировки столбца по убыванию"
    }
  };

  var searchTimeout;

  if($('.data-table').length){
    $('.data-table').DataTable({
        "language": dataTableLanguage
    })
    .on( 'page.dt order.dt search.dt',  function (e){ 
        //clearTimeout(searchTimeout);
        //searchTimeout = setTimeout(initAfterAjaxLoad, 300);
    });
  }

  var dataTableAjaxObj;
  var dataTableAjax = $('.data-table-ajax');
  if(dataTableAjax.length){
    var dataTableAjaxUrl = dataTableAjax.data('ajax-url');
    var dataTableAjaxPage = dataTableAjax.data('ajax-page');

    dataTableAjaxObj = $('.data-table-ajax').DataTable({
        "language": dataTableLanguage,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": dataTableAjaxUrl,
            "type": "POST",
            "data": function(d){
              // if(dataTableAjax.data('page-start') !== '' && dataTableAjax.data('page-start') !== 'undefined'){
              //   d.page_start = dataTableAjax.data('page-start');
              // }
              // if(dataTableAjax.data('page-length')){
              //   d.page_length = dataTableAjax.data('page-length');
              // }
              // if(dataTableAjax.data('page-order-column')){
              //   d.page_order_column = dataTableAjax.data('page-order-column');
              // }
              // if(dataTableAjax.data('page-order-dir')){
              //   d.page_order_dir = dataTableAjax.data('page-order-dir');
              // }
              // d.testControl = 'control';
            }
        }

    });

    dataTableAjax.on( 'page.dt order.dt search.dt',  function (e){ 
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(initAfterAjaxLoad, 300);
        // var params = dataTableAjaxObj.ajax.params();
        // dataTableAjax.data('page-start', params.start);
        // dataTableAjax.data('page-length', params.length);
        // dataTableAjax.data('page-order-column', params.order[0].column);
        // dataTableAjax.data('page-order-dir', params.order[0].dir);
    });
  }

  // $('body').on('click', '.entry-edit-btn, .entry-delete-btn', function(e){
  //   e.preventDefault();
  //   var href = $(this).attr('href');
  //   var dataTableAjax = $('.data-table-ajax');
  //   if(dataTableAjax.length){
  //     var page_start = dataTableAjax.data('page-start');
  //     var page_length = dataTableAjax.data('page-length');
  //     var page_order_column = dataTableAjax.data('page-order-column');
  //     var page_order_dir = dataTableAjax.data('page-order-dir');
  //     href += '?' + 'page_start=' + page_start + '&' + 'page_length=' + page_length + '&' + 'page_order_column=' + page_order_column + '&' + 'page_order_dir=' + page_order_dir;
  //   }
  //   document.location.href = href;
  // });




  if($('.select2').length){
    $('.select2').select2();
  }
  if($('.image-fileinput').length){
    $('.image-fileinput').fileinput({
      language: "ru",
      allowedFileTypes: ["image"],
      allowedFileExtensions: ["jpg", "gif", "png"],
      showUpload: false,
      showRemove: false
    });
  }
  if($('.xml-fileinput').length){
    $('.xml-fileinput').fileinput({
      language: "ru",
      allowedFileExtensions: ["xml"],
      showUpload: false,
      showRemove: false
    });
  }

  if($('.daterangepicker').length){
    //$('.daterangepicker').daterangepicker();
  }
  if($('.datepicker').length){
    $('.datepicker').datepicker({
      autoclose: true,
      weekStart: 1,
      language: 'ru',
      format: 'yyyy/mm/dd'
    });
  }
  if($("#calendar").length){
    $("#calendar").datepicker({
      format: 'yyyy/mm/dd',
      weekStart: 1,
      language: 'ru',
      todayHighlight: true
    });
  }
  if($('.colorpicker').length){
    $('.colorpicker').colorpicker();
  }
  if($('.timepicker').length){
    $('.timepicker').timepicker({
      showInputs: false
    });
  }
  if($('input[type="checkbox"].minimal, input[type="radio"].minimal').length){
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
  }
  if($('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').length){
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
  }
  if($('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').length){
    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });
  }
  if($('[data-toggle=confirmation]').length){
    deleteConfirmation();
  }

  $('body').on('click', '#clean-cache', function(e){
    e.preventDefault();
    var elem = $(this);
    var elemIcon;
    var cleanUrl = $(this).attr('href');
    $.ajax({
      beforeSend: function(){
        elemIcon = elem.find('.fa').detach();
        elem.prepend('<i class="fa fa-spin fa-circle-o-notch"></i>');
      },
      url: cleanUrl
    })
    .done(function(data) {
      //console.log(data);
      elem.find('.fa').detach();
      if(data == 1){
        elem.after('<span class="btn btn-success"><i class="fa fa-check"></i></span>');
        elem.remove();
        $('#cache-size').length && $('#cache-size').html('0');
        $('#cache-synchro-size').length && $('#cache-synchro-size').html('0');
      }
      else {
        elem.prepend(elemIcon);
      }
    })
    .fail(function(data) {
      //console.log(data);
      elem.find('.fa').detach();
      elem.prepend(elemIcon);
    })
    .always(function() {
      
    });
  });

  $('body').on('click', '.save-form-btn', function(e){
    e.preventDefault();
    var form = $(this).closest('form');
    if(!form.length){
      return false;
    }
    var url = form.attr('action');
    var sendData = form.serialize();
    
    $.ajax({
      method: 'POST',
      data: sendData,
      url: url
    })
    .done(function(data) {
      //console.log(data);
    })
    .fail(function(data) {
      //console.log(data);
    })
    .always(function() {
      
    });

  });

  $('body').on('click', '.status-change', function(e){
    e.preventDefault();
    var container = $(this);
    var elem = container.find('.status-toggle');
    if(elem.length == 0){
      return false;
    }
    if(elem.hasClass('working')){
      return false;
    }

    var controller = elem.data('controller');
    var action = (elem.data('action') ? elem.data('action') : 'toggle');
    var table = elem.data('table');
    var id = elem.data('id');
    var newStatus = (elem.prop('checked')) ? '0' : '1';
    var toggleOn, toggleOff, toggleOnText, toggleOffText;

    
    if(controller && table && id){
      $.ajax({
        beforeSend: function(){
          elem.addClass('working');
          toggleOn = container.find('.toggle-on');
          toggleOff = container.find('.toggle-off');
          toggleOnText = toggleOn.text();
          toggleOffText = toggleOff.text();
          toggleOn.html('<i class="fa fa-spin fa-circle-o-notch"></i>');
          toggleOff.html('<i class="fa fa-spin fa-circle-o-notch"></i>');
        },
        url: '/admin/view/' + controller + '/' + action + '/' + id + '/' + newStatus
      })
      .done(function(data) {
        if(data == 'on'){
          elem.bootstrapToggle('on');
        }
        else if(data == 'off'){
          elem.bootstrapToggle('off');
        }
      })
      .fail(function(data) {
        //console.log(data);
      })
      .always(function(data) {
        //console.log(data);
        elem.removeClass('working');
        toggleOn.html(toggleOnText);
        toggleOff.html(toggleOffText);
      });
    }
    return false;
  });
  
  $('input.translit-from').on('input change', function(){
    var generateAlias = true;
    if($('input#alias-auto').length){
      if($('#alias-auto').prop('checked') == false){
        generateAlias = false;
      }
    }
    if(generateAlias){
      getAlias($(this));
    }
  });

  $('#alias-auto').on('change', function(){
    if($(this).prop('checked')){
      if($('input.translit-from').length){
        $('input.translit-from').each(function(){
          if($(this).val()){
            getAlias($(this));
            return false;
          }
        });
      }
    }
  });

  


  /*
  $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
  //Date range as a button
  $('#daterange-btn').daterangepicker(
      {
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      }
  );
*/

	$('body').on('click', '.translation-save', function(e){
		e.preventDefault();
		var currentButton = $(this);
		var url = currentButton.attr('href');
		var currentLandId = currentButton.data('lang-id');
		var currentId = currentButton.data('id');
		var currentInput = $('#word' + currentId).val();
		var postData = {
		  'id': currentId,
		  'content': currentInput,
		  'lang': currentLandId
		};

		$.ajax({
		  url: url,
		  method: 'POST',
		  dataType: 'json',
		  data: postData,
		  beforeSend: function(){
			currentButton.find('.fa').remove();
			currentButton.append('<i class="fa fa-circle-o-notch fa-spin"></i>');
		  }
		})
		.done(function(data){
      //console.log(data);
		  if(data.result){
  			currentButton.find('.fa').remove();
  			currentButton.append('<i class="fa fa-check"></i>');   
		  }
		  else{
  			currentButton.find('.fa').remove();
  			currentButton.append('<i class="fa fa-times"></i>');   
		  }
		})
		.fail(function(data, status){
      //console.log(data);
		  //console.log(status);
		})
		.always(function(){
		  setTimeout(function(){
			currentButton.find('.fa').remove();
			currentButton.append('<i class="fa fa-save"></i>');
		  }, 2000);
		});
	});

}); //ready end

function deleteConfirmation(){
  $('[data-toggle=confirmation]').confirmation({
    rootSelector: '[data-toggle=confirmation]',
    popout: true,
    singleton: true,
    placement: 'left'
    // other options
  });
}

function getAlias(elem){
  if(elem.val()){
    var getVal = elem.val();
    getVal=getVal.toLowerCase().replace(/'/g,'');
    getVal=getVal.replace(/,/g,'');
    getVal=getVal.replace(/\.$/g,'');
    getVal=getVal.replace(/\(/g,'');
    getVal=getVal.replace(/\)/g,'');
    getVal=getVal.replace(/\//g,'');
    getVal=getVal.replace(/\s/g,'-');
    var translitTo = urlLit(getVal, 0);
    var dataPath = elem.data('path');
    if(dataPath) {
      translitTo = dataPath + '/' + translitTo;
    }
    translitTo=translitTo.replace(/[^a-z0-9-\/]/g,'');
    $('.translit-to').val(translitTo.toString());
  }
}

function urlLit(w,v) {
  var tr='a b v g d e ["zh","j"] z i y k l m n o p r s t u f h c ch sh ["shh","shch"] ~ y ~ e yu ya ~ ["jo","e"]'.split(' ');
  var ww=''; w=w.toLowerCase().replace(/ /g,'-');
  for(i=0; i<w.length; ++i) { 
    cc=w.charCodeAt(i); ch=(cc>=1072?tr[cc-1072]:w[i]); 
    if(ch.length<3) ww+=ch; else ww+=eval(ch)[v]; 
  }
  return(ww.replace(/~/g,''));
}

function inArray(needle, haystack) {
  var length = haystack.length;
  for(var i = 0; i < length; i++) {
      if(haystack[i] == needle) return true;
  }
  return false;
}

function initAfterAjaxLoad(){
  deleteConfirmation();
  $('[data-toggle=toggle').bootstrapToggle();
}