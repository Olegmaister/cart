<div id="container" style="width:100%;height:100%;overflow:hidden;">
    <br>Loading...<br><br>
</div>
<script type="text/javascript">
  // base path
  const basePath = '/files/3d-tours/3d-tour-prof1group/';
  // create the panorama player with the container
  pano = new pano2vrPlayer('container');
  // add the skin object
  skin = new pano2vrSkin(pano, basePath);
  // load the configuration
  window.addEventListener('load', function () {
    pano.readConfigUrlAsync(basePath + 'pano.xml');
  });
</script>
<noscript>
    <p><b>Please enable Javascript!</b></p>
</noscript>
<!-- - - - - - - 8<- - - - - - cut here - - - - - 8<- - - - - - - -->
<!-- Hack needed to hide the url bar on iOS 9, iPhone 5s -->
<div style="width:1px;height:1px;"></div>
