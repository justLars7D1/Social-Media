      <!-- | Geolocation Modal Start | -->
      <div id="geoModal" class="w3-modal">
        <div class="w3-modal-content w3-card-4 w3-round" style="max-width:30vw">
          <div class="w3-center"><br>
            <span id="closeModal" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
            <h2>Geolocation</h2>
          </div>
            <div class="w3-container w3-section">
              <label>It seems like you have currently disabled <b>Geolocation</b> for this post, <i>enable</i> this feature in order to use it.</label><br>
            </div>
          <div class="w3-container w3-border-top w3-padding-16 w3-light-grey w3-round">
            <button id="closeModalBtn" type="button" class="w3-button w3-red">Cancel</button>   
          <?php echo '<button id="enableGeoLocation" name="'.$fetchGeo['upload_name'].'" type="button" class="w3-button w3-green w3-right">Enable</button>'; ?>           
          </div>
        </div>
      </div>
      <!-- | Geolocation Modal End | -->

      <script>

      $("#enableGeoLocation").on("click", function() {
        var x = this.name;
          $.post("./php/upload/enableGeo.php", {x: x}, function(data) {
            $("#geoModal").css({"display": "none"});
          });
      });

      </script>

    ';