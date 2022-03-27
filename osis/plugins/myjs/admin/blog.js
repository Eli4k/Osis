var form = document.getElementById('this_form');
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

  // var editors = document.querySelectorAll("#editor");

  var editors = new Quill('#editors', options);
  form.querySelector('#editors').style.height="80vh";
  form.querySelector('#title').style.width="75vw";
  form.querySelector('#title').style.textAlign="center";





  form.onsubmit = function(e){
    e.preventDefault();
    var formData = new FormData();
    formData.append('thumbnail', form.querySelector('input[type=file]').files[0]);
    formData.append('title', form.querySelector('#title').value);
    formData.append('submit', form.querySelector('input[type=submit]').value);
    formData.append('delta', editors.root.innerHTML);
    formData.append('user', ad_id);

      $.ajax({
        url: "../../php/admin/events/post_upload.php",
        type:"POST",
        processData: false,
        contentType: false,
        dataType:"json",
        data: formData,
        success: function(data){
          document.querySelector("#req_response").style.display = "block";
          document.querySelector("#req_response").innerHTML = data.response;
          setTimeout(function(){
            document.querySelector("#req_response").style.display = "none";
          }, 100000000);
        },
        error: function(err){
          console.log(err.message);
        }
      })

    };
