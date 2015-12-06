<div id="new_event_form">
  <img src="res/callendar.png" width="80" height="80">
  <h2> Create a new event </h2>
  <form name="new_event" id="new_event" action="upload.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" />
      <label> Name </label>
      <input type="text" name="nameTag" placeholder="Event's name" required />
        <br><br>
      <label> Type </label>
      <select></select>
        <br><br>
      <label> Details </label>
      <textarea name="description"  placeholder="Add event information" /></textarea>
        <br><br>
      <label> When </label>
      <input type="datetime-local" name="time" placeholder="Time" required />
        <br><br>
      <label> Where </label>
      <input type="text" name="city" placeholder="City" required />
      <input type="text" name="address" placeholder="Address" />
        <br><br>
      <label> Image </label>
      <input type="file" name="imageURL">
        <br><br>
      <label class="publicEvent"> Public event </label>
      <input type="checkbox" name="publicEvent" checked /><br>
        <br><br>
      <input id="saveEvent" type="button" value="Save event" />
  </form>
</div>
