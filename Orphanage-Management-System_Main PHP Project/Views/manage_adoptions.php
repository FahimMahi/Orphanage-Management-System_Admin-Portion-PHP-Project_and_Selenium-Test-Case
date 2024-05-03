<?php
include('navbar.php');
include('../Models/config.php');

include('../Controllers/manage_adoptions_controllers.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Manage Adoptions - Orphanage Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-container {
            margin: 20px;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-container input[type="text"],
        .form-container input[type="date"],
        .form-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .form-container input[type="submit"]:hover {
            background-color: #218838;
        }

        .record-list {
            margin: 20px;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .record-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .record-list th,
        .record-list td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .record-list th {
            background-color: #f4f4f4;
        }

        .edit-button,
        .delete-button {
            background-color: #ffc107;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-button:hover {
            background-color: #e0a800;
        }

        .delete-button {
            background-color: #dc3545;
        }

        .delete-button:hover {
            background-color: #c82333;
        }
        body {
            font-family: Arial, sans-serif;
            background: url('../img/2304.q894.005.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <br/>
        <br/>

        <div class="form-container">
        <h2>Manage Adoptions</h2>
            <h3><?php echo isset($_GET['edit_adoption_id']) ? 'Edit Adoption Record' : 'Add Adoption Record'; ?></h3>
            <form id="adoption-form" action="manage_adoptions.php" method="post" onsubmit="return validateForm();">
                <?php if (isset($_GET['edit_adoption_id'])):
                    $editAdoptionId = $_GET['edit_adoption_id'];
                    $editAdoption = null;
                    foreach ($adoptions as $adoption) {
                        if ($adoption['adoption_id'] == $editAdoptionId) {
                            $editAdoption = $adoption;
                            break;
                        }
                    }
                ?>
                    <input type="hidden" name="adoption_id" value="<?php echo $editAdoption['adoption_id']; ?>">
                <?php endif; ?>
                <label for="child_id">Child:</label>
                <select name="child_id" id="child_id" >
                    <option value="">Select Child</option>
                    <?php foreach ($children as $child): ?>
                        <option value="<?php echo $child['child_id']; ?>" <?php echo isset($editAdoption) && $editAdoption['child_id'] == $child['child_id'] ? 'selected' : ''; ?>>
                            <?php echo $child['first_name'] . ' ' . $child['last_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="adopter_name">Adopter Name:</label>
                <input type="text" id="adopter_name" name="adopter_name" value="<?php echo $editAdoption['adopter_name'] ?? ''; ?>" >

                <label for="adopter_contact">Adopter Contact:</label>
                <input type="text" id="adopter_contact" name="adopter_contact" value="<?php echo $editAdoption['adopter_contact'] ?? ''; ?>" >

                <label for="adopter_nid">Adopter NID:</label>
                <input type="text" id="adopter_nid" name="adopter_nid" value="<?php echo $editAdoption['adopter_nid'] ?? ''; ?>" >

                <label for="adoption_date">Adoption Date:</label>
                <input type="date" id="adoption_date" name="adoption_date" value="<?php echo $editAdoption['adoption_date'] ?? ''; ?>" >

                <input type="submit" name="<?php echo isset($editAdoption) ? 'edit_adoption' : 'add_adoption'; ?>" value="<?php echo isset($editAdoption) ? 'Edit Adoption Record' : 'Add Adoption Record'; ?>">
            </form>
        </div>

        <div class="record-list">
            <h3>Existing Adoption Records</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Child Name</th>
                        <th>Adopter Name</th>
                        <th>Adopter Contact</th>
                        <th>Adopter NID</th>
                        <th>Adoption Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($adoptions as $adoption): ?>
                        <tr>
                            <td><?php echo $adoption['adoption_id']; ?></td>
                            <td><?php echo $adoption['first_name'] . ' ' . $adoption['last_name']; ?></td>
                            <td><?php echo $adoption['adopter_name']; ?></td>
                            <td><?php echo $adoption['adopter_contact']; ?></td>
                            <td><?php echo $adoption['adopter_nid']; ?></td>
                            <td><?php echo $adoption['adoption_date']; ?></td>
                            <td>
                                <form action="manage_adoptions.php" method="get" style="display:inline;">
                                    <input type="hidden" name="edit_adoption_id" value="<?php echo $adoption['adoption_id']; ?>">
                                    <input type="submit" value="Edit" class="edit-button">
                                </form>
                                <form action="manage_adoptions.php" method="post" style="display:inline;">
                                    <input type="hidden" name="adoption_id" value="<?php echo $adoption['adoption_id']; ?>">
                                    <input type="submit" name="delete_adoption" value="Delete" class="delete-button" onclick="return confirm('Are you sure you want to delete this adoption record?');">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if (isset($statusMessage)): ?>
        <script>
            alert('<?php echo $statusMessage; ?>');
        </script>
    <?php endif; ?>

    <script>
        function validateForm() {
            var childId = document.getElementById('child_id').value.trim();
            var adopterName = document.getElementById('adopter_name').value.trim();
            var adopterContact = document.getElementById('adopter_contact').value.trim();
            var adopterNid = document.getElementById('adopter_nid').value.trim();
            var adoptionDate = document.getElementById('adoption_date').value;

            if (childId === '') {
                alert('Child ID is required.');
                return false;
            }

            if (adopterName === '') {
                alert('Adopter Name is required.');
                return false;
            }

            if (adopterContact === '') {
                alert('Adopter Contact is required.');
                return false;
            }

            if (adopterNid === '') {
                alert('Adopter NID is required.');
                return false;
            }

            if (!/^\d{10}$|^\d{17}$/.test(adopterNid)) {
                alert('Adopter NID must be either 10 or 17 digits.');
                return false;
            }

            if (adoptionDate === '') {
                alert('Adoption Date is required.');
                return false;
            }

            return true;
        }
    </script>
    <?php include('footer.php'); ?>
</body>
</html>
