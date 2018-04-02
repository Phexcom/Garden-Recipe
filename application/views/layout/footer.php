
    <script src="<?php echo(asset_url());?>assets/js/jquery.min.js"></script>
    <script src="<?php echo(asset_url());?>assets/js/chart.js"></script>
    <script src="<?php echo(asset_url());?>assets/js/toolkit.js"></script>
    <script src="<?php echo(asset_url());?>assets/js/application.js"></script>
    <script>
      // execute/clear BS loaders for docs
      $(function(){
        if (window.BS&&window.BS.loader&&window.BS.loader.length) {
          while(BS.loader.length){(BS.loader.pop())()}
        }
      })

    document.getElementById("files").onchange = function () {
      var reader = new FileReader();

      reader.onload = function (e) {
          // get loaded data and render thumbnail.
          document.getElementById("image").src = e.target.result;
      };

      // read the image file as a data URL.
      reader.readAsDataURL(this.files[0]);
    };
    </script>
  </body>
</html>