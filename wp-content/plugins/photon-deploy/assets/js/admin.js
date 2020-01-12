jQuery(document).ready(function($) {
  "use strict"; 

   // forms
   var getform = $('#photon-form');
   var submitform = $('#photon-form-submit');
   var deletelist = $('.delete-photon');

    jQuery('.photon-close-tab').on('click',function(){
    jQuery(this).toggleClass('active');
    jQuery('.collapse-tab').toggleClass('active');
    jQuery('.expand-tab').toggleClass('active');
    
  });
  
    var old_url = $('#old_url').val();
    var new_url = $('#new_url').val();
    var site_url = $('#site_url').val();
    var photon_id = $('#photon_id').val();

    if($('#old_url').length){
      if(old_url != '' && new_url != ''){
        if (new_url.match("^/")) {
          new_url = new_url;
        }else{
          new_url = "/"+new_url;
        }
        if(photon_id != ''){
          get_reports(photon_id);
          $('#brand_new_url').html('<a href="'+site_url+''+new_url+'" target="_blank">'+site_url+''+new_url+'</a>');
        }else{
          $('.photon-feed-content').html('No Reports Available yet');
          $('#brand_new_url').html(''+site_url+''+new_url+'');
        }
      }
    }

  $('#search-photon').on('change',function(){
      var search = $(this).val();
      $.ajax({
        data : {action: "photon_search_lists",type : 'search', data : search},
        type: 'POST',
      
        url: myAjax.ajaxurl,
            success: function(me){
              $('.search-results').html(me);
              
               
           }
      });
  });

  getform.on('change paste', 'input, select, textarea', function(){
    var get_name = $('#name').val();
    var old_url = $('#old_url').val();
    var new_url = $('#new_url').val();
    var site_url = $('#site_url').val();
    var photon_id = $('#photon_id').val();

    if (new_url.match("^/")) {
      new_url = new_url;
    }else{
      new_url = "/"+new_url;
    }

    if(old_url != '' && new_url != ''){
      if(photon_id != ''){
        $('#brand_new_url').html('<a href="'+site_url+''+new_url+'" target="_blank">'+site_url+''+new_url+'</a>');
      }else{
        $('.photon-feed-content').html('No Reports Available yet');
        $('#brand_new_url').html(''+site_url+''+new_url+'');
      }
    }
    
  });
  // ---- SUBMIT FORM

  submitform.on('click',function(){
    var getdata = getform.serialize();
    var photonid = $('#photon_id').val();
  
    $.ajax({
      data : {action: "photon_save_lists", data : getdata, photon_id: photonid},
      type: 'POST',
      url: myAjax.ajaxurl,
          success: function(me){
            alert('Your photon has been saved');
            window.location.href = '/wp-admin/admin.php?page=photon';       
         }
    });


  });

   // ---- DELETE LIST

   deletelist.on('click',function(){
   
    var getdata = $(this).data('id');
    $.ajax({
      data : {action: "photon_delete_lists", data : getdata},
      type: 'POST',
      url: myAjax.ajaxurl,
          success: function(me){
            $('#photon_'+getdata+'').fadeOut();
            alert('Deleted, Thank you!');
             
         }
    });

   });


   // -- GET REPORTS

   function get_reports(photon_id){
    $.ajax({
      data : {action: "photon_get_reports", photon_id: photon_id},
      type: 'POST',
      url: myAjax.ajaxurl,
          success: function(me){
            if(me.length){
              
              $('.photon-feed-content').html(me);
              get_charts();
              
            }else{
              $('.photon-feed-content').html('No Reports Available yet');
            }

             
         }
    });
   }

   function get_charts(){

      var sevendays = document.getElementById("seven-days").getContext('2d');
      var comparemonths = document.getElementById("compare-months").getContext('2d');
     
      var clicks_this_week = $('#clicks_this_week').val();
      var clicks_last_week = $('#clicks_last_week').val();
      var clicks_this_month = $('#clicks_this_month').val();
      var clicks_last_month = $('#clicks_last_month').val();
      var clicks_per_day = $('#clicks_per_day').val();
      var photon_dateone = $('#photon_dateone').val();
      var photon_datetwo = $('#photon_datetwo').val();
      var photon_datethree = $('#photon_datethree ').val();
      var photon_datefour = $('#photon_datefour').val();
      var photon_datefive = $('#photon_datefive').val();
      var photon_datesix = $('#photon_datesix').val();
      var photon_dateseven = $('#photon_dateseven').val();
      var photon_daytwo = $('#photon_daytwo').val();
      var photon_daythree = $('#photon_daythree').val();
      var photon_dayfour = $('#photon_dayfour').val();
      var photon_dayfive = $('#photon_dayfive').val();
      var photon_daysix = $('#photon_daysix').val();
      var photon_dayseven = $('#photon_dayseven').val();
      var photon_month = $('#photon_month').val();
      var photon_prev = $('#photon_prev').val();
      var photon_today = $('#photon_today').val();

      console.log(photon_month);
    // SEVEN DAYS
    
            var sevenChart = new Chart(sevendays, {
                type: 'bar',
                data: {
                    labels: [""+photon_dateone+"", ""+photon_datetwo+"", ""+photon_datethree+"", ""+photon_datefour+"", ""+photon_datefive+"", ""+photon_datesix+"", ""+photon_dateseven+""],
                    datasets: [{
                        label: ""+clicks_this_week+"",
                        data: [photon_today, photon_daytwo, photon_daythree, photon_dayfour, photon_dayfive, photon_daysix,photon_dayseven],
                        backgroundColor: [
                            'rgba(33,143,212, 1)',
                            'rgba(33,143,212, 1)',
                            'rgba(33,143,212, 1)',
                            'rgba(33,143,212, 1)',
                            'rgba(33,143,212, 1)',
                            'rgba(33,143,212, 1)',
                            'rgba(33,143,212, 1)'
                        ],
                        borderColor: [
                            'rgba(33,143,212, 1)',
                            'rgba(33,143,212, 1)',
                            'rgba(33,143,212, 1)',
                            'rgba(33,143,212, 1)',
                            'rgba(33,143,212, 1)',
                            'rgba(33,143,212, 1)',
                            'rgba(33,143,212, 1)'
                        ],
                        borderWidth: 0
                    },
                    {
                        label: ""+clicks_last_week+"",
                        data: [photon_todayLast, photon_daytwoLast, photon_daythreeLast, photon_dayfourLast,photon_dayfiveLast, photon_daysixLast,photon_daysevenLast],
                        backgroundColor: [
                            'rgba(22,100,149,  1)',
                            'rgba(22,100,149,  1)',
                            'rgba(22,100,149,  1)',
                            'rgba(22,100,149,  1)',
                            'rgba(22,100,149,  1)',
                            'rgba(22,100,149,  1)',
                            'rgba(22,100,149,  1)'
                        ],
                        borderColor: [
                            'rgba(33,143,112, 1)',
                            'rgba(33,143,112, 1)',
                            'rgba(33,143,112, 1)',
                            'rgba(33,143,112, 1)',
                            'rgba(33,143,112, 1)',
                            'rgba(33,143,112, 1)',
                            'rgba(33,143,112, 1)'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    legend: {
                        display: false,
                    },
                    
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true,
                                stepSize: 1
                            },
                            
                        }],
                        xAxes: [{
                            gridLines: {
                                display:false
                            }
                        }]
                    }
                }
            });

            // COMPARE MONTHS

            var monthsChart = new Chart(comparemonths, {
                type: 'doughnut',
                data: {
                    labels: [""+clicks_this_month+"", ""+clicks_last_month+""],
                    datasets: [{
                        label: ""+clicks_per_day+"",
                        data: [photon_month, photon_prev],
                        backgroundColor: [
                            'rgba(33,143,212, 0.8)',
                            'rgba(136,40,168, 0.8)'
                            
                        ],
                        borderColor: [
                            'rgba(33,143,212, 1)',
                            'rgba(136,40,168, 1)'
                            
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    legend: {
                        display: false,
                    },
                    
                }
            });
          
   }

   
  });