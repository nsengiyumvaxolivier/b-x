
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>B-X Login</title>
   <script src="./plugins/css/tailwindcss.js"></script>
   <link rel="stylesheet" href="./plugins/icons/bootstrap-icons.css">
   <script src="./plugins/js/jquery-3.7.1.min.js"></script>
</head>
<body>
<div class="container-fluid bg-yellow-900 h-screen flex p-2">
   <div class="container p-3 bg-yellow-800 border border-4 border-dashed border-yellow-500 rounded m-auto md:w-1/3">
   
      <div class="flex justify-between p-1">
      <h1 class="text-white font-bold p-2">Login To <span class="animate animate-ping text-blue-500">B-X</span> </h1>
      <p class="p-2 rounded font-bold text-sm" id="message"></p>
   </div>
      <hr class="text-black">
      <div class="row p-3">
         <label for="" class="font-bold text-white">Username</label>
         <div class="flex rounded border border-yellow-500 border-2 my-3"><i class="bi bi-person-fill bg-yellow-500 font-bold w-[10%] p-1 text-center"></i><input  type="text" name="username" autocomplete="off" id="username" class="bg-white w-[90%] p-1 outline-none text-sm font-bold"></div>
      </div>
       <div class="row p-3">
         <label for="" class="font-bold text-white">Password</label>
         <div class="flex rounded border border-yellow-500 border-2 my-3"><i class="bi bi-lock-fill bg-yellow-500 font-bold w-[10%] p-1 text-center"></i><input type="password" name="password" autocomplete="off" id="password" class="bg-white w-[90%] p-1 outline-none text-sm font-bold"></div>
      </div>
       <div class="row p-3">
       
         <div class="flex justify-center my-3 p-2">
            <button type="button" id="login" class="border border-2 w-1/2 shadow shadow-yellow-500 rounded border-yellow-500 bg-yellow-500/30 hover:bg-yellow-500 p-2 text-white px-4 font-bold" name="login"><b><i class="bi bi-box-arrow-in-right font-bold"></i></b> Login</button>
            
         </div>
      </div>

   </div>
</div>
   
</body>
</html>
<script>
   $("#login").click(function () {
      var user =$("#username").val();
      var pass =$("#password").val()
      $.ajax({
         url:"./apis/login.php",
         type:"post",
         dataType:"json",
         data:{
            username:user,
            password:pass
         },
        success:function (data) {
        
        if (data.status=="ok") {
            window.location.href="./pages/";
        }
        else{
            $("#message").text(data.message);
            $("#message").removeClass("text-white");
            $("#message").addClass("text-white");
            $("#message").addClass("bg-red-500");



        }
        }

      })


   })

</script>
