      <!-- | Geolocation Modal Start | -->
      <div id="geoModal" class="w3-modal">
        <div class="w3-modal-content w3-card-4 w3-round" style="max-width:30vw">
          <div class="w3-center"><br>
            <span id="closeModal" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
            <h2>Geolocation</h2>
          </div>
            <div class="w3-container w3-section">
              <label>Place taken: <b><?php echo $fetchGeoPerms['address'];?></b></label><br><br>
              <div id="map"></div>
              <?php 
              $select = "SELECT * FROM uploads WHERE user_id='".$_SESSION['user']['user_id']."' AND upload_id='".$fetchGeo['upload_id']."' ";
              $query = mysqli_query($connect, $select);
              if (mysqli_num_rows($query) > 0) {
              	echo '
	              <label>Wrong address? Enter a new one!<br><input type="text" placeholder="New address" id="newGeoAddress"></label>
	              <button type="button" class="w3-button w3-indigo" id="setNewAddress">Set</button>              	
	              ';
              }
              ?>

            </div>
          <div class="w3-container w3-border-top w3-padding-16 w3-light-grey w3-round">
            <button id="closeModalBtn" type="button" class="w3-button w3-red">Cancel</button>  
            <?php 
              if (mysqli_num_rows($query) > 0) {
              	echo '
	              <button id="disableGeoLocation" name="'.$upload_name.'" type="button" class="w3-button w3-red w3-right">Disable Geolocation</button>          	
	              ';
              }
            ?>        
          </div>
        </div>
      </div>
      <!-- | Geolocation Modal End | -->

      <script>

    var address = <?php echo "'".$fetchGeoPerms['address']."'"; ?>;

    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({ "address": address }, function(results, status) {

      if (status == google.maps.GeocoderStatus.OK) {

        var map = new google.maps.Map(document.getElementById("map"), {
          zoom: 6,
          center: results[0].geometry.location,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
          });

       }

     });
    </script>

    <?php 

    if (mysqli_num_rows($query) > 0) {
       	echo '
		
       	    <script>

        geocoder = new google.maps.Geocoder();

  function getCoordinates(address) {
    var address;
    geocoder.geocode({address: address}, function(results, status) {
      address = results[0].formatted_address;';
      echo 'var name = "'.$fetchGeo['upload_name'].'";';

      echo '
      $.post("./php/upload/setGeo.php", {name: name, address: address}, function(data) {
        alert(data);
      });
    });
  }

      $("#setNewAddress").on("click", function(data) {
        var address = $("#newGeoAddress").val();
        if (address) {
          getCoordinates(address);
          $("#geoModal").css({"display": "none"});
        } else {
          alert("Please fill in a valid address!");
        }      
      });

            $("#disableGeoLocation").on("click", function() {
        var x = this.name;
          $.post("./php/upload/disableGeo.php", {x: x}, function(data) {
            $("#geoModal").css({"display": "none"});
          });
      });

      </script>

		';
    }

    ?>

