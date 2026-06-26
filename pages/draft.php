<?php

include("configur.php");
if ($business=="" or $admin=="") {
header("location:index.html");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exchange</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="icons/bootstrap-icons.css">
</head>
<body>
    <form action="" method="POST">
    <div class="cont">
        <div class="top">
           <i class="bi bi-people"></i>
                <?php
                #select customer...................

                if (isset($_GET['id'])) {
                    $customer=$_GET['id'];
                    $select_customer=mysqli_query($conn,"SELECT* FROM customer where c_id='$customer' and business='$business'");
                    $fetch=mysqli_fetch_array($select_customer);
                    $select_debit=mysqli_query($conn,"SELECT * from sell where sl_customer='$customer'");
                    $dbt=0;
                            while($db=mysqli_fetch_array($select_debit)){
                                $dbt+=$db['debit'];
                            } 
                            
                            $item_numbers=mysqli_query($conn,"SELECT * FROM selected where customer='$customer'");
                            $item_number=mysqli_num_rows($item_numbers);

                }

               
             
                ?>
                <div class="left-top">
                    <div class="left-top-left">
                      
                        <?php
#display customer........................................................

                         if (isset($_GET['id'])) {
                            echo" ". $fetch['name'];
                            $_SESSION['customer']=$_GET['id'];
                             }
                             else{
                                echo"-------";
                             }

#choose item button.............................................................

                             if (isset($_POST['item'])) {
                                if (!isset($_GET['id'])) {
                                    echo"<script>alert('please select customer'),location='draft.php'</script>";
                                }
                                else{
                               header("location:item_list.php");
                               $_SESSION['s_customer']=$customer;
                                }
                             }
                             ?></div>

                             <div class="left-top-right"><button name="customer" class="btn">customer</button></div>
                            </div>
               
            <div class="right-top">
            <div class="right-top-left"><label for="">Item:</label><?php if (isset($_GET['id'])) {
            echo" ". $item_number ;   
            }
            else{
            echo 0;
            } ?></div>
            <div class="right-top-right"><button name="item" class="btn">Add Item</button>
                 <button name='save' class="btn btn-primary">Save</button></div>
        </div>
        </div>

        <div class="tables">
          <?php 

          if (isset($_GET['id'])){
          ?>
 <table class="table-bordered">
   
    <tr><th>Number</th><th>Item Name</th><th>Quantity </th><th> Unity price</th><th> Unity Dsc</th><th>Total price</th><th class="option">Option</th></tr>
    <?php
   $customer=$_GET['id'];
    #selct item list..........................

    $item_list=mysqli_query($conn,"SELECT * FROM item,selected where item.id=selected.s_item and item.business='$business' and selected.business='$business' and selected.customer='$customer'");
    $no=0;
    $st=1;
    $total=0;
    $dcount=0;
    date_default_timezone_set("africa/kigali");
    $salles_date=date('y/m/d h:i:s');
    $pm=date('A');
    $salles=mysqli_query($conn,"SELECT MAX(s_id) as sales FROM salles");
    $max=mysqli_fetch_array($salles);
   $sell=$max['sales']+1;
   $state=0;
   $date=date('y/m/d h:i:s');

    while ($row=mysqli_fetch_array($item_list)) {
        $no++;
        echo"<tr><td>".$no."</td>";
        echo"<td>".$row['item_name']."</td>";
        echo"<td>".$row['s_quantity']."</td>";
        echo"<td>".$row['out_price']."</td>";
        echo"<td>".$row['sdc']."</td>";
        echo"<td class='total'>".$row['s_quantity']*($row['out_price']-intval($row['sdc']))."</td>";
        $price=$row['s_quantity']*($row['out_price']-intval($row['sdc']));
        $total+=$price;
        $dc=intval($row['sdc']);
        $dcount+=intval($row['sdc'])*$row['s_quantity'];
        $item=$row['S_item'];
        $quantity=$row['s_quantity'];

        if (isset($_POST['save'])) {
            if (isset($_SESSION['sel'])) {
                $salles_delete=mysqli_query($conn,"DELETE FROM salles where s_id='$sel' and business='$business'");
                if ($salles_delete==true){
                    $ins=mysqli_query($conn,"INSERT INTO salles(s_id,admin,business,customer,item,salles_quantity,startus,s_dsc,salles_date,pm) 
        values('$sell','$admin','$business','$customer','$item','$quantity','$st','$dc','$salles_date','$pm')");
     
       
                }

                
             }
             else{
        $ins=mysqli_query($conn,"INSERT INTO salles(s_id,admin,business,customer,item,salles_quantity,startus,s_dsc,salles_date,pm) 
        values('$sell','$admin','$business','$customer','$item','$quantity','$st','$dc','$salles_date','$pm')");
             }
       }
        ?>
          
          <td style="display:flex;">

            <button name="update" class="btn btn-primary" value="<?php echo $row['sid']?>"><i class="bi bi-pencil"></i></button>
                    <button name="delete" class="btn btn-danger" value="<?php echo $row['sid']?>"><i class="bi bi-x"></i></button>   
        </td> 
       <?php 
         }
    
    if (isset($_POST['delete'])) {
        $it=$_POST['delete'];
        $selct_itmes=mysqli_query($conn,"SELECT * FROM selected,item where selected.sid='$it' and selected.business='$business' and item.business='$business' and selected.S_item=item.id");
    $as=mysqli_fetch_array($selct_itmes);
    $itm=$as['S_item'];
    $ne_stock=$as['quantity']+$as['s_quantity'];
    $updates=mysqli_query($conn,"UPDATE item set quantity='$ne_stock' where id='$itm' and business='$business'");
   
    if ($updates==true) {
    mysqli_query($conn,"DELETE FROM selected where sid='$it' and business='$business'");
      echo"<script>location='draft.php?id={$customer}'</script>";
    }
   
        
    }
    if (isset($_POST['update'])) {
        $it=$_POST['update'];
        $_SESSION['item']=$it;
        $_SESSION['customer']=$customer;
       echo"<script>location='selected_edit.php'</script>";
        
    }
    if (isset($_POST['save'])) {
       if ($ins==TRUE) {
        if (isset($_SESSION['sel'])) {
             $debit=$total-$_POST['paired'];
            $sell_delete=mysqli_query($conn,"DELETE FROM sell where sel_id='$sel'"); 
            if ($sell_delete==true) {
          mysqli_query($conn,"INSERT INTO sell(sel_id,admin,business,sl_customer,amount,sel_date,state,debit,dsc) 
          values('$sell','$admin','$business','$customer','$total','$date','$state','$debit',$dcount)");
            $clean=mysqli_query($conn,"DELETE from selected where business='$business'");
            echo "<script>location='home.php'</script>";
        } 
        }
        else {
            $debit=$total-$_POST['paired'];
            mysqli_query($conn,"INSERT INTO sell(sel_id,business,admin,sl_customer,amount,sel_date,state,debit,dsc) 
            values('$sell','$business','$admin','$customer','$total','$date','$state','$debit','$dcount')");
            $clean=mysqli_query($conn,"DELETE FROM selected where business='$business'");
            echo "<script>location='first.php'</script>";    
        }
       
       
           
       
    }
    ?>
  
<?php } ?>
  <tr class="bottom">
            <th colspan="">Toal</th>
            <td id='total' colspan="6"><?php echo $total?></td>
    </tr>
    <tr class="bottom"><th colspan="">paired</th>
            <td class="paired" id="paired" colspan="6">
                <input type="number" name="paired" id="paird" class="form-control" value="<?php echo $total?>">
            </td></tr>
</table>
<?php }?>
        </div>

    </div>
    </form>
</body>
</html>
<script>
    document.querySelectorAll(".total").forEach
    (cell => {
      const num= Number(cell.textContent);
      cell.textContent=num.toLocaleString();
    }); 
var total=document.getElementById("total");
var tnum= Number(total.textContent);
total.textContent=tnum.toLocaleString();


</script>
<?php
if (isset($_POST['customer'])) {
 
   echo"<script>location='customer_list.php'</script>";
   
}

?>


<style>
    *{
        margin: 0;
        padding: 0;
        font-family: sans-serif;
        box-sizing: border-box;
    }
   .top{
    width: 100%;
    height: 50px;
    background-color: rgb(42, 26, 218);
    color: white;
    display: flex;
   }
   .left-top{
    width: 50%;
    height: 100%;
    background-color:transparent;
    display: flex;
   }
    .right-top{
    width: 50%;
    height: 100%;
    background-color: transparent;
    display: flex;
   }
   .left-top-left{
 width: 70%;
 background-color:transparent;
 height: 100%;
 font-size: 20px;
 padding: 1%;
   }
    .right-top-left{
 width: 60%;
 background-color: transparent;
 height: 100%;
 font-size: 20px;
 padding: 0%;
   }
   
   .btn-primary{
    margin-left: 5%;
   }
    .left-top-right{
 width: 30%;
 background-color: transparent;
 height: 100%;
 font-size: 20px;
 padding: 1%;
   }
     .right-top-right{
 width: 40%;
 background-color: transparent;
 height: 100%;
 display: flex;
 font-size: 20px;
 padding: 1%;
   }
   
   th{
    font-weight: bold;
    font-size: 20px;
    padding-left: 2%;
   }
   td{
    padding-left: 2%;
    padding-right: 2%;
    border-left:1px solid rgb(162, 158, 158);
    
   }
   .bottom td{
    background-color:#fff;
     border-bottom: 1px solid rgb(67, 102, 238);
     border-top: 1px solid rgb(67, 102, 238);
   }
   .tables{
    width: 100%;
    margin-top: 1%;
   }
   table{
    width: 100%;
   }
   @media(max-width:700px){
    .top{
        padding: 1%;
        height: 60px;
    }
    .form-control{
        font-size: 12px;
        width: 100%;
    }
    .left-top{
       display: flex;
       flex-direction: column;
        
    }
    .btn-primary{
        margin-left: 30%;
    }
    .left-top-left{
        font-size: 14px;
        height: 30%;
        width: 100%;
        
       
    }
    .tables{
        margin-top: 0%;
        width: 100%;
    }
    .right-top-left{
        font-size: 12px;
        height: 30%;
        width: 100%;
        
    }
    .right-top-right{
        width: 100%;
        
    }
    .right-top{
        display: flex;
        flex-direction: column;
        
    }
    .top .btn{
        font-size: 12px;
        padding: 3%;
        margin-top: 0%;
    }
    table{
        
        font-size: 12px;
        width: 100%;
        
    }
    table .btn{
        font-size: 12px;
        margin: 2%;
        display: block;
    }
    
    table th,td{
        padding: 1%;
        font-size: 12px;
    }

   }
   
    
    
   
</style>