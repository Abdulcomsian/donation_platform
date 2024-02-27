<script>
    function addFormData(url , form , loader , redirectUrl = null , submitBtn = null ,  fn = null){
        // console.log(arguments)
        loader.classList.remove("d-none")
        // submitBtn.setAttribute('disabled' , true);
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
                        // submitBtn.removeAttribute('disabled' , true);
                }
                if(res.status){
                    if(fn != null){
                            fn();
                        }

                    if(redirectUrl != null){
                        window.location.href = res.paramId ? redirectUrl+"/"+res.paramId : redirectUrl;;

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


    function updateData(data , url , loader = null , redirectUrl = null , fn =null){
        if(loader){
            loader.classList.remove("d-none");
        }
        $.ajax({
            url : url,
            type : 'POST',
            data : {
                _token : "{{csrf_token()}}",
                ...data
            },
            success : function(res){
                if(loader){
                    loader.classList.add("d-none");
                }
                if(res.status){
                    if(fn != null){
                            fn();
                        }


                    if(redirectUrl != null){
                        window.location.href = res.paramId ? redirectUrl+"/"+res.paramId : redirectUrl;

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


    function confirmationUpdate(data , url , confirmation  , redirectUrl = null , fn = null){
        Swal.fire({
                icon: "info",
                title: confirmation[0],
                text : confirmation.length == 3 ? confirmation[2] : "",
                showCancelButton: true,
                confirmButtonText: confirmation[1],
                denyButtonText: `Cancel`
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url : url,
                    type : 'POST',
                    data : {
                        _token : "{{csrf_token()}}",
                        ...data
                    },
                    success: function(res){
                        if(res.status){
                            if(fn != null){
                                fn();
                            }

                            Swal.fire({
                                text: res.msg,
                                icon: "success"
                            });
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
        });
    }

    async function getSetupIntent(connectedId)
    {
        let clientSecret = null;

        await $.ajax({
                    type : 'Post',
                    url : "{{route('setup.intent')}}",
                    data : {
                        _token : "{{csrf_token()}}",
                        connectedId : connectedId
                    },
                    success:function(res){
                        if(res.status){
                            clientSecret = res.clientSecret
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: res.error,
                                text: res.msg,
                            });
                        }
                    }
                })

        return clientSecret;
    }
</script>