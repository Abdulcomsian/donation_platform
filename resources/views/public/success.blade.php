<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
      @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap');

.payment-success {
  width: 410px;
  box-shadow: 0 13px 45px 0 rgba(51, 59, 69, 0.1);
  margin: auto;
  border-radius: 10px;
  text-align: center;
  position: relative;
    font-family: "Quicksand", sans-serif;
}
.payment-success .header {
  position: relative;
  height: 7px;
}
.payment-success .body {
  padding: 0 50px;
  padding-bottom: 25px;
}
.payment-success .close {
  position: absolute;
  color: #0073ff;
  font-size: 20px;
  right: 15px;
  top: 11px;
  cursor: pointer;
}
.payment-success .title {
    font-family: "Quicksand", sans-serif;
  font-size: 32px;
  color: #54617a;
  font-weight: bold;
  margin-bottom: 10px;
}
.payment-success .main-img {
  width: 243px;
}
.payment-success p {
  font-size: 15px;
  color: #607d8b;
}
.payment-success .btn {
  border: none;
  border-radius: 100px;
  width: 100%;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 20px 0;
  outline: none;
  cursor: pointer;
  position: relative;
}
.payment-success .btn.btn-primary {
  background: #0073ff;
  color: #fff;
  font-weight:600;
    font-family: "Quicksand", sans-serif;
}
.payment-success .cancel {
  text-decoration: none;
  font-size: 14px;
  color: #607d8b;
}

.body {
    position: relative;
    top: 50%;
    left: 50%;
    transform: translate(-50%, 50%);
}

.redirect-btn{
  background: #5BC17F;
  color: white;
  border: 1px solid #5BC17F;
}
.redirect-btn:hover{
  background: white;
  color: #5BC17F;
}

.redirect-btn:hover a{
  color: #5BC17F;
}

a{
  text-decoration:none;
  color: white;
}

    </style>

</head>
<body>
    <div class="payment-success">
    
        <div class="body">
          <h2 class="title">Payment Successful</h2>
          <img class="main-img" src="{{asset('assets/images/payment-transfered.jpg')}}" alt="">
          <p>Your payment was successful! You can <br>now continue using Artycoin.</p>
          <a href="{{ url()->previous() }}" class="btn redirect-btn">Go Back</a>      
        </div>
      </div>
    
</body>
</html>

