<div class="row" id="dashboardInfo">
   <div class="medium-2 columns shadowRight">
     <img src="<?php get_theme_url() ?>/img/cdlogoTiny.png" alt="Change desk logo"/>
     <hr>
     <h4>Changes</h4>
     <p>
       <a id="changeBtn" class="update choices" href="#" data-ptype = 'cr'><i class="fa fa-eye" aria-hidden="true"></i> Changes</a>
     </p>
     <p>
      <a class="update" id="crticket" href="<?php echo get_site_url().'index.php?id=create' ?>"><i class="fas fa-ticket-alt"></i> Create new CR</a>
     </p>
    
     <?php
     if(isset($userOnline) && $userOnline == "y"){



       if($page == 'index'){
         ?>
         <hr>
         <h4>P tickets</h4>
         <form id="location">
           <input class="choices" id="p1" data-ptype = 'p1'; type="radio" name="locationSet" value="0"> P1
           <input class="choices" id="p2" data-ptype = 'p2'; type="radio" name="locationSet" value="1"> P2
         </form>

      <?php }

       
         ?><ul>
         
         <li><a class="update" href="<?php echo get_site_url().'index.php?id=create' ?>"><i class="fas fa-ticket-alt"></i> Create new 'P'</a></li>
         <li><a class="home" href="<?php echo get_site_url();?>"><i class="fas fa-home"></i> Home</a></li>
         <li><a class="home" href="<?php echo get_site_url().'index.php?id=help'?>"><i class="fas fa-info-circle"></i> Help</a></li></ul>
       <?php }
       else{ ?>
        <ul class="notin">
          <li><a class="home" href="<?php echo get_site_url();?>"><i class="fas fa-home"></i> Home</a></li>
           <li><a class="home" href="<?php echo get_site_url().'index.php?id=help'?>"><i class="fas fa-info-circle"></i> Help</a></li>
           </ul>
       <?php } ?>

       <footer id="footer">
        <hr>
            <div class="copyright">
              <span>Change Desk 2020</span>
            </div>

       </footer>

   </div>
