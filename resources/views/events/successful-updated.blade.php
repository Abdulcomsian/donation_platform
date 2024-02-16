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
        <div class="success-text">Your event has successfully updated</div>
    </div>

    <div class="url-container">
        <div class="heading">Share Your Event URL</div>
        <div class="url">
            <a href="{{url('event-detail' , $eventId)}}" id="textToCopy">{{url('event-detail' , $eventId)}}</a>
        </div>
        <div class="action-container">
            <button class="copy" onclick="copyText()"><img src="{{ asset('assets/images/copy-outline.png') }}" alt="">
                Copy Link</button>
            <a class="view" href="{{url('event-detail' , $eventId)}}"><img src="{{ asset('assets/images/eye-outline.png') }}" alt=""> View Page</a>
        </div>
    </div>

    <div class="share-actions">
        <a class="edit" href="{{url('events/edit-event' , $eventId)}}"><img src="{{ asset('assets/images/bxs_edit.png') }}" alt="">Edit</a>
        <button class="share" type="button" data-bs-toggle="modal" data-bs-target="#share-link-modal">
            <img src="{{ asset('assets/images/share-social-outline.png') }}" alt="">Share
        </button>
    </div>

    <div class="modal fade" id="share-link-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="share-link-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="share-link-modal-label">Embed Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="iframe-container" id="iframe-content">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cancel" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="save">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function replaceMarkUp() {
        let iframeContent = '<iframe width="560" height="315" src="{{url('event-detail' , $eventId)}}" title="Donation Widget box" frameborder="0" allow="accelerometer; auto; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
        
        iframeContent = iframeContent.replace(/</g, '&lt;');
        iframeContent = iframeContent.replace(/>/g, '&gt;');
        
        // Get the container element
        var container = document.getElementById('iframe-content');
        
        // Set the HTML content of the container to your iframe code
        container.innerHTML = iframeContent;
    }

    replaceMarkUp();
    
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