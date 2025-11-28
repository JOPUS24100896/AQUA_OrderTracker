
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profile</title>
    <link rel="stylesheet" href="/css/main.css">
    <!-- <link rel="stylesheet" href="/css/manageProfile.css"> -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
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
    
            <!-- <div class="container">
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
    </div> -->

    <div class="container" style="padding-top: 150px; padding-bottom: 250px;">
    <div class="card shadow rounded-4 p-4">
        <form method="post" id="profileForm" action="<?= base_url("orders/editUser")?>">
            <h2 class="mb-4 fw-bold text-center">Edit Profile</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="partnerName" value="<?=$data['FullName']?>" class="form-control" required disabled>
                    </div>
                    <div class="mb-3">
                        <label for="addr" class="form-label">Address <span class="text-danger">*</span></label>
                        <input type="text" id="addr" name="Address" value="<?=$data['Address']?>" class="form-control" required disabled>
                    </div>
                    <div class="mb-3">
                        <label for="cont" class="form-label">Contact Number <span class="text-danger">*</span></label>
                        <input type="text" id="cont" name="contactNumber" value="<?=$data['Contact']?>" class="form-control" required disabled>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" id="username" name="Username" value="<?=$data['Username']?>" class="form-control" required disabled>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" id="email" name="partnerEmail" value="<?=$data['Email']?>" class="form-control" required disabled>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="button" id="editBtn" class="btn btn-secondary">Edit</button>
                <button type="button" id="updateBtn" class="btn btn-primary" disabled>Update Profile</button>
            </div>
        </form>

        <!-- Password Verification -->
        <div id="verifyDiv" class="mt-4" hidden>
            <h5 class="mb-3 text-center">Enter your password to save changes</h5>
            <div class="mb-3">
                <input type="password" id="verifPass" class="form-control" placeholder="Current Password">
                <span id="errFeedback" class="text-danger"></span>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <button id="confirmVerify" class="btn btn-primary">Confirm</button>
                <button id="cancelVerify" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
const editBtn = document.getElementById('editBtn');
const updateBtn = document.getElementById('updateBtn');
const profileForm = document.getElementById('profileForm');
const verifyDiv = document.getElementById('verifyDiv');
const verifPass = document.getElementById('verifPass');
const errFeedback = document.getElementById('errFeedback');
const confirmVerify = document.getElementById('confirmVerify');
const cancelVerify = document.getElementById('cancelVerify');

// Enable inputs on Edit click
editBtn.addEventListener('click', () => {
    profileForm.querySelectorAll('input').forEach(input => input.disabled = false);
    editBtn.classList.remove('btn-secondary');
    editBtn.classList.add('btn-success');
    updateBtn.disabled = false; // enable Update Profile button
});

// Click Update Profile: show password verification
updateBtn.addEventListener('click', () => {
    verifyDiv.hidden = false;
});

// Cancel verification
cancelVerify.addEventListener('click', () => {
    verifyDiv.hidden = true;
    verifPass.value = '';
    errFeedback.textContent = '';
});

// Confirm password before submit
confirmVerify.addEventListener('click', (e) => {
    e.preventDefault();
    if(verifPass.value.trim() === ''){
        errFeedback.textContent = "Please enter your password before saving!";
        return;
    }
    // Append password to form and submit
    let passInput = document.createElement('input');
    passInput.type = 'hidden';
    passInput.name = 'password';
    passInput.value = verifPass.value;
    profileForm.appendChild(passInput);
    profileForm.submit();
});
</script>


            <?= $this->include("orders/footer")?>


    <script src="/js/dropdown.js"></script>
    <script src="/js/manageProfile_form.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>