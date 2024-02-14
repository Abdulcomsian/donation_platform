 <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-plan-modal">
    Create
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="create-plan-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form  method="post" action="{{route('create.plan')}}" id="create-plan-form">
                <input type="text" name="name" placeholder="name">
                <input type="number" name="amount" placeholder="amount" max="999" min="1" required>
                <button type="submit" class="plan-btn">Create <i class="fas fa-circle-notch fa-spin mx-2 d-none plan-loader"></i></button>
             </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



  <div class="data-table">
    <table id="plan-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>




  <script>

document.querySelector("#create-plan-form").addEventListener("submit" , function(e){
    e.preventDefault();
    let form = new FormData(this);
    let url = this.getAttribute("action");
    let loader = document.querySelector(".plan-loader");
    let submitBtn = document.querySelector(".plan-btn");
    addFormData(url , form , loader ,  null , submitBtn , togglePlanModal )

})

$(document).on("click" , ".delete-plan-btn" , function(e){
            e.stopImmediatePropagation();
            let planId = this.dataset.planId;
            let data = {planId , planId};
            let url  = "{{route('delete.plan')}}";
            let confirmationHeader = "Are you sure you want to delete plan";
            let confirmationTextBtn = "Delete";
            let confirmationText = "By deleting this plan all the data for this plan has been lost."
            confirmationUpdate(data , url , [ confirmationHeader , confirmationTextBtn , confirmationText] , null , loadPlanTable);
})


function togglePlanModal(){
    $("#create-plan-modal").modal("toggle")
    loadPlanTable();
}



  </script>