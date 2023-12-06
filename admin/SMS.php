<?php 
    require("../connection/connection.php");
    require("source.php");

?>

<?php
    $_SESSION['msgResponse']="";
    require '../vendor/autoload.php';

    use Infobip\Api\SmsApi;
    use Infobip\Configuration;
    use Infobip\Model\SmsAdvancedTextualRequest;
    use Infobip\Model\SmsDestination;
    use Infobip\Model\SmsTextualMessage;

    if(isset($_POST['smsSend'])){
        $smsNumber = $_POST['smsNumber'];
        $smsMessage = $_POST['smsMessage'];

        $BASE_URL = "https://6gye4r.api.infobip.com";
        $API_KEY = "d68deb7ddbc8015c872b069edb72a08c-f4bccfc4-d650-4504-9716-7fd6e0ffc84b";

        $configuration = new Configuration(host: $BASE_URL, apiKey: $API_KEY);

        $sendSmsApi = new SmsApi(config: $configuration);
        $destination = new SmsDestination(to: $smsNumber);

        $message = new SmsTextualMessage(destinations: [$destination], from: "The Summerhouse Cafe", text: $smsMessage);

        $request = new SmsAdvancedTextualRequest(messages: [$message]);

        $smsResponse = $sendSmsApi->sendSmsMessage($request);
        
        $_SESSION['msgResponse'] ="Message has been sent successfully";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Summerhouse Cafe</title>
    <link rel="stylesheet" href="mystyle.css">
    <link rel="stylesheet" href="../api/datatable.css">
    <script src="../api/datatable.js"></script>
    <style>
        #container{
            display: grid;
            grid-template-columns: auto auto;
            column-gap: 20px;
        }
        .flow{
            overflow-y: scroll;
            max-height: 800px;
        }
    </style>
</head>
<body>
    <header class="p-2 header-style">
            <div class="container-fluid">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="admin.php" class="nav-link px-2 text-white"><img src="../images/logo.png" alt="logo" style="height: 90px;width: 90px;border-radius: 50%;object-fit: contain"></a>
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li class="nav-bar mt-2"><a href="admin.php" class="nav-link px-2 text-white">Home</a></li>
                    <li class="nav-bar mt-2"><a href="orders.php" class="nav-link px-2 text-white">Orders</a></li>
                    <li class="nav-bar mt-2"><a href="reports.php" class="nav-link px-2 text-white">Reports</a></li>
                    <li class="nav-bar mt-2"><a href="products.php" class="nav-link px-2 text-white">Products</a></li>
                    <li class="nav-bar mt-2"><a href="categories.php" class="nav-link px-2 text-white">Categories</a></li>
                    <li class="nav-bar mt-2"><a href="accounts.php" class="nav-link px-2 text-white">Accounts</a></li>
                    <li class="nav-bar mt-2"><a href="SMS.php" class="nav-link px-2" id="active">Send SMS</a></li>
                    </ul>
                    <div class="text-end">
                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                    <span class="text-white">Welcome, <?php echo $_SESSION['displayName']."! "."(".$_SESSION['roleType']." - ".$_SESSION['roleDes'].")" ?></span>
                    <a class="btn-log" href="../logout.php">Logout</a>
                    </div>
                    </form>
                </div>
            </div>
    </header>
    <div class="container-fluid mt-5" id="container">
        <div class="flow shadow p-3 mb-5 bg-body rounded">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Name of the customer</th>
                        <th>Mobile number</th>
                    </tr>
                </thead>
                <tbody>
                        <?php
                            foreach ($orderData as $rowOrder){
                        ?>
                    <tr class="">
                        <td width="50%"><?php echo $rowOrder['customer_name']; ?></td>
                        <td width="50%"><?php echo $rowOrder['mobile_num']; ?></td>
                    </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
        <div>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                <div class="shadow p-3 mb-5 bg-body rounded">
                <h4 class="text-center sunborn">★Send SMS to Customer</h4>
                <div>
                <div class="input-group mt-3 w-auto">
                    <span class="input-group-text">Recipient</span>
                    <input type="text" placeholder="+639*********" minlength="13" maxlength="13" class="form-control" name="smsNumber" required>
                </div>
                <textarea name="smsMessage" id="smsMessage" rows="10" class="mt-3 w-100 text-wrap" placeholder="Type a message..."></textarea>
                <div class="d-grid gap-2 mt-4">
                    <button class="btn btn-primary" type="submit" name="smsSend">Send Message</button>
                </div>
                </div>
            </form>
        </div>
    </div>
    <h1 class='text-center text-white bg-success'><?php echo $_SESSION['msgResponse']; ?></h1>
        
        <script>
            new DataTable('#example');
        </script>
</body>
</html>