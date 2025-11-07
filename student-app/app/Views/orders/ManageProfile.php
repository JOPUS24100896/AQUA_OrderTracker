
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profile</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/manageProfile.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css">
    <script>
        const base = "<?= base_url()?>";
    </script>
</head>
<body>
    <?php
    if(isset($_SESSION["user_id"])){
        switch($_SESSION["user_type"]){
            case "STAFF":
                echo $this->include("orders/staffUI/staffHeader");
            break;
            case "CUST":
                echo $this->include("orders/customerUI/custHeader");
            break;
            case "ADMIN":
                echo $this->include("orders/adminUI/adminHeader");
            break;
        }
    }
    ?>
    
            <div class="container">
                <form method='post' id="profileForm" action="<?= base_url("orders/editUser")?>">
                    <h2>Edit Profile</h2>
                    <div class="flex_center">
                        

                        <div class="input_boxes">
                            <label for="partnerName">Full Name <span style="color: red;">*</span></label>
                            <input type="text" id="name" name="partnerName" value="<?=$data['FullName']?>" required disabled>

                            <label for="Address">Address <span style="color: red;">*</span></label>
                            <input type="text" id="addr" name="Address" value="<?=$data['Address']?>" required disabled>

                            <label for="contactNumber">Contact Number <span style="color: red;">*</span></label>
                            <input type="text" id="cont" name="contactNumber" value="<?=$data['Contact']?>" required disabled>    
                        </div>
                        

                        <div class="input_boxes">
                            <label for="Username">Username <span style="color: red;">*</span></label>
                            <input type="text" id="username" name="Username" value="<?=$data['Username']?>" required disabled>

                            <label for="partnerEmail">Email <span style="color: red;">*</span></label>
                            <input type="email" id="email" name="partnerEmail" value="<?=$data['Email']?>" required disabled>
                        </div>
                    </div>
                    
                    
                    <button type="submit">Update Profile</button>
                    <button id="edit">Edit</button>
                </form>
                <div id="verifyDiv" hidden>
                    <form id="verifyForm">
                        <h2>User Verification</h2>
                        <div class="flex_center">
                            <div class="input_boxes">
                                <label for="verifyPass">Enter Current Password <span style="color: red;">*</span></label><br>
                                <input type="password" id="verifPass" name="password" required>    
                                <span style="color: red;" id="errFeedback"></span>
                            </div>   
                        </div> 
                        <button type="submit">Update</button>
                    </form>   
                    <button id="backForm">Back</button>
                </div>
            </div>
        </div>
    </div>
            <?= $this->include("orders/footer")?>


    <script src="/js/dropdown.js"></script>
    <script src="/js/manageProfile_form.js"></script>
</body>
</html>