
$("button#loadAttendedEvents").click(function(){
  console.log("clicked");
  var attended = {};
  attended['attended'] = "";
  $.ajax({
    type: "post",
    url: "database/attendance.php",
    datatype: "json",
    data: JSON.stringify(attended)
  }).done(function(html){
    var jsonResponse;
    jsonResponse=JSON.parse(html);
    console.log(jsonResponse);
    var divContent = "<h1>Events you attended...</h1>";

    divContent = getEventString(jsonResponse, divContent);

    if(divContent=="<h1>Events you attended...</h1>")
      divContent+="<h4>You have not attended an event yet.</h4><br>";

    $("div#attended").html(divContent);
  });
});

// Get html string that represents a single short event
function getEventString(jsonResponse, stringStart){
  for(var i = 0; i < jsonResponse.length; i++){
    stringStart += '<div class="shortEvent">' +
    '<img src="images/thumbs_medium/' + jsonResponse[i]['imageURL'] + '" width="150" height="150">' +
      '<h2><a href="./?event=' + jsonResponse[i]['id']  + '">' + jsonResponse[i]['nameTag'] + '</a></h2>' +
         '<h4>' + jsonResponse[i]['type'] + '</h4>' +
         '<h4>Created by <a href="./?user=' + jsonResponse[i]['creator'] + '" >' + jsonResponse[i]['creator'] + '</a></h4>' +
         '<h4>' + jsonResponse[i]['city'] + ', ' + jsonResponse[i]['time'].replace("T",", ") + '</h4>';

    stringStart += '</div><br><br>';
  }
  return stringStart;
}
