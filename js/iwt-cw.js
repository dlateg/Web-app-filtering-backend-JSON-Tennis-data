$(document).ready(function() {
  $('form').submit(function(e) {
    e.preventDefault(); // Prevent form submission

    //Get the selected file name
    var jsonFile = "";
    var option = $('#file').val();
    switch (option) {
      case "default":
        jsonFile = "null";
        break;
      case "men winners":
        jsonFile = "mens-grand-slam-winners.json";
        break;
      case "women winners":
        jsonFile = "womens-grand-slam-winners.json";
        break;
    }

    // Get the form inputs
    var year = $('#year').val();
    var condition = $('#condition').val();
    var tournament = $('#tournament').val();
    var winner = $('#winner').val().toLowerCase();
    var runnerUp = $('#runner-up').val().toLowerCase();

    // getJSON loads JSON-encoded data from the server using a GET HTTP request
    //query parameters enclosed in curly brackets as arguments 
     $.getJSON('iwt-cw.php',{file:jsonFile,year:year,yearOp:condition,tournament:tournament,winner:winner,runnerUp:runnerUp}, function 
      (filteredData){

       //creating the table headers and structure
        var table = $('<table>').append($('<thead>').append($('<tr>').append($('<th>').text('Year'), $('<th>').text('Tournament'), $('<th>').text('Winner'), $('<th>').text('Runner-up'))));
        var tbody = $('<tbody>');

        //looping through the filtered data and appending items to tbdoy row by row
        $.each(filteredData, function(i, item) {
          tbody.append($('<tr>').append($('<td>').text(item.year), $('<td>').text(item.tournament), $('<td>').text(item.winner), $('<td>').text(item['runner-up'])));
        });
        table.append(tbody);
        $('#output').html(table);

      })

  // Clear output on button click
  $('input[type="button"]').click(function() {
    $('#output').empty();
  });
});
});