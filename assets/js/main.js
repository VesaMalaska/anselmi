$(document).ready(function(){

  /* ********************************************************** */
  // Bootstrap tooltip initialization
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });


  /* **********************************************************
     **********************************************************
     **********            FUNCTIONS                 **********
     **********************************************************
       ******                                          ******
     **********                                      **********
       ******                                          ******
         **                                              **

  */

  /* ********************************************************** */
  // Function to update operators online status AKA keep alive pulse
  function operatorAlivePulse() {
    $.get("Operator_status/keep_operator_alive", function(data, status){

      // call it self recursively every 50 seconds
      setTimeout( operatorAlivePulse, 50000 );
    });
  }

  /* ********************************************************** */
  // Function to poll and update incoming chat requests
  function updateIncomingChatRequests() {
    $.get("Chat_session/check_chat_requests", function(data, status){

      // check if there is chat requests
      // data is empty string if there is no incoming chat requests
      if(data != ''){

        // get chat request data to array by request
        var arrayOfChatRequests = data.split(';');

        // create empty arrays for storing chat request data and chat request ID's
        var arrayOfChatRequestData = [], arrayOfChatRequestID = [];

        // loop through chat requests and create new requests in DOM
        for(var i=0; arrayOfChatRequests.length>i; i++){
          // get chat request data to array by request
          // data indexes: 0=ID, 1=name, 2=request time
          arrayOfChatRequestData = arrayOfChatRequests[i].split(',');

          // create new chat requests to DOM (if not existing already)
          if(!$(".cmu_chat_request[data-cmu_request_id='" + arrayOfChatRequestData[0] + "']").length>0){

            // print a heading for incoming chat session in left sidebar
            // if it's not existing already
            if(!$(".cmu_chat_requests_heading_left_sidebar").length>0){
              var newChatRequestsHeadingElement = $("<h3></h3>").addClass("cmu_chat_requests_heading_left_sidebar").text("Saapuvat chat-pyynnöt");
              $("#incoming_chat_requests").append(newChatRequestsHeadingElement);
            }
            // if it already exists then check if it has a class "no_requests_heading"
            // if that class exists then delete H3 tag and recreate it
            else if($(".cmu_chat_requests_heading_left_sidebar").hasClass("no_requests_heading")){
              $(".cmu_chat_requests_heading_left_sidebar").remove();

              var newChatRequestsHeadingElement = $("<h3></h3>").addClass("cmu_chat_requests_heading_left_sidebar").text("Saapuvat chat-pyynnöt");
              $("#incoming_chat_requests").append(newChatRequestsHeadingElement);
            }

            // create a wrapper div for chat request
            var newChatRequestElement = $("<div></div>").attr("data-cmu_request_id", arrayOfChatRequestData[0]).addClass("cmu_chat_request");
            $("#incoming_chat_requests").append(newChatRequestElement);

            // show button for opening the chat
            var openChatButtonElement = $("<a></a>").attr("href", "#").addClass("open_requested_chat rounded-circle").append($("<i></i>").addClass("fas fa-arrow-right"));
            $(".cmu_chat_request[data-cmu_request_id='" + arrayOfChatRequestData[0] + "']").append(openChatButtonElement);

            // show the chatter name
            var chatterNameElement = $("<span></span>").addClass("chat_request_chatter_name").text(arrayOfChatRequestData[1]);
            $(".cmu_chat_request[data-cmu_request_id='" + arrayOfChatRequestData[0] + "']").append(chatterNameElement);

            // insert line break
            $(".cmu_chat_request[data-cmu_request_id='" + arrayOfChatRequestData[0] + "']").append($("<br>"));

            // show the time that request was created
            var requestTimeElement = $("<span></span>").addClass("chat_request_time_in_line").text(arrayOfChatRequestData[2]);
            $(".cmu_chat_request[data-cmu_request_id='" + arrayOfChatRequestData[0] + "']").append(requestTimeElement);
          }

          // store the chat request ID's to the array
          arrayOfChatRequestID.push(arrayOfChatRequestData[0]);
        }
      } else {
        // if there is no incoming chat requests
        // print a heading for incoming chat session in left sidebar
        if(!$(".cmu_chat_requests_heading_left_sidebar").length>0){
          var newChatRequestsHeadingElement = $("<h3></h3>").addClass("cmu_chat_requests_heading_left_sidebar no_requests_heading").text("Ei saapuvia chat-pyyntöjä");
          $("#incoming_chat_requests").append(newChatRequestsHeadingElement);
        }
      }

      // clean off the requests that have already started or ended
      $('.cmu_chat_request').each(function(){
        if(!arrayOfChatRequestID.includes($(this).attr('data-cmu_request_id'))){
           $(this).remove();
        }
      });

      // call it self recursively every second
      setTimeout( updateIncomingChatRequests, 1000 );
    });
  }

  /* ********************************************************** */
  function openNewChatSession(chatSessionID){
    // set starting time for chat session and assign it for current operator
    $.post("Chat_session/start_requested_chat_session",{'chat_session_ID': chatSessionID} , function(data, status){

      // if the chat session was successfully started then proceed to create view for it
      if(status === 'success'){
        // open the chat view to screen

      } else console.log("Error on starting requested chat session...");
    });
  }

  /* ********************************************************** */
  // Function to poll and update operators open chat sessions
  function updateOperatorsActiveChatSessions() {
    $.get("Chat_session/check_operators_open_chat_sessions", function(data, status){

      // create empty arrays for storing chat request data and chat request ID's
      var arrayOfChatSessionData = [], arrayOfChatSessionID = [];

      // check if there is open not ended chat sessions for this operator
      // data is empty string if there is no open chat sessions
      if(data != ''){

        // get chat request data to array by request
        var arrayOfChatSessions = data.split(';');

        // loop through chat requests and create new requests in DOM
        for(var i=0; arrayOfChatSessions.length>i; i++){
          // get chat request data to array by request
          // data indexes: 0=ID, 1=name, 2=request time
          arrayOfChatSessionData = arrayOfChatSessions[i].split(',');

          // set first chat session to be active if there is no active session assigned yet
          // check if webstorage is usable
          if (typeof(Storage) !== "undefined") {
            if(i===0 && sessionStorage.getItem("activeChatSessionID") === null){
              sessionStorage.activeChatSessionID = arrayOfChatSessionData[0];
            }
          } else {
            // error message to console if webstorage is not usable
            console.log("Error: webstorage unavailable!")
          }

          // create new chat sessions to DOM (if not existing already)
          if(!$(".cmu_chat_session[data-cmu_session_id='" + arrayOfChatSessionData[0] + "']").length>0){

            // print a heading for on going chat session in left sidebar
            if(!$(".cmu_chat_session_heading_left_sidebar").length>0){
              var newChatSessionHeadingElement = $("<h3></h3>").addClass("cmu_chat_session_heading_left_sidebar").text("Avoimet chat-keskustelut");
              $("#ongoing_chat_sessions").append(newChatSessionHeadingElement);
            }

            // create a wrapper div for chat request
            var newChatSessionElement = $("<div></div>").attr("data-cmu_session_id", arrayOfChatSessionData[0]).addClass("cmu_chat_session");
            $("#ongoing_chat_sessions").append(newChatSessionElement);

            // show button for opening the chat
            var showChatButtonElement = $("<a></a>").attr("href", "#").addClass("open_requested_chat show_chat rounded-circle").append($("<i></i>").addClass("fas fa-arrow-right"));
            $(".cmu_chat_session[data-cmu_session_id='" + arrayOfChatSessionData[0] + "']").append(showChatButtonElement);

            // show the chatter name
            var chatterNameElement = $("<span></span>").addClass("chat_request_chatter_name").text(arrayOfChatSessionData[1]);
            $(".cmu_chat_session[data-cmu_session_id='" + arrayOfChatSessionData[0] + "']").append(chatterNameElement);

            // insert line break
            $(".cmu_chat_session[data-cmu_session_id='" + arrayOfChatSessionData[0] + "']").append($("<br>"));

            // show the time that request was created
            var requestTimeElement = $("<span></span>").addClass("chat_request_time_in_line").text(arrayOfChatSessionData[2]);
            $(".cmu_chat_session[data-cmu_session_id='" + arrayOfChatSessionData[0] + "']").append(requestTimeElement);
          }

          // check if the open page is CHAT-conversations page
          // page is CHAT-conversations page if div's with id's chat_session_tabs and chat_messages exists
          if($("#chat_session_tabs").length>0 && $("#chat_messages").length>0){

            // create chat session tabs from open chat sessions assigned to this operator (if not existing already)
            if(!$(".cmu_chat_session_tab[data-cmu_session_id='" + arrayOfChatSessionData[0] + "']").length>0){

              // create classes for chat session tab
              chatSessionTabClasses = "cmu_chat_session_tab";
              if(sessionStorage.activeChatSessionID === arrayOfChatSessionData[0]){
                chatSessionTabClasses += " cmu_chat_session_tab_active";
              }

              // create a wrapper div for chat session tab
              var newChatSessionTabElement = $("<div></div>").attr("data-cmu_session_id", arrayOfChatSessionData[0]).addClass(chatSessionTabClasses).text(arrayOfChatSessionData[1]);
              $("#chat_session_tabs").append(newChatSessionTabElement);
            }
          }

          // store the chat request ID's to the array
          arrayOfChatSessionID.push(arrayOfChatSessionData[0]);
        }
      } else {
        // if there is no on going chat sessions
        // remove the heading for on going chat session in left sidebar if it still exists
        if($(".cmu_chat_session_heading_left_sidebar").length>0){
          $(".cmu_chat_session_heading_left_sidebar").remove();
        }
      }

      // store active chat session id's to session storage
      localStorage.setItem("activeChatSessions", JSON.stringify(arrayOfChatSessionID));

      // clean off the open chat session lings from left sidebar that have ended
      $('.cmu_chat_session').each(function(){
        if(!arrayOfChatSessionID.includes($(this).attr('data-cmu_session_id'))){
           $(this).remove();
        }
      });
      // clean off the tabs of chat sessions that have ended
      $('.cmu_chat_session_tab').each(function(){
        if(!arrayOfChatSessionID.includes($(this).attr('data-cmu_session_id'))){
           $(this).remove();
        }
      });

      // call it self recursively every second
      setTimeout( updateOperatorsActiveChatSessions, 1000 );
    });
  }

  /* ********************************************************** */
  // Function to poll and update operators open chat sessions
  function openActiveChatconversation(){
    // redirect to active chat session on chat sessions page
    //window.location.replace("http://stackoverflow.com");
  }

  /* ********************************************************** */
  // Function to poll and update operators open chat sessions
  function updateChatConversationPage(){
    //
  }


  /* **********************************************************
     **********************************************************
     **********          EVENT HANDLERS              **********
     **********************************************************
       ******                                          ******
     **********                                      **********
       ******                                          ******
         **                                              **

  */

  /* ********************************************************** */
  // Open new chat session when open chat button clicked
  $('#incoming_chat_requests').on('click', '.open_requested_chat', function(){
    openNewChatSession($(this).parent().attr('data-cmu_request_id'));
    // delete the parent div which is showing chat request on browser
    $(this).parent().remove();
    // delete left sidebar requests heading
    $(".cmu_chat_requests_heading_left_sidebar").remove();
  });

  /* ********************************************************** */
  // Open related chat session when button clicked
  $('#ongoing_chat_sessions').on('click', '.show_chat', function(){
    //openNewChatSession($(this).parent().attr('data-cmu_session_id'));
  });


  /* **********************************************************
     **********************************************************
     **********          FUNCTION CALLS              **********
     **********************************************************
       ******                                          ******
     **********                                      **********
       ******                                          ******
         **                                              **

  */

  operatorAlivePulse();  // start operator online status pulse

  updateIncomingChatRequests();  // start operator online status pulse

  updateOperatorsActiveChatSessions();



  /* ********************************************************** */
  // check if the open page is CHAT-conversations page
  // page is CHAT-conversations page if div's with id's chat_session_tabs and chat_messages exists
  if($("#chat_session_tabs").length>0 && $("#chat_messages").length>0){
    // create chat session tabs from open chat sessions assigned to this operator

  }
});
