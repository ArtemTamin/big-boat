$(document).ready(function () {
 let text;
 if($("tr[data-num='num']").length == 0){
    text = "позиций нет";
 }else if($("tr[data-num='num']").length == 1){
  text =$("tr[data-num='num']").length+ " позиция";
 }else{
  text =$("tr[data-num='num']").length+ " позиций";
 }
  $("span.length").text(text);
  $('a[data_del="del"]').on("click", function(){
    if($("tr[data-num='num']").length == 0){
      text = "позиций нет";
   }else if($("tr[data-num='num']").length == 1){
    text =$("tr[data-num='num']").length+ " позиция";
   }else{
    text =$("tr[data-num='num']").length+ " позиций";
   }
    $("span.length").text(text);
  });
  // модальное окно
  $("a[data-click='click']").on("click", function(e){
    e.preventDefault();
    $(".popup").addClass("open");
  });

  // if(typeof $(".input_type_radio input").attr('checked')){
  //   $(this).siblings('label').css("border", "1px solid white");  
  // }
//  $("input[type='radio']").on("change", function(){
//   if ($('input[name="radio"]').is(':checked')){
//     alert('Включен');
//   } else {
//     alert('Выключен');
//   }
//  });
  $(".popup_close").on("click", function(e){
      e.preventDefault();
      $(".popup").removeClass("open");
  });
  $(".popup").on("click", function(e){
      if ($(e.target).closest('.popup_content').length == 0) {
          $(".popup").removeClass("open");					
      }
  });
    $(function(){
        $('.minimized').click(function(event) {
          var i_path = $(this).attr('src');
          $('body').append('<div id="overlay"></div><div id="magnify"><img src="'+i_path+'"><div id="close-popup"><i></i></div></div>');
          $('#magnify').css({
           left: ($(document).width() - $('#magnify').outerWidth())/2,
           // top: ($(document).height() - $('#magnify').outerHeight())/2 upd: 24.10.2016
                  top: ($(window).height() - $('#magnify').outerHeight())/2
         });
          $('#overlay, #magnify').fadeIn('fast');
        });
        
        $('body').on('click', '#close-popup, #overlay', function(event) {
          event.preventDefault();
          $('#overlay, #magnify').fadeOut('fast', function() {
            $('#close-popup, #magnify, #overlay').remove();
          });
        });
      });
    $('.slider').slick({
        arrow: true,
        dots: false,
        adaptiveHeight: true,
        slidesToShow: 3,
        speed: 2000,
        easing:'ease',
        infinite: true,
        autoplay: true,
        autoplaySpeed: 3000,
        draggable: false,
        centerMode: true,

    });

    $(".reply").hide();
    
    $(".quest").on('click', function(){
      $(".reply").slideUp();
      if($(this).parent().children('.reply').is(":hidden")){
          $(this).parent().children('.reply').slideDown();
      }else{
          $(this).parent().children('.reply').slideUp();
      }
    });
   
    $(".product").mouseenter(function(){
        $(this).children(".mainblock").children(".exper").addClass("exper-ui");
    });
    $(".product").mouseleave(function(){
      $(this).children(".mainblock").children(".exper").removeClass("exper-ui");
  });
    // вывод категории товаров по 2 строки
    console.log($(".jshop.list_product").children('.row-fluid').length);
    if($(".jshop.list_product").children('.row-fluid').length <= 2){
      $("#show_more").css("display", "none");
    }
    let row_fluid = $(".jshop.list_product").children('.row-fluid').length;
    $(".jshop.list_product").children('.row-fluid').hide().slice(0, 2).show();
    $('#show_more').on("click", function(e){
      e.preventDefault();
      let hidde = $(".jshop.list_product").children('.row-fluid:hidden').length;
      $(".jshop.list_product").children('.row-fluid:hidden').slice(0, 2).slideDown();
       console.log(hidde);
      if(hidde - 2 < 1 ){
        $("#show_more").css("display", "none");
      }
      
    });
  //  отслеживание изменения в форме фильтра
  let val_name_radio =[];
  let val_attr_radio;
  

  $('.ajax_filter input:radio').each(function(i, elem){
    if($(elem).is(":checked")){
      $("label[for='"+ $(elem).attr("id") +"']").css("font-weight","900");  
    }
    if(!val_name_radio.includes($(elem).attr("name"))){
      val_name_radio.push($(elem).attr("name"));
    }
  });
  $(".ajax_filter .clear.button.submit").on("click", function(){
    $(".ajax_filter label").css("font-weight","normal");
  });
  $('.ajax_filter input:radio').change(function (e) { 
      e.preventDefault();
      val_attr_radio =[];
      $(".ajax_filter label").css("font-weight","normal");
      for(let i =0; i<val_name_radio.length; i++){
        val_attr_radio.push($('.ajax_filter input:radio[name="'+ val_name_radio[i] +'"]:checked').attr("id"))
      }
      console.log(val_attr_radio);
      for(let i =0; i<val_attr_radio.length; i++){
        $("label[for='" + val_attr_radio[i] +"']").css("font-weight","900"); 
      }  
      
  });
  // прокрутка до Якоря
      $("a.scroll-to").on("click", function(e){
        e.preventDefault();
        var anchor = $(this).attr('href');
        $('html, body').stop().animate({
            scrollTop: $(anchor).offset().top - 120
        }, 800);
    });
}); 