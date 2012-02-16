var javascript_countdown = function () {
  var time_left = 10; //number of seconds for countdown
  var output_element_id = 'javascript_countdown_time';
  var keep_counting = 1;
 
  function countdown() {
    if(time_left < 2) {
      keep_counting = 0;
    }
 
    time_left--;
  }
 
  function add_leading_zero(n) {
    return (n.toString().length < 2 ? '0' : '') + n;
  }
 
  function format_output() {
    var hours, minutes, seconds;
    seconds = time_left % 60;
    minutes = Math.floor(time_left / 60) % 60;
    hours = Math.floor(time_left / 3600);
 
    seconds = add_leading_zero( seconds );
    minutes = add_leading_zero( minutes );
    hours = add_leading_zero( hours );
 
    return hours + ':' + minutes + ':' + seconds;
  }
 
  function show_time_left() {
    document.getElementById(output_element_id).innerHTML = format_output(); //time_left;
    Cufon.replace('.timer');
  }
 
  function no_time_left() {
    $('#answer_form').submit();
  }
 
  return {
    count: function () {
      countdown();
      show_time_left();
    },
    timer: function () {
      javascript_countdown.count();
 
      if(keep_counting) {
        setTimeout("javascript_countdown.timer();", 1000);
      } else {
        no_time_left();
      }
    },
    //Kristian Messer requested recalculation of time that is left
    setTimeLeft: function (t) {
      time_left = t;
      if(keep_counting == 0) {
        javascript_countdown.timer();
      }
    },
    init: function (t, element_id) {
      time_left = t;
      output_element_id = element_id;
      javascript_countdown.timer();
    }
  };
}();