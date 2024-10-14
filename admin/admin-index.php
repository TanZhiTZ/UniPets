<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="admin-container">
        <header>
            <h1>Admin Dashboard</h1>
            <nav>
                <ul>
                    <li><a href="#pets">Manage Pets</a></li>
                    <li><a href="#users">Manage Users</a></li>
                    <li><a href="#applications">Manage Adoption Applications</a></li>
                    <li><a href="#forum">Manage Forum</a></li>
                    <li><a href="#inventory">Update Inventory</a></li>
                </ul>
            </nav>
        </header>

        <section id="pets">
            <h2>Pet Information</h2>
            <!-- Display, Update Pet Info Form -->
            <form id="petForm">
                <label for="petId">Pet ID:</label>
                <input type="text" id="petId" name="petId">
                <label for="petName">Pet Name:</label>
                <input type="text" id="petName" name="petName">
                <!-- Additional pet details -->
                <button type="button" onclick="updatePetInfo()">Update Pet Info</button>
            </form>
        </section>

        <section id="users">
            <h2>User Information</h2>
            <form id="userForm">
                <label for="userId">User ID:</label>
                <input type="text" id="userId" name="userId">
                <label for="userName">User Name:</label>
                <input type="text" id="userName" name="userName">
                <!-- Additional user details -->
                <button type="button" onclick="updateUserInfo()">Update User Info</button>
            </form>
        </section>

        <section id="applications">
            <h2>Adoption Applications</h2>
            <form id="appForm">
                <label for="appId">Application ID:</label>
                <input type="text" id="appId" name="appId">
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="approved">Approve</option>
                    <option value="disapproved">Disapprove</option>
                </select>
                <button type="button" onclick="manageApplication()">Update Application Status</button>
            </form>
        </section>

        <section id="forum">
            <h2>Forum Management</h2>
            <form id="forumForm">
                <label for="postId">Post ID:</label>
                <input type="text" id="postId" name="postId">
                <button type="button" onclick="deletePost()">Delete Post</button>
            </form>

            <form id="commentForm">
                <label for="commentId">Comment ID:</label>
                <input type="text" id="commentId" name="commentId">
                <button type="button" onclick="deleteComment()">Delete Comment</button>
            </form>
        </section>

        <section id="inventory">
            <h2>Inventory List</h2>
            <form id="inventoryForm">
                <label for="itemId">Item ID:</label>
                <input type="text" id="itemId" name="itemId">
                <label for="itemName">Item Name:</label>
                <input type="text" id="itemName" name="itemName">
                <label for="itemQty">Quantity:</label>
                <input type="number" id="itemQty" name="itemQty">
                <button type="button" onclick="updateInventory()">Update Inventory</button>
            </form>
        </section>
    </div>

    <script src="admin.js"></script>
</body>
</html>
