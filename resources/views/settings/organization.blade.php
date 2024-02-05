<div class="organization">
    <div class="form-container">
        <form method="POST" action="{{route('updateOrganization')}}" id="organization-settings">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-control-name">
                        <label for="organization-name">Organization Name</label>
                        <input type="text" id="organization-name" name="organization_name" placeholder="Name" value="{{$user->organizationProfile->name ?? ""}}" required>
                    </div>
                    <div class="form-control-type">
                        <label for="type">Organization Type</label>
                        <select name="type" id="type" required>
                            <option value="" @if(!auth()->user()->hasRole('non_profit_organization') && !auth()->user()->hasRole('fundraiser') )selected @endif disabled>Select Organization</option>
                            @foreach($roles as $role)
                            <option value="{{$role->name}}" @if(($user->organizationProfile) && $user->organizationProfile->type == $role->name ) selected @endif>{{ucfirst(str_replace('_' , " " , $role->name))}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control-logo image-section">
                        <label for="logo">Organization Logo</label>
                        <div class="image-upload">
                            <input type="file" class="d-none image" name="file"  onchange="onFileChange(event)">
                            <label class="label" for="image">Image</label>
                            <button type="button" onclick="importFile(event)">Upload Image</button>
                            <span class="selectFile" data-bs-toggle="tooltip" data-bs-placement="top" id="selectFile"></span>
                            <label class="info" for="">Recommended Size: 300px x 300px</label>
                        </div>
                    </div>
                    <div class="form-control-description">
                        <label for="description">Organization Description</label>
                        <textarea name="description" id="description"
                            value="{{$user->organizationProfile->description ?? ""}}"
                            placeholder="Enter Organization Description">{{$user->organizationProfile->description ?? ""}}</textarea>
                    </div>
                    
                    <div class="form-control-website">
                        <label for="website">Organization Website</label>
                        <input type="url" id="website" name="website" placeholder="Enter Organization Website" value="{{$user->organizationProfile->link ?? ""}}">
                    </div>
                </div>
            </div>
            <div class="submit">
                <button type="submit" class="organization-btn">Save<i class="fas fa-circle-notch fa-spin mx-2 d-none organization-loader"></i></button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById("organization-settings").addEventListener("submit" , function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        let form = new FormData(this);
        let url = this.getAttribute("action");
        let loader = document.querySelector(".organization-loader");
        let submitBtn = document.querySelector(".organization-btn");
        addFormData(url , form , loader ,  null , submitBtn , null )
    })
</script>

