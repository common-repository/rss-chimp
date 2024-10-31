//Tab navigation
    /**
     * Activates a tab based on the current URL hash, or defaults to the first tab if no hash is provided.
     * This function hides all tab contents and removes the 'active' class from all tab links.
     * It then displays the tab content and adds the 'active' class to the corresponding tab link
     * based on the current hash in the URL or defaults to the first tab.
     */
    function activateTabByHash() {
      // Extract the hash from the URL (e.g., #overview, #info)
      var hash = window.location.hash;

      // Query all tab content and tab link elements
      var tabcontent = document.querySelectorAll(".tabcontent");
      var tablinks = document.querySelectorAll(".tablinks");

      // Hide all tab contents
      tabcontent.forEach(tc => tc.style.display = "none");
      // Remove 'active' class from all tab links
      tablinks.forEach(tl => tl.classList.remove("active"));

      if (hash) {
          // If a hash is present, show the corresponding tab content and highlight the tab link
          var selectedTabContent = document.querySelector(hash);
          var selectedTabLink = document.querySelector(`.tablinks[href="${hash}"]`);

          if (selectedTabContent && selectedTabLink) {
              selectedTabContent.style.display = "block";
              selectedTabLink.classList.add("active");
          }
      } else {
          // If no hash is present, activate the first tab by default
          if (tabcontent.length > 0 && tablinks.length > 0) {
              tabcontent[0].style.display = "block";
              tablinks[0].classList.add("active");
          }
      }
  }

  /**
   * Sets up the event listeners and initializes the tab state when the document is ready.
   * This includes handling the hash change event and click events on the tab links.
   */
  document.addEventListener('DOMContentLoaded', function() {
      // Activate the appropriate tab based on the current URL hash or default to the first tab
      activateTabByHash();

      // Add event listener to handle changes in the URL hash
      window.addEventListener('hashchange', activateTabByHash, false);

      // Add click event listeners to the tab links to update the URL hash
      var tablinks = document.querySelectorAll(".tablinks");
      tablinks.forEach(link => {
          link.addEventListener('click', function(event) {
              event.preventDefault(); // Prevent the default anchor link behavior
              window.location.hash = this.getAttribute('href'); // Update the URL hash
          });
      });
  });

jQuery(document).ready(function($){
  var mediaUploader;
  $('#upload_image_button').click(function(e) {
    e.preventDefault();
      if (mediaUploader) {
      mediaUploader.open();
      return;
    }
    mediaUploader = wp.media.frames.file_frame = wp.media({
      title: 'Choose Image',
      button: {
      text: 'Choose Image'
    }, multiple: false });
    mediaUploader.on('select', function() {
      var attachment = mediaUploader.state().get('selection').first().toJSON();
      $('#background_image').val(attachment.url);
      $("#background_image_thumb").attr("src",attachment.url);
    });
    mediaUploader.open();
  });
});

function ClearFields() {
  document.getElementById("background_image").value = "";
  document.getElementById("background_image_thumb").src = "";
}