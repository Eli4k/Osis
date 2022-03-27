var toolbarOptions = [
    [{ 'font': [] }],
    [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
    [{ 'align': [] }],
    [{ 'header': [] }],
    ['bold', 'italic', 'underline', 'strike','link','image','video'],
    ['blockquote', 'code-block'],
    [{'list':'ordered'},{'list':'bullet'}],
    [{ 'direction': 'rtl' }]
  ];

  var options = {
    debug: 'info',
    modules: {
      toolbar:toolbarOptions
    },
    placeholder: 'Compose a content....',
    theme: 'snow'
  };

  var about_editor = document.querySelector("#about_editor");
  var about_tools = document.querySelector("#about_tools");
  var editor = new Quill("#about_editor", options);
  about_editor.style.height="60vh";
  about_tools.style.width="75vw";
  about_tools.style.textAlign="center";
  var about_form = document.getElementById('about_form');

  // About onsubmit
about_form.onsubmit = function(e){
    e.preventDefault();
    var formData = new FormData();
    formData.append('delta', editor.root.innerHTML);
    formData.append('user', ad_id);

    $.ajax({
        url: "../../php/admin/web/about/insert.php",
        type: "POST",
        processData: false,
        contentType: false,
        dataType: "json",
        data: formData,
        success: function(data){
          document.querySelector("#req_response").style.display = "block";
          document.querySelector("#req_response").innerHTML = data.response;
          setTimeout(function(){
            document.querySelector("#req_response").style.display = "none";
          }, 3000);
        },
        error: function(err)
        {
          console.log("Unable to load: "+err.message);
        }
    });
  }
  // End about onsubmit
