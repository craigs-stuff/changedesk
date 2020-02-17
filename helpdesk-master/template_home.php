 <?php

 include('includes/header.inc.php');
 $_SESSION['pStatus'] = "";
 $_SESSION['gsSitePath'] = get_site_url(false);

 ?>

<script>


var currentFile = "";


function hideDays(e){
  $(document).ready(function(){

      let day = $(e).parent().attr('class');
      let mainParent = $(e).parent().parent().parent().attr('id');
      //remove all classes
      $("#"+ mainParent + " tr:first-child").removeClass();
      $("#"+ mainParent + " tr:first-child").addClass(day);
      $("#"+ mainParent + " tr").not('.' + day).toggle('slow');

  });
}


$(document).ready(function(){

//filter by days of the week in each section
  $('#deleteNotice').on('click',function(){
    $('#deleteNotice h4').toggle();
  });
});



function viewMe(e){

  //view more details from data file - show expanded view

  $(document).ready(function(){

  //filter by days of the week in each section
  $('.weekNo').on('click',function(){
    let wn = $(this).parent.attr('id');
  	$("#"+wn+":not(.intro)").toggle('slow');
  });




        var issNo = e.getAttribute('id').replace("-view","");
        var issAction = e.getAttribute('data-action');

        var xmlhttp3 = new XMLHttpRequest();
        xmlhttp3.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                //output the details to #userData
                $('#userData').html(this.responseText);

                if(issAction == "delete"){
                    showRows(currentFile);
                    $('#deleteNotice').html(this.responseText);
                }
            }
        };

        if(issAction == "delete"){
            xmlhttp3.open("POST", "<?php get_theme_url(); ?>/getHelpAdmin.php?o=<?php echo $GLOBALS['userOnline'] ?>&d=" + issNo, true);
        }
        else if(issAction == "edit"){
            xmlhttp3.open("POST", "<?php get_theme_url(); ?>/getHelpAdmin.php?o=<?php echo $GLOBALS['userOnline'] ?>&e=" + issNo, true);

        }
        else if(issAction == "open"){
            xmlhttp3.open("POST", "<?php get_theme_url(); ?>/getHelpAdmin.php?o=<?php echo $GLOBALS['userOnline'] ?>&c=" + issNo, true);

        }

        xmlhttp3.send();



    $('#userData').show('slow');

  });


};

function showHide(e){

        $(document).ready(function(){
          let id = e.getAttribute('data-tabnum');
          $("#wkTitle"+id).toggle('slow');
          $("#week"+id).toggle('slow');
        });
}


function closeDetails(){
//hide startupinfo
  $(document).ready(function(){
    $('#userData').hide('slow');
  });
}





    $(document).ready(function(){



      $('.choices').on('click',function(){

      var loc =$(this).attr('data-ptype');

      $('#userData').hide();
      $('#weekTag').show('slow');

      currentFile = loc;
      $('#pSelection').html("<i class='fas fa-list-alt'></i> " + loc.toUpperCase() + " Tickets");

      //hide startupinfo

      $('#homeWelcome').css('display','none');

      if (loc.length == 0) {
            $('#txtHintHR').html("");
            return;
        } else {
            var xmlhttp2 = new XMLHttpRequest();
            xmlhttp2.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    $('#txtHintHR').html(this.responseText);
                }
            };
            xmlhttp2.open("GET", "<?php get_theme_url(); ?>/getHelpAdmin.php?o=<?php echo $GLOBALS['userOnline'] ?>&l=" + loc, true);
            xmlhttp2.send();
            $('#initialRows').show('slow');

        }

      });

      

    });



</script>



        <?php include('includes/sidebarmenu.inc.php'); ?>


                <div class="medium-10 medium-centered columns">
                    <div class="data-panel criteria" id="dataRows">

                        <div id="homeWelcome">
                          <img src="<?php get_theme_url() ?>/img/cdlogo.png" alt="change desk logo"/>
                         
                        </div>


                        <div id="userData" class="panelStyle"></div>
                        <div id="deleteNotice"></div>


                        <h3 id="pSelection"></h3>
                        <p id="weekTag">
                        <span onclick="showHide(this)" data-tabnum="3">4</span>
                        <span onclick="showHide(this)" data-tabnum="2">3</span>
                        <span onclick="showHide(this)" data-tabnum="1">2</span>
                        <span onclick="showHide(this)" data-tabnum="0">1</span>
                        </p>

                        <p id="startButton"></p>
                        <div class="panelStyle" id="initialRows">
                            <div id="txtHintHR"></div>
                        </div>

                    </div>


                </div>
              </div>



    <!-- Footer Partial -->
   <?php include('includes/footer.inc.php'); ?>
