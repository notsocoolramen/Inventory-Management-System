<?php
// Include your database connection file
require_once 'db_connect.php';

// Check if the 'id' parameter is set in the GET request
if(isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $statusID = mysqli_real_escape_string($conn, $_GET['id']);

    // Query to fetch category data based on the ID
    $query = "SELECT * FROM status WHERE statusID = $statusID";

    // Perform the query
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if($result) {
        // Check if any category record was found
        if(mysqli_num_rows($result) > 0) {
            // Fetch the category data as an associative array
            $statusID = mysqli_fetch_assoc($result);

            // Display the fetched category data in HTML format
            echo '<form id="editCategoryForm" action="includes/update_status.php" method="post">';
            echo '<input  type="hidden" name="status_id" value="' . $statusID['statusID'] . '">'; // Include the category ID in a hidden input field
            echo 'Category Name: <input type="text" class="form-control" name="status_name" value="' . $statusID['status'] . '"><br>';
            echo '<button type="submit" class="btn btn-primary">Save Changes</button>';
            echo '</form>';
        } else {
            echo 'No category found with the provided ID.';
        }
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }

    // Free the result set
    mysqli_free_result($result);

    // Close the database connection
    mysqli_close($conn);
} else {
    echo 'Error: ID parameter is missing.';
}
?>
