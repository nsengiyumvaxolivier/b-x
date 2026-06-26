<?php
include("connection.php");
session_start();
$sell=$_SESSION['sellout'];
$admin=$_SESSION['admin'];
$business=$_SESSION['business'];

$customer_select=mysqli_query($conn,"SELECT * from customer,sell where customer.c_id=sell.sl_customer and sell.sel_id='$sell' and sell.admin='$admin' and sell.business='$business'");
$b=mysqli_fetch_array($customer_select);
$bus=mysqli_query($conn,"SELECT * from business where admin='$admin'");
$c=mysqli_fetch_array($bus);
$customer=$b['name'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="js/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="icons/bootstrap-icons.css">
 
</head>
<body>
    <div class="cont">
        <div class="top">
           <button id="download" class="btn"> <i class="bi bi-download"></i> A5</button> 
           <button id="download-a4" class="btn"><i class="bi bi-download"></i> A4</button>
        </div>
        <div class="body">
          <div class="center"> 
        <div class="card" id="card">
<div class="b-info">
    <div class="left">
      <h1>wellcone to our shop</h1>
       <p><span><?php echo $c['b_name']?></span></p>
       <p><span><i class="bi bi-telephone-fill"></i>:</span><label for=""><?php echo $c['b_phone']?></label></p>
       <p><span>TIN:</span><label for=""><?php echo $c['b_tin']?></label></p>
    </div>
    <div class="logo"><img src="icon/logo.svg" alt=""> </div>
    
     <div class="right">
        <p><span><i class="bi bi-envelope-fill"></i>:</span><label for=""><?php echo $c['b_email']?></label></p>
        <p><span><i class="bi bi-geo-alt-fill"></i>:</span><label for=""><?php echo $c['b_location']?></label></p>
     </div>
    </div>
  <div class="c-info">
    <p><span>customer:</span><label for=""><?php echo $b['name']?></label></p>
    <p><span>Phone:</span><label for=""><?php echo $b['phone']?></label></p>
   </div>
    <table>
    <tr><th>N <sup><u>o</u></sup></th><th>Item Name</th><th>Quantity</th><th>Unity Price</th><th>DSC</th><th>Total Price</th></tr>
    <?php
    $no=0;
    $item_select=mysqli_query($conn,"SELECT * from salles,item where salles.item=item.id and salles.s_id='$sell'");
    while ($a=mysqli_fetch_array($item_select)) {
        $no++;
        echo"<tr><td>".$no."</td><td>".$a['item_name']."</td>";
        echo"<td>".$a['salles_quantity']."</td>";
        echo"<td>".$a['out_price']-intval($a['s_dsc'])."</td>";
        echo"<td>".intval($a['s_dsc'])."</td>";
        echo"<td>".($a['out_price']-intval($a['s_dsc']))*$a['salles_quantity']."</td>";
    }
    
    ?>
    
   </table>
   <div class="bottom">
    <div class="stamp">
        <img src="icon/sginature.svg" alt="">
        <p><?php echo $c['b_name']?></p>
    </div>
     <div class="qr"><img src="icon/qrcode.jpg" alt=""></div>
      <div class="total">
        <p><span>Total Amount:</span><label for=""><?php echo $b['amount']?></label></p>
        <p><span>Total DSC:</span><label for=""><?php echo $b['dsc']?></label></p>
        <p><span>Date:</span><label for=""><?php echo $b['sel_date']?></label></p>
        <p><span>Item Number:</span><label for=""><?php echo $no ?></label></p>
    </div>
  
  </div>
</div>

 </div>
 </div> 
</div>
<script>
    var button=document.getElementById("download");  
    var bt=document.getElementById("download-a4");
  
    button.addEventListener("click",function () {  
        var text=document.getElementById("card");
        var customer="<?php echo $customer ?>";
        var opt={
            margin:0.2,
            with:100,
            filename:customer,
            image: {type:'jpg',quality: 1},
            html2canvas:{scale: 2},
            jsPDF:{unit: 'in', format: 'A5', orientation: 'portrait'}
        };
        html2pdf(text,opt);
    });

    bt.addEventListener("click",function () {  
        var text=document.getElementById("card");
        var customer="<?php echo $customer ?>";
        var opt={
            margin:0.2,
            with:100,
            filename:customer,
            image: {type:'jpg',quality: 1},
            html2canvas:{scale: 2},
            jsPDF:{unit: 'in', format: 'A4', orientation: 'portrait'}
        };
        html2pdf(text,opt);
    });
  
   
</script>

</body>
</html>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: sans-serif;
        font-size: 14px;
    }
    .cont{
        width: 100%;
        height: 100vh;
        overflow-y: scroll;

    }
    .c-info{
        width: 100%;
        height: 70px;
        text-align: left;
        padding-left: 5%;
        padding-top: 2%;
        border-bottom: dotted rgb(69, 68, 68) 2px;
      
    }
 .center{
    width: 50%;
    margin: auto;
    height: 90vh;
    overflow-y: scroll;
    padding-top: 2%;
 }
    .card{
width: 100%;
height: fit-content;
background-color: white;
margin: auto;
padding: 1%;
border: solid black 1px;

    }
   
    img{
        width: 80%;
        height: 70%;
        
        
    }
    th{
        border-right: solid black 2px;
        background-color: rgb(13, 13, 13);
        color: white;
        
    }
    td{
        border-right: dashed black 2px;
        padding: 0.5%;
        text-align: left;
    }
    table{
        width: 100%;
        margin-top: 1%;
        font-size: 14px;
    }
   
    
    .body{
        
        width: 100%;
        background-color: rgb(237, 237, 246);
        height: 90vh;
    }
   
    h1{
        font-size: 14px;
    }
    label{
        margin-left: 1%;
    }
    span img{
        width: 20px;
        height: 20px;
    }
    .b-info{
        width: 100%;
        height: fit-content;
        padding: 1%;
        display: flex;
        border-bottom: dotted black 2px;
    }
    .b-info p{
        font-size: 14px;
        padding-top: 2%;
    }
    .stamp{
        width: 30%;
        height: 100px;
       padding-top: 1%;
        position: relative;

        
    }
    button i{
        font-size: 20px;
        margin-right: 2%;
    }
    .stamp img{
        width: 100%;
        height: 80%;
        color: white;
       
        position: absolute;
    }
    .stamp p{
        width: 80%;
        height: fit-content;
       
        text-align: center;
        position: absolute;
        margin-top: 15%;
        
    }
    .bottom{
        width: 100%;
        margin-top: 2%;
        height: 100px;
        display: flex;
        padding: 1%;
    }
    .qr{
        width: 20%;
        height: 100%;
        
    }
    .total{
        width: 50%;
        height: 100%;
        padding: 1%;
        text-align: left;
    }
    .qr img{
        width: 95%;
        height: 90%;
        margin: auto;
    }
    .total p{
        font-weight: bold;
    }
  
    .top{
        background-color: rgb(2, 2, 16);
        height: 10vh;
        padding: 0.5%;
        display: flex;
        width: 100%;
    }
    .cent{
        width: 50%;
        padding: 1%;
        overflow-y: scroll;
        height: 90vh;
    }
    
    .top button{
        
        margin-left: 2%;
        height: 100%;
        width: 10%;
        display: flex;
        font-weight: bold;
        font-size: 15px;
        padding: 1%;
        color: green;
        cursor: pointer;
    }
    .b-info .left{
        background-color: transparent;
        width: 40%;
    }
    .b-info .right{
        background-color: transparent;
        width: 40%;
        word-wrap: break-word;
    }
    .logo{
        background-color: transparent;
        width: 20%;
        height: 100%;
        text-align: center;
    }
    button img{
        height: 100%;
        width: 30%;
    }
    @media(max-width:700px){
        .center{
            width: 100%;
            padding: 2%;
        }
        .card{
            width: 100%;
        }
        .top button{
            height: 90%;
            width: 20%;
        }
        .top{
            height: 40px;
            padding: 1%;
        }
    } 


</style>