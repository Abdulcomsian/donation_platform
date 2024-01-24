<div class="organization">
    <div class="form-container">
        <form action="">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-control-name">
                        <label for="organization-name">Organization Name</label>
                        <input type="text" id="organization-name" name="organization-name" placeholder="Donate"
                            value="Donate" required>
                    </div>
                    <div class="form-control-type">
                        <label for="type">Organization Type</label>
                        <select name="type" id="type" required>
                            <option value="Non Profit">Non Profit</option>
                        </select>
                    </div>
                    <div class="form-control-logo">
                        <label for="logo">Organization Logo</label>
                        <div class="image-upload">
                            <input type="file" class="d-none" name="file" id="file" onchange="onFileChange(event)">
                            <label class="label" for="image">Image</label>
                            <button type="button" onclick="importFile(event)">Upload Image</button>
                            <span class="selectFile" data-bs-toggle="tooltip" data-bs-placement="top"
                                id="selectFile"></span>
                            <label class="info" for="">Recommended Size: 300px x 300px</label>
                        </div>
                    </div>
                    <div class="form-control-description">
                        <label for="description">Organization Description</label>
                        <textarea name="description" id="description"
                            value="Lorem ipsum dolor sit amet consectetur. Eget risus massa semper maecenas bibendum. Morbi volutpat varius vel blandit senectus."
                            placeholder="Enter Organization Description"></textarea>
                    </div>
                    <div class="form-control-website">
                        <label for="website">Organization Website</label>
                        <input type="text" id="website" name="website" placeholder="Enter Organization Website">
                    </div>
                </div>
            </div>
            <div class="submit">
                <button type="submit">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    function importFile(event) {
        event.preventDefault()
        let file = document.getElementById("file");
        file.click();
    }

    function onFileChange(event) {
        event.preventDefault();
        const file = event.target.files[0];

        const element = document.getElementById('selectFile');
        element.innerHTML = file.name;
        element.title = file.name;
    }
</script>