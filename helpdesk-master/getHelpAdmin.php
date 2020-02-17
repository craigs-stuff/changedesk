<?php
session_start();


date_default_timezone_set('Europe/London');

/****************************************************
*
* @File:        getHelpAdmin.php
* @Function:    Retrieve array and search
* @Author:      Craig Adams
*
*****************************************************/


//error handler function
function customError($errno, $errstr) {
  echo "<b>Error:</b> [$errno] $errstr";
}

//set error handler
set_error_handler("customError");

//USER Check
$userOnline = 0;

//headings
$hint = "<tr>
            <th>Day</th>
            <th>Date</th>
            <th>Time</th>
            <th>Description</th>
            <th>Status</th>
            <th style='text-align:center;'>Options</th>
        </tr>";

$hintContent = "";




function getLocData($ld){
    switch($ld){
            case 'p1':
                return('dataSearch/p1/data.json');
            break;

            case 'p2':
                return('dataSearch/p2/data.json');
            break;

            case 'cr':
                return('dataSearch/cr/data.json');
            break;
        }
}

function deleteDetails($delRef){

 $delData = getLocData($_SESSION['pStatus']);

 //convert to php array
 $jData = file_get_contents($delData);
 $jDataArr = json_decode($jData,true);
 $elementCount = 0;
 $counterMatch = 0;

 foreach($jDataArr as $row){
     foreach ($row as $key => $value) {
         $delRef = str_replace("-del", "", $delRef);
         if($key == "id" && $value == $delRef){
             $counterMatch = $elementCount;
             echo "<h4><i style='color:#ce3838;' class='fas fa-trash-alt'></i> Record: " .$value." now deleted!</h4>";
         }
     }
     $elementCount ++;
 }


 //delete element from array
 array_splice($jDataArr,$counterMatch,1);

 //change array to json and use pretty print
 $jDataStr = json_encode($jDataArr,JSON_PRETTY_PRINT);

 //Save updates back to file
 file_put_contents($delData, $jDataStr);

}

function checkStatus($statcol){
    //checks the value of staus and then provides a colour value
    switch ($statcol) {
                case 1:
                    return ("<span class='statusColour' style ='background-color: #e2553e; border: solid 1px #a94131;'></span>");
                    break;

                case 2:
                    return ("<span class='statusColour' style ='background-color: #63bf5d; border: solid 1px #3cb340;'></span>");
                    break;

                case 3:
                    return ("<span class='statusColour' style ='background-color: #fff150; border: solid 1px #f7e071;'></span>");
                    break;
            }
}

function showDetails($c){

    $isP = substr($c,0,2); // grab first two characters to get correct directory
    $dataDetails = "";

    $lc = getLocData($_SESSION['pStatus']);

    $jsonData = json_decode(file_get_contents($lc));


    //Output the selected row showing the alert
    foreach($jsonData as $row){

        //check status colour
        $statusColour = checkStatus($row->status);

        if(strtolower($row->id) == strtolower($c)){

            //check staus colour

            $dataDetails .= "
                <table class='tableClr'>
                    <tr>
                        <td class='greyBG' colspan='5'>CR number: <span style='float:right' onclick = 'closeDetails()' id='closeDetails'><i class='far fa-window-close'></i></span><h3>".strtoupper($row->id)."</h3></td>
                    </tr>

                    <tr>
                        <th>Day</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td>".makeWeekDay($row->date)."</td>
                        <td>".strtolower($row->date)."</td>
                        <td>".strtolower($row->time)."</td>
                        <td>".strtolower($row->title)."</td>
                        <td>" .$statusColour . "</td>
                    </tr>
                    <tr>
                        <th colspan='5'>Details</th>
                    </tr>
                    <tr>
                        <td style='text-align:left;' id='".strtolower($row->id)."-cont' class='ea' colspan='5'>".strtolower($row->details)."</td>
                    </tr>
                    <tr>
                        <th colspan='5'>Services Impacting</th>
                    </tr>
                    <tr>
                        <td style='text-align:left;' id='".strtolower($row->id)."-impact' class='ea' colspan='5'>".strtolower($row->impact)."</td>
                    </tr>
                    <tr>
                        <th colspan='5'>Non service affecting</th>
                    </tr>
                    <tr>
                        <td style='text-align:left;' id='".strtolower($row->id)."-impact' class='ea' colspan='5'>".strtolower($row->nonimpact)."</td>
                    </tr>


                </table>";
        }


    }
      echo $dataDetails;
}



function makeWeekDay($wd){
  $wdn = strtotime($wd);
  $wdname = date('l',$wdn);
  return $wdname;
}




function getAvailableData($l){


  //get json


    $ld = getLocData($l);
    echo $l." -- ".$ld ."// ";

    $jsonData = json_decode(file_get_contents($ld));

    rsort($jsonData);

    $earliestDate = strtotime("now");
    $txtDate = "";

    //create an array for each week
    $allWeeks = [
      array(),
      array(),
      array(),
      array()
    ];





        //sort the data by date into weeks
        foreach($jsonData as $row){

          //check status colour
          $statusColour = checkStatus($row->status);

          //four week test
          if(strtotime($row->date) < strtotime("now -4 weeks")){
            $dayName = makeWeekDay($row->date);
            array_push($allWeeks[3], array($dayName, $row->date, $row->time, $row->title, $statusColour, $row->id));
          }
          else if(strtotime($row->date) > strtotime("now -3 weeks") && strtotime($row->date) < strtotime("now -2 weeks")){
            $dayName = makeWeekDay($row->date);
            array_push($allWeeks[2], array($dayName, $row->date, $row->time, $row->title, $statusColour, $row->id));
          }
          else if(strtotime($row->date) > strtotime("now -2 weeks") && strtotime($row->date) < strtotime("now -1 week") ){
            $dayName = makeWeekDay($row->date);
            array_push($allWeeks[1], array($dayName, $row->date, $row->time, $row->title, $statusColour, $row->id));
          }
          else if(strtotime($row->date) > strtotime("now -1 week") && strtotime($row->date) < strtotime("now +1 day") ){
            $dayName = makeWeekDay($row->date);
            array_push($allWeeks[0], array($dayName, $row->date, $row->time, $row->title, $statusColour, $row->id));
          }
        }



        // check the weeks arrays

        //weeks array
        for ($w=0; $w < count($allWeeks); $w++) {

          $weekText = "Week ". ($w+1);

          if($w == 3){
            $weekText = "Week ". ($w+1). "+";
          }

          $GLOBALS['hintContent'] .= "<h4 id = 'wkTitle".$w."'>".$weekText."</h4><table class='weekNo' id='week".$w."'>". $GLOBALS['hint'];

          //specific week array
          for ($wa=0; $wa < count($allWeeks[$w]) ; $wa++) {
            $GLOBALS['hintContent'] .= "<tr class='".$allWeeks[$w][$wa][1]."'>";
            //specific days
            $idRef = "";

            for($sday = 0; $sday < count($allWeeks[$w][$wa])-1; $sday++){
              $GLOBALS['hintContent'] .= "
                <td onclick='hideDays(this)' class='day ".$allWeeks[$w][$wa][0]."'>".$allWeeks[$w][$wa][$sday]."</td>";
            }

            if (isset($GLOBALS['userOnline']) && $GLOBALS['userOnline'] == "y") {
                    $GLOBALS['hintContent'] .= "<td class='butts'>
                    <a onclick='viewMe(this)' id='".$allWeeks[$w][$wa][5]."-view' class='bookButt editPage button' data-user='".$allWeeks[$w][$wa][5]."' data-action = 'open' style='border-radius:5px;background-color:#1bd41b;'><i class='far fa-folder-open'></i></a>
                    <a href='index.php?id=edit&t=".$allWeeks[$w][$wa][5]."' id='".$allWeeks[$w][$wa][5]."-edit' class='bookButt button' data-id='".$allWeeks[$w][$wa][5]."' data-action = 'edit' style='border-radius:5px;background-color:#444'><i class='fas fa-pencil-alt'></i></a>
                    <a onclick='viewMe(this)' id='".$allWeeks[$w][$wa][5]."-del' class='bookButt button' data-user='".$allWeeks[$w][$wa][5]."' data-action = 'delete' style='border-radius:5px;background-color:#ce3838'><i class='far fa-trash-alt'></i></a>
                    </td>";
                }
            else{

                    $GLOBALS['hintContent'] .= "<td class='butts'>
                    <a onclick='viewMe(this)' id='".$allWeeks[$w][$wa][5]."-view' class='bookButt editPage button' data-user='".$allWeeks[$w][$wa][5]."' data-action = 'open' style='border-radius:5px;background-color:green'><i class='far fa-folder-open'></i></a>
                    </td>";
                }
            $GLOBALS['hintContent'] .= "</tr>";
          }
          $GLOBALS['hintContent'] .= "</table>";
        }

      }

//CHECK FOR THE USER LOGGED IN
if(isset($_REQUEST['o']) && !empty($_REQUEST['o'])){
		$GLOBALS['userOnline'] = htmlentities($_REQUEST['o']);
		//$GLOBALS['hint'] .= "===".$GLOBALS['userOnline']."===";
}


//LIST THE DATA ON FILE
if(isset($_REQUEST['l']) && !empty($_REQUEST['l'])){
    //get row data
    $l_input = htmlentities($_REQUEST['l']);


    $_SESSION['pStatus'] = $l_input;


    getAvailableData($l_input);

    echo $GLOBALS['hintContent'];
}
else if(isset($_REQUEST['c']) && !empty($_REQUEST['c'])){
    //view data
    $c_input = htmlentities($_REQUEST['c']);
    showDetails($c_input);

}
else if(isset($_REQUEST['d']) && !empty($_REQUEST['d'])){
    //delete data
    $d_input = htmlentities($_REQUEST['d']);
    deleteDetails($d_input);
}







?>
