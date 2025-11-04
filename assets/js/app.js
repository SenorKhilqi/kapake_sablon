// assets/js/app.js
document.addEventListener('DOMContentLoaded', function(){
  // Image preview for file inputs that have data-preview-target attribute
  document.querySelectorAll('input[type=file][data-preview-target]').forEach(function(input){
    var targetSelector = input.getAttribute('data-preview-target');
    var preview = document.querySelector(targetSelector);
    if (!preview) return;
    input.addEventListener('change', function(e){
      var file = input.files && input.files[0];
      if (!file) { preview.src = ''; preview.style.display='none'; return; }
      var reader = new FileReader();
      reader.onload = function(ev){
        preview.src = ev.target.result;
        preview.style.display = 'block';
      }
      reader.readAsDataURL(file);
    });
  });
});
// assets/js/app.js
console.log('Sablon Custom loaded');
