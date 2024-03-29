<div class="admin">
    <div class="header">
        
        <div class="add-btn-container">
            <button type="button" data-bs-toggle="modal" data-bs-target="#add-user-modal"><span>+</span>&nbsp;Add
                User</button>
        </div>
    </div>

    <div class="data-table">
        <table id="user-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- <tr>
                    <td class="name">John Doe</td>
                    <td class="email">johndoe@gmail.com</td>
                    <td class="role form-control add-arrow">
                        <select name="role" id="role">
                            <option value="Owner" selected>Owner</option>
                            <option value="Admin">Admin</option>
                            <option value="Editor">Editor</option>
                        </select>
                    </td>
                    <td class="status">
                        <div class="active">
                            <div class="icon"></div>
                            <div class="text">Active</div>
                        </div>
                    </td>
                    <td class="action">
                        <button type="button" class="delete-container">
                            <img src="{{ asset('assets/images/trash-outline.png') }}" alt="">
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="name">John Doe</td>
                    <td class="email">johndoe@gmail.com</td>
                    <td class="role form-control add-arrow">
                        <select name="role" id="role">
                            <option value="Owner">Owner</option>
                            <option value="Admin">Admin</option>
                            <option value="Editor" selected>Editor</option>
                        </select>
                    </td>
                    <td class="status">
                        <div class="active">
                            <div class="icon"></div>
                            <div class="text">Active</div>
                        </div>
                    </td>
                    <td class="action">
                        <button type="button" class="delete-container">
                            <img src="{{ asset('assets/images/trash-outline.png') }}" alt="">
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="name">John Doe</td>
                    <td class="email">johndoe@gmail.com</td>
                    <td class="role form-control add-arrow">
                        <select name="role" id="role">
                            <option value="Owner">Owner</option>
                            <option value="Admin" selected>Admin</option>
                            <option value="Editor">Editor</option>
                        </select>
                    </td>
                    <td class="status">
                        <div class="pending">
                            <div class="icon"></div>
                            <div class="text">Pending</div>
                        </div>
                    </td>
                    <td class="action">
                        <button type="button" class="delete-container">
                            <img src="{{ asset('assets/images/trash-outline.png') }}" alt="">
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="name">John Doe</td>
                    <td class="email">johndoe@gmail.com</td>
                    <td class="role form-control add-arrow">
                        <select name="role" id="role">
                            <option value="Owner">Owner</option>
                            <option value="Admin" selected>Admin</option>
                            <option value="Editor">Editor</option>
                        </select>
                    </td>
                    <td class="status">
                        <div class="pending">
                            <div class="icon"></div>
                            <div class="text">Pending</div>
                        </div>
                    </td>
                    <td class="action">
                        <button type="button" class="delete-container">
                            <img src="{{ asset('assets/images/trash-outline.png') }}" alt="">
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="name">John Doe</td>
                    <td class="email">johndoe@gmail.com</td>
                    <td class="role form-control add-arrow">
                        <select name="role" id="role">
                            <option value="Owner">Owner</option>
                            <option value="Admin" selected>Admin</option>
                            <option value="Editor">Editor</option>
                        </select>
                    </td>
                    <td class="status">
                        <div class="active">
                            <div class="icon"></div>
                            <div class="text">Active</div>
                        </div>
                    </td>
                    <td class="action">
                        <button type="button" class="delete-container">
                            <img src="{{ asset('assets/images/trash-outline.png') }}" alt="">
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="name">John Doe</td>
                    <td class="email">johndoe@gmail.com</td>
                    <td class="role form-control add-arrow">
                        <select name="role" id="role">
                            <option value="Owner">Owner</option>
                            <option value="Admin">Admin</option>
                            <option value="Editor" selected>Editor</option>
                        </select>
                    </td>
                    <td class="status">
                        <div class="active">
                            <div class="icon"></div>
                            <div class="text">Active</div>
                        </div>
                    </td>
                    <td class="action">
                        <button type="button" class="delete-container">
                            <img src="{{ asset('assets/images/trash-outline.png') }}" alt="">
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="name">John Doe</td>
                    <td class="email">johndoe@gmail.com</td>
                    <td class="role form-control add-arrow">
                        <select name="role" id="role">
                            <option value="Owner">Owner</option>
                            <option value="Admin">Admin</option>
                            <option value="Editor" selected>Editor</option>
                        </select>
                    </td>
                    <td class="status">
                        <div class="active">
                            <div class="icon"></div>
                            <div class="text">Active</div>
                        </div>
                    </td>
                    <td class="action">
                        <button type="button" class="delete-container">
                            <img src="{{ asset('assets/images/trash-outline.png') }}" alt="">
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="name">John Doe</td>
                    <td class="email">johndoe@gmail.com</td>
                    <td class="role form-control add-arrow">
                        <select name="role" id="role">
                            <option value="Owner">Owner</option>
                            <option value="Admin">Admin</option>
                            <option value="Editor" selected>Editor</option>
                        </select>
                    </td>
                    <td class="status">
                        <div class="active">
                            <div class="icon"></div>
                            <div class="text">Active</div>
                        </div>
                    </td>
                    <td class="action">
                        <button type="button" class="delete-container">
                            <img src="{{ asset('assets/images/trash-outline.png') }}" alt="">
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="name">John Doe</td>
                    <td class="email">johndoe@gmail.com</td>
                    <td class="role form-control add-arrow">
                        <select name="role" id="role">
                            <option value="Owner">Owner</option>
                            <option value="Admin">Admin</option>
                            <option value="Editor" selected>Editor</option>
                        </select>
                    </td>
                    <td class="status">
                        <div class="inactive">
                            <div class="icon"></div>
                            <div class="text">Inactive</div>
                        </div>
                    </td>
                    <td class="action">
                        <button type="button" class="delete-container">
                            <img src="{{ asset('assets/images/trash-outline.png') }}" alt="">
                        </button>
                    </td>
                </tr> --}}
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="add-user-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="add-user-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add-user-modal-label">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-container">
                        <form method="POST" action="{{route('add.user')}}" id="user-form">
                            <div class="form-control-name">
                                <label for="userName">First Name</label>
                                <input type="text" id="userName" placeholder="" name="first_name" required>
                            </div>
                            <div class="form-control-name">
                                <label for="userName">Last Name</label>
                                <input type="text" id="userName" placeholder="" name="last_name" required>
                            </div>
                            <div class="form-control-email">
                                <label for="email">User Email</label>
                                <div class="email-role-container">
                                    <input type="email" id="email" name="email" placeholder="johndoe@gmail.com" required>
                                    <select name="role" id="role" required>

                                        <option value="{{\AppConst::NON_PROFIT_ORGANIZATION}}">Non profit organization</option>
                                        <option value="{{\AppConst::FUNDRAISER}}">Fundraiser</option>
                                    </select>
                                </div>
                            </div>

                            <div class="submit-action">
                                <button class="send-invite" type="submit">Send Invite<i class="fas fa-circle-notch fa-spin mx-2 d-none user-loader"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        document.getElementById("user-form").addEventListener("submit" , function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            let form = new FormData(this);
            let url = this.getAttribute("action");
            let loader = document.querySelector(".user-loader");
            let submitBtn = document.querySelector(".send-invite");
            addFormData(url , form , loader ,  null , submitBtn , toggleAdminModal )
        })

        function toggleAdminModal(){
            $("#add-user-modal").modal("hide");
            loadTable(); 
        }


        $(document).on("change" , ".role" , function(e){
            e.stopImmediatePropagation();
            let userId = this.dataset.userId;
            let role = this.value;
            let data = { userId : userId , role : role};
            let url = "{{route('update.role')}}";
            updateData(data , url );
        })


        $(document).on("click" , ".delete-user-btn" , function(e){
            e.stopImmediatePropagation();
            let userId = this.dataset.userId;
            let data = {userId , userId};
            let url  = "{{route('delete.user')}}";
            let confirmationHeader = "Are you sure you want to delete user";
            let confirmationTextBtn = "Delete";
            let confirmationText = "By deleting this user all the data for this user has been lost."
            confirmationUpdate(data , url , [ confirmationHeader , confirmationTextBtn , confirmationText] , null , loadTable);
        })

    })
</script>