<div class="row" id="dashboardInfo">
   <div class="medium-2 columns shadowRight">
     <img src="<?php get_theme_url() ?>/img/nhs24logoSmall.png" alt="NHS 24 logo"/>
     <p>. . .</p>
     <p>Status</p>
     <?php

       if($page == 'index'){
         ?>
         <form id="location">
           <input class="choices" id="p1" onclick ="showRows('p1')" type="radio" name="locationSet" value="0"> P1
           <input class="choices" id="p2" onclick ="showRows('p2')" type="radio" name="locationSet" value="1"> P2
         </form>

      <?php }

       if(isset($userOnline) && $userOnline == "y"){
         ?><ul>
         <li class="divLine"> . . . </li>
         <li><a class="update" href="<?php echo get_site_url().'index.php?id=create' ?>"><i class="fas fa-ticket-alt"></i> Create new ticket</a></li>
         <li><a class="home" href="<?php echo get_site_url();?>"><i class="fas fa-home"></i> Home</a></li>
         <li><a class="home" href="<?php echo get_site_url().'index.php?id=help'?>"><i class="fas fa-info-circle"></i> Help</a></li></ul>
       <?php }
       else{ ?>
           <li><a class="home" href="<?php echo get_site_url().'index.php?id=help'?>"><i class="fas fa-info-circle"></i> Help</a></li>
           <li><a class="home" href="<?php echo get_site_url();?>"><i class="fas fa-home"></i> Home</a></li></ul>
       <?php } ?>

       <footer id="footer">
            <div class="copyright">
              <span>Change Desk - &copy;NHS 24 <?php echo date('Y') ;?></span>
            </div>

       </footer>

   </div>
