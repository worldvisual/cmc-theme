<script>
  (() => { 
 /*
  load sidebar with ajax
  */
  const loadSidebarAjax = () => {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
        if (xmlhttp.status == 200) {
          document.getElementById('secondary').innerHTML = xmlhttp.responseText;
        }
          else if (xmlhttp.status == 400) {
          console.log('There was an error 400');
        }
        else {
          console.log('something else other than 200 was returned');
        }
      }
    };
    xmlhttp.open('GET', '<?php echo get_template_directory_uri(); ?>/sidebar.php', true);
    xmlhttp.send();
  }

  const checkResolution = () => {
    const element = document.getElementById('primary');
    if (screen.width > 991) {
      loadSidebarAjax();
      element.classList.remove('without-sidebar');
    } else {
      document.getElementById('secondary').innerHTML = '';
      element.classList.add('without-sidebar');
    }    
  };
  window.addEventListener('resize', checkResolution);
  checkResolution();
})();

</script>
<aside id="secondary"></aside>