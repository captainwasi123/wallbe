var ref = $('meta[name=host]').attr('content');
var datetime = $('meta[name=datetime]').attr('content');

 $(document).ready(function(){


  timeSlider();
  
 	var val1 = 0;

   	$('.navbar-handler').children("img").click(function(){
   		if(val1==0){
   			$(this).attr("src",ref+"/public/assets/web/new/images/cross.png");
     		$('.navbar-custom').slideToggle();

     		val1 = 1;
     	
     	}
     	else {
     		$('.navbar-custom').slideToggle();
     		$(this).attr("src",ref+"/public/assets/web/new/images/hamburger.png");
     		val1 = 0;

     	}
   	});
 })


$(function() {
	$('[data-decrease]').click(decrease);
	$('[data-increase]').click(increase);
	$('[data-value]').change(valueChange);
});

function decrease() {
	var value = $(this).parent().find('[data-value]').val();
	if(value > 1) {
		value--;
		$(this).parent().find('[data-value]').val(value);
	}
}

function increase() {
	var value = $(this).parent().find('[data-value]').val();
	if(value < 100) {
		value++;
		$(this).parent().find('[data-value]').val(value);
	}
}

function valueChange() {
	var value = $(this).val();
	if(value == undefined || isNaN(value) == true || value <= 0) {
		$(this).val(1);
	} else if(value >= 101) {
		$(this).val(100);
	}
}



/***************ACCORDION CODE****************/
 $(document).ready(function() {
  

  $(".set > a").on("click", function() {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $(this)
        .siblings(".content")
        .slideUp(200);
      $(".set > a i")
        .removeClass("fa-angle-down")
        .addClass("fa-angle-right");
    } else {
      $(".set > a i")
        .removeClass("fa-angle-down")
        .addClass("fa-angle-right");
      $(this)
        .find("i")
        .removeClass("fa-angle-right")
        .addClass("fa-angle-down");
      $(".set > a").removeClass("active");
      $(this).addClass("active");
      $(".content").slideUp(200);
      $(this)
        .siblings(".content")
        .slideDown(200);
    }
  });
 

});

 

 
 $('.testimonial-slider').slick({
  dots: true,
  infinite: true,
  speed: 300,
  slidesToShow:3,
  slidesToScroll: 1,
  autoplay: true,
  focusOnSelect: true,
  autoplaySpeed: 2000,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },

    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },

    {
      breakpoint: 700,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },

    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});



$(document).ready(function() {
  $('.collapse.in').prev('.panel-heading').addClass('active');
  $('#accordion, #bs-collapse')
    .on('show.bs.collapse', function(a) {
      $(a.target).prev('.panel-heading').addClass('active');
    })
    .on('hide.bs.collapse', function(a) {
      $(a.target).prev('.panel-heading').removeClass('active');
    });
});


$(function() {
  var dateToday = new Date(datetime.replace(/-/g, "/"));
  dateToday.toUTCString();
  $( ".calendar" ).datepicker({
    dateFormat: 'dd-mm-yy',
    minDate: dateToday,
    firstDay: 1
  });
  
  $(document).on('click', '.date-picker .input', function(e){
    var $me = $(this),
        $parent = $me.parents('.date-picker');
 
  });
  
  
  $(".calendar").on("change",function(){
    var me = $(this),
        selected = me.val(),
        parent = me.parents('.date-picker');
        parent.find('.result').children('span').html(selected);
        $('#professionalBlock').html('<img src="'+ref+'/public/assets/web/new/images/loaderr.gif"/>');
        var token = $('meta[name=token]').attr('content');
        var formData = {date:selected, _token:token}; //Array 
        $('#bookingTime').html('');
        $('#booking_time').val('');
        $('#booking_date_preview').val(selected);
        setTimeout(function(){
          $.ajax({
              url : ref+"/treatments/booking/getProfessionals", // Url of backend (can be python, php, etc..)
              type: "POST", // data type (can be get, post, put, delete)
              data : formData, // data in json format
              async : false, // enable or disable async (optional, but suggested as false if you need to populate data afterwards)
              success: function(response, textStatus, jqXHR) {
                $('#professionalBlock').html(response);
                timeSlider();
                getPractitionerPrice();
              },
              error: function (jqXHR, textStatus, errorThrown) {
              console.log(jqXHR);
                  console.log(textStatus);
                  console.log(errorThrown);
              }
          });
        }, 100);
  });
});

function getPractitionerPrice(){
  var userIds = [];
   var token = $('#token').val();
   $("input:hidden[name=userIds]").each(function(){
       userIds.push($(this).val());
   });
   setTimeout(function(){
      $.post( ref+'/treatments/booking/getProfessionalsPrice', {_token: token, userIds: userIds}, function( data ) {
         data.forEach(function(item) {
            $('#practPriceTray-'+item.id).html('$'+item.price+' Inc GST');
         });
      }, 'json');
   }, 500);
}

 $('.booking-features').slick({
  dots: true,
  infinite: true,
  speed: 300,
  slidesToShow:7,
  slidesToScroll: 1,
  autoplay: false,
  focusOnSelect: false,
  autoplaySpeed: 2000,
  swipeToSlide: true,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },

    {
      breakpoint: 768,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },

    {
      breakpoint: 700,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },

    {
      breakpoint: 600,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});





function timeSlider(){

   $('.time-slider').slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow:6,
    slidesToScroll: 1,
    autoplay: false,
    focusOnSelect: true,
    autoplaySpeed: 2000,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
          infinite: true,
          dots: true
        }
      },

      {
        breakpoint: 768,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
          infinite: true,
          dots: true
        }
      },

      {
        breakpoint: 700,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
          infinite: true,
          dots: true
        }
      },

      {
        breakpoint: 600,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ]
  });
}