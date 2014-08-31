  //Fehlermeldungen für JavaScript-Zeugs
  function alert_message(message) {
      $("#flash-message").remove();
      $("header").after( "<div id='flash-message' class='input-control text error-state' data-role='input-control'><input value='"+message+"' type='text'></div>");
  } 
  
  function info_message(message) {
      $("#flash-message").remove();
      $("header").after( "<div id='flash-message' class='input-control text info state' data-role='input-control'><input value='"+message+"' type='text'></div>");
  } 
  
