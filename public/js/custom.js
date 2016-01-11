
  $(window).load(function(e) {
        $("#bn1").breakingNews({
      effect    :"slide-h",
      autoplay  :true,
      timer   :8000,
      color   :"red"
    }); 
    });
  $(document).ready(function() {

   

      var owl = $("#owl-demo");

      owl.owlCarousel({

      items : 6, //10 items above 1000px browser width
      itemsDesktop : [1000,5], //5 items between 1000px and 901px
      itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
      itemsTablet: [600,2], //2 items between 600 and 0;
      itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
      
      });

      // Custom Navigation Events
      $(".next").click(function(){
        owl.trigger('owl.next');
      })
      $(".prev").click(function(){
        owl.trigger('owl.prev');
      })
      $(".play").click(function(){
        owl.trigger('owl.play',1000);
      })
      $(".stop").click(function(){
        owl.trigger('owl.stop');
      })

      $('#testnav li').mouseover(function(){
        $(this).addClass('open');
      });

      $('#testnav li').mouseout(function(){
        $(this).removeClass('open');
      });

$('.single-item').slick({
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 6000
    });




    });
function store_search(search_value) {
        $('#search').html('');
        var search_value = search_value.replace('/', '22').replace('\\', '33');
        search_value = encodeURIComponent(search_value).replace(/[!'()]/g, escape).replace(/\*/g, "%2A");

        if (search_value != '') {
            this.value = '';

            jQuery.ajax({
                type: 'POST',
                url: baseurl + 'store/storeSearch/' + search_value,
                context: document.body,
                error: function (data, transport) {
                    alert("Sorry, the operation is failed.");
                },
                success: function (data) {
                    $('#search').html('');
                    $('#search').html(data);
                }
            });

        } else {
        }
    }
    function emptyvalue() {
        $('#search').html('');
    }

    $('html').click(function (e) {
        if (e.target.id === 'search_list_rzlt') {
            alert('clicked');
        } else {
            $('#search').html('');
        }
    });

 function scriberajex(){ 
 var form = jQuery("#newsletterForm");
  var data = form.serialize();
    jQuery.ajax({
     type: 'POST', 
     url: baseurl+'scribeUser',
     data:data,
     form: form,
    context: document.body,
    error: function(data, transport) { },
    success: function(data){
      if(data==2){
        jQuery('#my_id_err').css('display', 'none');
        jQuery('#my_id_sucs').css('display', 'block');
        }else{
        jQuery('#my_id_sucs').css('display', 'none'); 
        jQuery('#my_id_err').css('display', 'block');
          jQuery('#newsletterError').html(data);
        }
    }
  });
  
  return false;
}   

