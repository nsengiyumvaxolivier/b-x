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
</head>

<body>
    <div class="container-fluid bg-yellow-900 relative h-[100vh] p-2 w-full">
        <div class="h-[8%] bg-yellow-900 w-[100%] overflow-x-auto  bottom-0 left-0 absolute fixed p-2 md:hidden">
            <div
                class="links flex gap-5 w-[100%] [&_a]:h-[30px] min-w-max  [&_a]:border-2 [&_a]:p-0 [&_a]:rounded [&_a]:rounded-full [&_a]:text-white [&_a]:w-[30px] [&_a]:text-center">
                <a href="dashboard"
                    class="<?= $page=='dashboard' ? 'border-green-500 text-green-500' : 'border-white text-white' ?>"><i
                        class="bi bi-person-workspace"></i></a> 
                        <a href="sales"
                    class="<?= $page=='sales' ? 'border-green-500 text-green-500' : 'border-white text-white' ?>"><i
                        class="bi bi-tags"></i></a> 
                        <a href="purchase"
                    class="<?= $page=='purchase' ? 'border-green-500 text-green-500' : 'border-white text-white' ?>"><i
                        class="bi bi-cart"></i></a>
                <a href="customer"
                    class="<?= $page=='customer' ? 'border-green-500 text-green-500' : 'border-white text-white' ?>"><i
                        class="bi bi-people"></i></a>
                <a href="item"
                    class="<?= $page=='item' ? 'border-green-500 text-green-500' : 'border-white text-white' ?>"><i
                        class="bi bi-box-seam"></i></a>
               
                <a href="supplier"
                    class="<?= $page=='supplier' ? 'border-green-500 text-green-500' : 'border-white text-white' ?>"><i
                        class="bi bi-truck"></i></a>
                       
               


            </div>
        </div>

        <div class="container flex w-full h-[92%] md:h-[100%] p-0">

            <div class="left hidden md:block bg-yellow-900 h-[100%] w-[15%] border border-2 p-2 ">
                <h1 class="text-white font-bold p-1">
                    <?php echo $_SESSION['business'] ?>
                </h1>
                <hr class="text-white">
                <div class="links flex-column h-[95%]">
                    <li class="list-none">
                        <ol> <a href="dashboard">Dashboard</a></ol>
                        <ol> <a href="sales">Sales</a></ol>
                        <ol> <a href="purchase">Purchase</a></ol>
                        <ol><a href="customer">Customer</a></ol>
                        <ol> <a href="item">Product</a></ol>
                        <ol> <a href="supplier">Suppliers</a></ol>
                        <ol> <a href="report">Report</a></ol>
                    </li>
                    
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