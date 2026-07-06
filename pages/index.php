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

<body>
    <div class="container-fluid bg-yellow-900 relative h-[100vh] p-2 w-full">
        <div class="h-[8%] bg-yellow-900 w-[100%] overflow-x-auto  bottom-0 left-0 absolute fixed px-1 md:hidden">
            <div
                class="links flex gap-2 w-[100%] min-w-max [&_a]:border-b-2 [&_a]:w-[30px] [&_a]:h-[30px] [&_a]:p-1">
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" ><a href="dashboard"
                    class="<?= $page=='dashboard' ? 'border-green-500 text-green-500' : 'border-white text-white' ?>    "><i
                        class="bi bi-person-workspace"></i></a></div>
                    <div for="" class="text-[12px] p-2 text-white">Dashboard</div>
                </div>
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" > <a href="sales"
                    class="<?= $page=='sales' ? 'border-green-500 text-green-500' : 'border-white text-white' ?>"><i
                        class="bi bi-tags"></i></a></div>
                    <div for="" class="text-[12px] p-2 text-white">Sales</div>
                </div>
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" >  <a href="purchase"
                    class="<?= $page=='purchase' ? 'border-green-500 text-green-500' : 'border-white text-white' ?>"><i
                        class="bi bi-cart"></i></a></div>
                    <div for="" class="text-[12px] p-2 text-white">Purchases</div>
                </div>
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" > <a href="item"
                    class="<?= $page=='item' ? 'border-green-500 text-green-500' : 'border-white text-white' ?>"><i
                        class="bi bi-box-seam"></i></a></div>
                    <div for="" class="text-[12px] p-2 text-white">Items</div>
                </div>
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" >  <a href="customer"
                    class="<?= $page=='customer' ? 'border-green-500 text-green-500' : 'border-white text-white' ?>"><i
                        class="bi bi-people"></i></a></div>
                    <div for="" class="text-[12px] p-2 text-white">Customer</div>
                </div>
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" >  <a href="supplier"
                    class="<?= $page=='supplier' ? 'border-green-500 text-green-500' : 'border-white text-white' ?>"><i
                        class="bi bi-truck"></i></a></div>
                    <div for="" class="text-[12px] p-2 text-white">Supplier</div>
                </div>
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" >  <a href="request_orders"
                    class="<?= $page=='request_orders' ? 'border-green-500 text-green-500' : 'border-white text-white' ?>"><i
                        class="bi bi-card-checklist"></i></a></div>
                    <div for="" class="text-[12px] p-2 text-white">Request</div>
                </div>
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" >   <a href="report"
                    class="<?= $page=='report' ? 'border-green-500 text-green-500' : 'border-white text-white' ?>"><i
                        class="bi bi-list"></i></a></div>
                    <div for="" class="text-[12px] p-2 text-white">Reports</div>
                </div>
                <div class="link flex-column text-center item-center w-[20%] h-[100%]">
                    <div class="w-full" > <a href="sales"
                    class="<?= $page=='sales' ? 'border-green-500 text-green-500' : 'border-white text-white' ?>"><i
                        class="bi bi-tags"></i></a></div>
                    <div for="" class="text-[12px] p-2 text-white">Logout</div>
                </div>
                
                        
                       
               
                
               
               
                       
                      
                       
               


            </div>
        </div>

        <div class="container flex w-full h-[92%] md:h-[100%] p-0">

            <div class="left hidden md:block bg-yellow-900 h-[100%] w-[15%] border border-2 p-2 ">
                <h1 class="text-white font-bold p-1">
                    <?php echo $_SESSION['business'] ?>
                </h1>
                <hr class="text-white">
                <div class="links flex-column h-[95%]">
                      
                       <p><a href="dashboard">Dashboard</a></p>
                        <p><a href="sales">Sales</a></p>
                        <p><a href="purchase">Purchase</a></p>
                        <p><a href="customer">Customer</a></p>
                        <p><a href="item">Product</a></p>
                        <p><a href="request_orders">Requests</a></p>
                        <p><a href="supplier">Suppliers</a></p>
                        <p><a href="report">Report</a></p>
                    
                    
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
</body>

</html>