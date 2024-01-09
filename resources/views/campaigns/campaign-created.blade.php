@extends('layouts.dashboard.main')

@section('stylesheets')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
<link
    href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&display=swap"
    rel="stylesheet">
<link
    href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
<link
    href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/campaign-created.css') }}">
@endsection

@section('content')
<div class="campaign-created">
    <div class="success">
        <div class="success-icon">
            <img src="{{ asset('assets/images/Group.png') }}" alt="">
        </div>
        <div class="success-text">Your campaign has successfully created</div>
    </div>

    <div class="url-container">
        <div class="heading">Share Your Campaign URL</div>
        <div class="url">
            <a href="" id="textToCopy">https://donation.donation.com/name/campaign/donation</a>
        </div>
        <div class="action-container">
            <button class="copy" onclick="copyText()"><img src="{{ asset('assets/images/copy-outline.png') }}" alt="">
                Copy Link</button>
            <a class="view" href=""><img src="{{ asset('assets/images/eye-outline.png') }}" alt=""> View Page</a>
        </div>
    </div>

    <div class="share-actions">
        <a class="edit" href=""><img src="{{ asset('assets/images/bxs_edit.png') }}" alt="">Edit</a>
        <a class="share" href=""><img src="{{ asset('assets/images/share-social-outline.png') }}" alt="">Share</a>
    </div>
</div>

<script>
    function copyText() {
      // Get the text to copy
      var textToCopy = document.getElementById("textToCopy").innerText;

      // Create a temporary textarea element
      var tempTextArea = document.createElement("textarea");
      tempTextArea.value = textToCopy;

      // Append the textarea to the body
      document.body.appendChild(tempTextArea);

      // Select the text in the textarea
      tempTextArea.select();
      tempTextArea.setSelectionRange(0, 99999); // For mobile devices

      // Copy the text to the clipboard
      document.execCommand("copy");

      // Remove the temporary textarea
      document.body.removeChild(tempTextArea);

      // Optionally, provide feedback to the user
      alert("Text copied to clipboard: " + textToCopy);
    }
</script>
@endsection