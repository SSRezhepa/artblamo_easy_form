

    window.onload = function() {
        //Универсальный инструмент отправки писем
            
  
            $('.form-inputs').submit(function () {
              

                cur = $(this).parent();
                fin = cur.find('[name="fin"]').val();
  
                var data = {};
               // console.log(data);
               
                
                
                $.each($(this).find('[name^="message\\["]').serializeArray(), function () {
                    data[this.name] = this.value;
                });

                data['url'] = window.location.href;


                $.ajax({
                    url: "/artblamo/plugins/artblamo_easy_form/send_m.php", // куда отправляем
                    type: "post", // метод передачи
                    dataType: "json", // тип передачи данных
                    //processData : false,
                    //contentType : false, 
                    //dataType: 'json',
                    data: {
                        "data": data
                    },
                    // после получения ответа сервера
                    success: function (data) {
                    
                        $(cur).html(fin); // выводим ответ сервера
                        // console.log($(this).find('[name="fin"').val());
                    }
                });

                return false;
            });
            /////////////////////

       
           

 jQuery('[type="tel"]').mask('+7 (999) 999-99-99');
    }
