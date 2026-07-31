<?php
session_start();
if (! isset($_SESSION['user'])) {
    header("location:../");
} 
$page = $_GET['url'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B-X Home</title>
    <script src="../plugins/css/tailwindcss.js"></script>
    <link rel="stylesheet" href="../plugins/icons/bootstrap-icons.css">
    <script src="../plugins/js/jquery-3.7.1.min.js"></script>
    <script src="../plugins/js/qrcode.min.js"></script>
    <script src="../plugins/js/html2pdf.bundle.min.js"></script>
    

</head>

<body class="p-0">
    <form action="" method="post" enctype="multipart/form-data">
    <div class="container-fluid bg-yellow-900 relative h-[100vh] p-1 w-full">
        
        <div class="h-[8%] bg-yellow-900 w-[100%] overflow-x-auto  bottom-0 left-0 absolute fixed px-1 md:hidden">
            <div
                class="links flex gap-3 w-[100%] min-w-max [&_a]:border-b-2 [&_a]:w-[30px] [&_a]:h-[30px] [&_a]:p-1">
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" ><a href="dashboard"
                    class="<?= $page=='dashboard' ? 'border-yellow-500 text-yellow-500' : 'border-white text-white' ?> hover:bg-yellow-500/30    "><i
                        class="bi bi-person-workspace"></i></a></div>
                    <div for="" class="text-[12px] p-1 px-2 text-white">Dashboard</div>
                </div>
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" > <a href="sales"
                    class="<?= $page=='sales' ? 'border-yellow-500 text-yellow-500' : 'border-white text-white' ?> hover:bg-yellow-500/30"><i
                        class="bi bi-tags"></i></a></div>
                    <div for="" class="text-[12px] p-1 px-2 text-white">Sales</div>
                </div>
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" >  <a href="purchase"
                    class="<?= $page=='purchase' ? 'border-yellow-500 text-yellow-500' : 'border-white text-white' ?> hover:bg-yellow-500/30"><i
                        class="bi bi-cart"></i></a></div>
                    <div for="" class="text-[12px] p-1 px-2 text-white">Purchases</div>
                </div>
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" > <a href="item"
                    class="<?= $page=='item' ? 'border-yellow-500 text-yellow-500' : 'border-white text-white' ?> hover:bg-yellow-500/30"><i
                        class="bi bi-box-seam"></i></a></div>
                    <div for="" class="text-[12px] p-1 px-2 text-white">Items</div>
                </div>
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" >  <a href="customer"
                    class="<?= $page=='customer' ? 'border-yellow-500 text-yellow-500' : 'border-white text-white' ?> hover:bg-yellow-500/30"><i
                        class="bi bi-people"></i></a></div>
                    <div for="" class="text-[12px] p-1 px-2 text-white">Customer</div>
                </div>
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" >  <a href="supplier"
                    class="<?= $page=='supplier' ? 'border-yellow-500 text-yellow-500' : 'border-white text-white' ?> hover:bg-yellow-500/30"><i
                        class="bi bi-truck"></i></a></div>
                    <div for="" class="text-[12px] p-1 px-2 text-white">Supplier</div>
                </div>
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" >  <a href="request_orders"
                    class="<?= $page=='request_orders' ? 'border-yellow-500 text-yellow-500' : 'border-white text-white' ?> hover:bg-yellow-500/30"><i
                        class="bi bi-card-checklist"></i></a></div>
                    <div for="" class="text-[12px] p-1 px-2 text-white">Request</div>
                </div>
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" >   <a href="report"
                    class="<?= $page=='report' ? 'border-yellow-500 text-yellow-500' : 'border-white text-white' ?> hover:bg-yellow-500/30"><i
                        class="bi bi-list"></i></a></div>
                    <div for="" class="text-[12px] p-1 px-2 text-white">Reports</div>
                </div>
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" >   <a href="notes"
                    class="<?= $page=='notes' ? 'border-yellow-500 text-yellow-500' : 'border-white text-white' ?> hover:bg-yellow-500/30"><i
                        class="bi bi-sticky-fill"></i></a></div>
                    <div for="" class="text-[12px] p-1 px-2 text-white">Notes</div>
                </div>
                 <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" >   <a href="setting"
                    class="<?= $page=='setting' ? 'border-yellow-500 text-yellow-500' : 'border-white text-white' ?> hover:bg-yellow-500/30"><i
                        class="bi bi-gear-fill"></i></a></div>
                    <div for="" class="text-[12px] p-1 px-2 text-white">Settings</div>
                </div>
                
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" > <button type="button" onclick="logouts()" name="logout" class="text-bold text-sm p-1 text-red-500 font-bold"><i class="bi bi-box-arrow-left"></i></button></div>
                    
                    <div for="" class="text-[12px] p-1 px-2 text-white">Logout</div>
                </div>
                
                        
                       
               
                
               
               
                       
                      
                       
               


            </div>
        </div>

        <div class=" flex w-full h-[92%] md:h-[100%] p-0 m-auto">

            <div class="left hidden md:block bg-yellow-900 h-[100%] w-[15%] border border-2 p-2">
                <h1 class="text-white font-bold p-1">
                    <?php echo $_SESSION['business'] ?>
                </h1>
                 <div class="links overflow-y-auto flex-column h-[90%] [&_p]:w-full [&_p]:bg-yellow-500/20 [&_p]:p-2 [&_p]:rounded [&_p]:my-1 [&_a]:w-full [&_a]:text-white [&_a]:font-bold [&_a]:text-sm">
                     <button type="button" onclick="goback()" class="bg-yellow-500 text-white p-2 rounded w-full"> <i class="bi bi-arrow-left"></i> Back</button>
                <hr class="text-white my-2">
               
                      
                       <p class="<?= $page=='dashboard' ? 'border-yellow-500 text-green-500 border border-2' : 'border-white text-white' ?>"> <a href="dashboard" class=""><i class="bi bi-person-workspace"></i> Dashboard</a></p>
                        
                        <p class="<?= $page=='sales' ? 'border-yellow-500 text-green-500 border border-2' : 'border-white text-white' ?>"><a href="sales"><i class="bi bi-tags-fill"></i> Sales</a></p>
                        <p class="<?= $page=='purchase' ? 'border-yellow-500 text-green-500 border border-2' : 'border-white text-white' ?>"><a href="purchase"><i class="bi bi-cart-fill"></i> Purchase</a></p>
                        <p class="<?= $page=='customer' ? 'border-yellow-500 text-green-500 border border-2' : 'border-white text-white' ?>"><a href="customer"><i class="bi bi-people-fill"></i> Customer</a></p>
                        <p class="<?= $page=='item' ? 'border-yellow-500 text-green-500 border border-2' : 'border-white text-white' ?>"><a href="item"><i class="bi bi-box-fill"></i> Item</a></p>
                        <p class="<?= $page=='request_orders' ? 'border-yellow-500 text-green-500 border border-2' : 'border-white text-white' ?>"><a href="request_orders"><i class="bi bi-card-checklist"></i> Requests</a></p>
                        <p class="<?= $page=='supplier' ? 'border-yellow-500 text-green-500 border border-2' : 'border-white text-white' ?>"><a href="supplier"><i class="bi bi-truck"></i> Suppliers</a></p>
                        <p class="<?= $page=='report' ? 'border-yellow-500 text-green-500 border border-2' : 'border-white text-white' ?>"><a href="report"><i class="bi bi-calendar-fill"></i> Report</a></p>
                        <p class="<?= $page=='notes' ? 'border-yellow-500 text-green-500 border border-2' : 'border-white text-white' ?>"><a href="notes"><i class="bi bi-sticky-fill"></i> Notes</a></p>
                        <p class="<?= $page=='stock' ? 'border-yellow-500 text-green-500 border border-2' : 'border-white text-white' ?>"><a href="stock"><i class="bi bi-check2-circle"></i> Stock</a></p>
                        <p class="<?= $page=='setting' ? 'border-yellow-500 text-green-500 border border-2' : 'border-white text-white' ?>"><a href="setting"><i class="bi bi-gear-fill"></i> Settings</a></p>
                         <p class=""><button type="button" onclick="logouts()" name="logout" class="text-bold text-sm p-1 text-red-500 font-bold"><i class="bi bi-box-arrow-left"></i> Logout</button></p>
                        
                    
                    
                </div>

            </div>
            <div class="right w-[100%] md:w-[85%] bg-white p-1 h-[100%] md:h-[100%] overflow-y-auto pb-3">
                <?php
           
            $file = $page.".php";
            if (file_exists($file)) {
                include ($file);
            }
            else {
                echo "not Fount";
            }
            
            
            
            ?>

            </div>


        </div>
       
    </div>
 </form>
</body>

</html>


<script>
    function logouts(){
        window.location='../logout.php';
    }
    function goback() {

    if (window.history.length > 1) {
        window.history.back();
    } else {
        window.location.href = "dashboard";
    }

}
</script>