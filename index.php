<?php session_start();
  if(!isset($_SESSION['username']))
    header("Location: login.php");
  include('templates/header.php');
?>
<?php
  if(isset($_GET['search']) && !isset($_GET['event']) && !isset($_GET['user'])){
    // In the case of a search
    //new function for events, get 10 events starting on result x
    ?><div id="listEvents" class="displayEvents">
      <h2>Search Results for '<?=$_GET['search']?>'</h2>
      <?php
        include("database/events.php");
        include_once("templates/display_event.php");
        $finalSearch = getEventsSearch($_GET['search']);    // print search result
        for($i = 0; $i < count($finalSearch); $i++){
          displaySmallEvent($finalSearch[$i]);
        }
      ?>
    </div><?php

  } else {
    if(isset($_GET['user']) && !isset($_GET['search']) && !isset($_GET['event'])){
      // In the case of a user page
      ?><script type="text/javascript" src="scripts/user_page.js"></script>
      <div id="userPage">
        <div id="userHolder" class="contentHolder">
          <h2><?php echo $_GET['user'] ?></h2>
        </div>
      </div><?php

    } else {
      if(isset($_GET['event']) && !isset($_GET['user']) && !isset($_GET['search'])){
        // In the case of an event page
        ?><script type="text/javascript" src="scripts/event_item.js"></script>
        <div id="eventHolder" class="contentHolder"><?php
          include_once('database/events.php');
          include_once('database/comments.php');

          $event = getEvent($_GET['event']);
          $comments = getEventComments($_GET['event']);

          if (!$event) die();

          if(!($event['publicEvent']==1 || $event['creator']==$_SESSION['username'] || isInvited($_SESSION['username'], $event['id'])))
            die();

          include_once("templates/view_event.php");
          include_once("templates/list_comments.php");?>
        </div><?php

      } else {?>
        <div id="attending" class="displayEvents">
          <h1>Events you are going to attend</h1>
          <img src="res/loading.gif">
        </div>
        <div id="attended" class="displayEvents">
          <h1>Events you attended</h1>
          <button id="loadAttendedEvents">Events Atended</button>
        </div>
        <script type="text/javascript" src="scripts/listattendance.js"></script>
        <?php
      }
    }
  }?>
  </body>
  <script type="text/javascript" src="scripts/main.js"></script>
</html>
