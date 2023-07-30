<?php

header("Content-Type: application/json; charset=utf-8");
//header('Access-Control-Allow-Origin: https://www.dcs.bbk.ac.uk');

//get the selected file
$jsonFile = "";
if (isset($_GET['file'])){
  $option = $_GET['file'];
  switch ($option) {
    case "mens-grand-slam-winners.json":
      $jsonFile = "mens-grand-slam-winners.json";
      break;
    case "womens-grand-slam-winners.json":
      $jsonFile = "womens-grand-slam-winners.json";
      break;
    case "default":
      $jsonFile = "";
      break;
  }
//if condition to check file exists and return error if doesnt
if ($jsonFile != ''){
//read file into a string
$data = file_get_contents($jsonFile);
//convert json object into php object
$data = json_decode($data,true);
$filteredData = array();
}
else {
  echo "error";
}

if (isset( $_GET['year'], $_GET['yearOp'], $_GET['tournament'], $_GET['winner'], $_GET['runnerUp'])){

    $year = $_GET['year'];
    $yearOp = $_GET['yearOp'];
    $tournament = $_GET['tournament'];
    $winner = $_GET['winner'];
    $runnerUp = $_GET['runnerUp'];

    // loop through data and store the matches of the filter conditions in variable
 foreach ($data as $item) {
    
    $match = true; 

    if ($yearOp === 'equals'){
        $match = $match && ($item['year'] == $year);
        
    }
    elseif ($yearOp == 'greater than'){
        
      $match = $match && ($item['year'] > $year);
      
    }

    else {

      $match = $match && ($item['year'] < $year);
        
    }

    //when tournament is Any, condition always evaluates to true 
    if ($tournament !== 'Any'){
    
     //this condition evaluates to true when the item in json file matches tournament selected
      $match = $match && (strtolower($item['tournament']) == strtolower($tournament));

    }
    
    if ($winner !== '') {
      //stripos is a case insensitive function that checks if second argument string is contained in first argument string 
      //!== false condition means only matches that evaluate to true are returned 
      $match = $match && (stripos(($item['winner']),$winner) !== false);
        
    }
  
    if ($runnerUp !== '') {
      //stripos is a case insensitive function that checks if second argument string is contained in first string 
      //!== false condition means only true matches are returned   
      $match = $match && (stripos(($item['runner-up']),$runnerUp) !== false);
    }
    
    //match variable would have been set to true for all matching conditions  
    if ($match){

      //push the current item which meets conditions into the filteredData array 
      array_push($filteredData,$item);
    }

 }
    //encode to json format
    echo json_encode($filteredData);

}

}

?>