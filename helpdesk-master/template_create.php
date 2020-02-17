 <?php
  $page = "create";
  include('includes/header.inc.php');
?>


        <?php include('includes/sidebarmenu.inc.php'); ?>


                <div class="medium-10 medium-centered columns">
                    <div class="data-panel criteria" id="dataRows">
                      <h1><?php get_page_title(); ?></h1>
                      <hr>

                      
                      <div><?php if(isset($mymessage)){echo $mymessage;} ?></div>

                        <?php
                        // define variables and set to empty values
                        $titleErr = $datepickerErr = $timeErr = $nonimpactErr = $impactErr = $emailErr = $ticketnoErr = $statusErr = $detailsErr = $ticktypeErr = "";
                        $ticketno = $time = $datepicker = $title = $email = $status =$impact =$nonimpact = $details = $ticktype = "";



                        function test_input($data) {
                          $data = trim($data);
                          $data = stripslashes($data);
                          $data = htmlspecialchars($data);
                          return $data;
                        }


                        //Testing inputs ------------------------

                        if ($_SERVER["REQUEST_METHOD"] == "POST"){

                          $checkFlag = 0;

                          if (empty($_POST["datepicker"])|| ctype_space($_POST["datepicker"])) {
                            $datepickerErr = "Date required";
                            $checkFlag =1;
                          } else {
                            $datepicker = test_input($_POST["datepicker"]);
                          }

                          if (empty($_POST["title"]) || ctype_space($_POST["title"])) {
                            $titleErr = "Title required";
                            $checkFlag =1;
                          } else {
                            $title = test_input($_POST["title"]);
                            // check if name only contains letters and whitespace
                            if (!preg_match("/[a-zA-Z0-9\s]+/",$title)) {
                              $titleErr = "Only letters and white space allowed";
                            }
                          }

                          if (empty($_POST["ticketno"]) || ctype_space($_POST["ticketno"])) {
                            $ticketnoErr = "Ticket number required";
                            $checkFlag =1;
                          } else {
                            $ticketno = test_input($_POST["ticketno"]);
                            // check if name only contains letters and whitespace
                            if (!preg_match("/^[a-zA-Z0-9 ]*$/",$ticketno)) {
                              $ticketnoErr = "Only letters, numbers and white space allowed";
                            }
                          }

                          if (empty($_POST["time"]) || ctype_space($_POST["time"])) {
                            $timeErr = "Time required";
                            $checkFlag =1;
                          } else {
                            $time = test_input($_POST["time"]);
                            // check if name only contains letters and whitespace
                            if (!preg_match("/^[\d]{2}:[\d]{2}$/",$time)) {
                              $timeErr = "Please enter in the format - dd:dd";
                            }
                          }

                          if (empty($_POST["email"]) || ctype_space($_POST["email"])) {
                            $emailErr = "Email required";
                            $checkFlag =1;
                          } else {
                            $email = test_input($_POST["email"]);
                            // check if e-mail address is well-formed
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                              $emailErr = "Invalid email format";
                            }
                          }

                          if (empty($_POST["impact"]) || ctype_space($_POST["impact"])) {
                            $impactErr = "Content required";
                            $checkFlag =1;
                          } else {
                            $impact = test_input($_POST["impact"]);
                          }

                          if (empty($_POST["nonimpact"]) || ctype_space($_POST["nonimpact"])) {
                            $impactErr = "Content required";
                            $checkFlag =1;
                          } else {
                            $impact = test_input($_POST["nonimpact"]);
                          }

                          if (empty($_POST["details"]) || ctype_space($_POST["details"])) {
                            $detailsErr = "Content required";
                            $checkFlag =1;
                          } else {
                            $details = test_input($_POST["details"]);
                          }

                          if (empty($_POST["status"])) {
                            $statusErr = "Status required";
                            $checkFlag =1;
                          } else {

                          $status = test_input($_POST["status"]);
						  }


                          if (empty($_POST["ticktype"])) {
                            $ticktypeErr = "Ticket type required";
                            $checkFlag =1;
                          } else {
                            $ticktype = test_input($_POST["ticktype"]);
                          }



                          if($checkFlag == 0){

                            $existsFlag = 0;


                            //save file
                            $filesLoc = "./theme/helpdesk-master/dataSearch/p".$ticktype."/data.json";
                            $dataFile = file_get_contents($filesLoc) or die("Ooops");
                            $decodeJson = json_decode($dataFile);


                            //Loop through array and check for duplicate id
                            foreach ($decodeJson as $skey => $svalue) {
                               if($decodeJson[$skey]->id == $ticketno){
                                $existsFlag = 1;
                               }
                             }


                             if($existsFlag == 0){

                              $mymessage = "<p class='success'>Ticket created</p>";

                              //save data - create new ticket
                              //stdClass is PHP's generic empty class
                              $newTicket = new stdClass();

                              $newTicket->id = $ticketno;
                              $newTicket->date = $datepicker;
                              $newTicket->updated = $datepicker;
                              $newTicket->time = $time;
                              $newTicket->title = $title;
                              $newTicket->email = $email;
                              $newTicket->details =$details;
                              $newTicket->status = $status;
                              $newTicket->impact = $impact;
                              $newTicket->nonimpact = $nonimpact;

                              //add object to array
                              array_push($decodeJson, $newTicket);

                              //decode and pretty print
                              $jDataStr = json_encode($decodeJson,JSON_PRETTY_PRINT);

                              //store the new data back to file
                              file_put_contents($filesLoc,$jDataStr) or die("No go");
                             }
                             else{
                              $mymessage = "<p class='errorRed'>Ticket ID already exists</p>";
                             }


                          }
                      }


                    ?>

                <!-- Form -------------------------- -->


                <p><span class="form_error">* Required fields</span></p>
                <form id="ticketForm" method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>">

                  <label style='display: inline;'>Creation Date:</label>
                  <span class="form_error"> * <?php echo $datepickerErr;?></span>
                  <input id="datepicker" style='display: inline;' type="text" name="datepicker" value="<?php echo $datepicker;?>">

                  <br><br>

                  <label style='display: inline;'>Time: <small style='color:#cacaca'>eg: 13:10</small></label>
                  <span class="form_error"> * <?php echo $timeErr;?></span>
                  <input id="time" style='display: inline;' type="text" name="time" value="<?php echo $time;?>">

                  <br><br>

                  <label style='display: inline;'>E-mail: </label>
                  <span class="form_error"> * <?php echo $emailErr;?></span>
                  <input type="text" name="email" value="<?php echo $email;?>">

                  <br><br>



                  <label style='display: inline;'>Title: </label>
                  <span class="form_error"> * <?php echo $titleErr;?></span>
                  <input type="text" name="title" value="<?php echo $title;?>" maxlength="120">

                  <br><br>

                  <label style='display: inline;'>Ticket No: </label>
                  <span class="form_error"> * <?php echo $ticketnoErr;?></span>
                  <input type="text" name="ticketno" value="<?php echo $ticketno;?>" maxlength="15">

                  <br><br>

                  <label style='display: inline;'>Ticket Type: </label>

                  <input type="radio" name="ticktype"  value="1">P1
                  <input type="radio" name="ticktype"  value="2">P2
                  <span class="form_error"> * <?php echo $ticktypeErr;?></span>
                  <br><br>

                  <label style='display: inline;'>Ticket Status: </label>

                  <input type="radio" name="status" value="1">Red
                  <input type="radio" name="status" value="3">Green
                  <span class="form_error"> * <?php echo $statusErr;?></span>
                  <br><br>


                  <label style='display: inline;'>Ticket Details:</label>
                  <span class="form_error"> * <?php echo $detailsErr;?></span>
                  <br>
                  <textarea name="details" rows="5" cols="40"><?php echo $details;?></textarea>

                  <br><br>


                  <label style='display: inline;'>Services Impacting:</label>
                  <span class="form_error"> * <?php echo $impactErr;?></span>
                  <br>
                  <textarea name="impact" rows="5" cols="40"><?php echo $impact;?></textarea>

                  <br><br>

                  <label style='display: inline;'>Non service affecting:</label>
                  <span class="form_error"> * <?php echo $nonimpactErr;?></span>
                  <br>
                  <textarea name="nonimpact" rows="5" cols="40"><?php echo $nonimpact;?></textarea>

                  <br><br>

                  <input class="button" type="submit" name="submit" value="Submit">
                </form>

                </div>






            </div>

        </div>

   <?php include('includes/footer.inc.php'); ?>
