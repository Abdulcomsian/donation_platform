<script>
    function addFormData(url , form , loader , redirectUrl = null , submitBtn = null){
        loader.classList.remove("d-none")
        submitBtn.setAttribute('disabled' , true);
        form.append("_token" , '{{csrf_token()}}');
        $.ajax({
            url : url,
            type : 'POST',
            data : form,
            processData : false,
            contentType : false,
            success:function(res){
                loader.classList.add("d-none")
                if(submitBtn != null){
                        submitBtn.removeAttribute('disabled' , true);
                }
                if(res.status){
                    if(redirectUrl != null){
                        window.location.href = redirectUrl;
                    }else{
                        Swal.fire({
                            text: res.msg,
                            icon: "success"
                        });
                    }
                }else{
                    Swal.fire({
                        icon: "error",
                        title: res.msg,
                        text: res.error,
                    });
                }
            }
        })
    }
</script>