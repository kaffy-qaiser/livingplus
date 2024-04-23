<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Agrim Sharma and Khyaif Qaiser" />
    <title>Create Group</title>
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Catamaran&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles/add_review.css">
    <link rel="stylesheet" type="text/css" href="styles/search.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <h2 class="title">Create a New Group</h2>
        <form action="../backend/insert_group.php" method="post">
            <div class="inputs">
                <input type="text" name="groupName" placeholder="Group Name" class="input-group-name" required />
                <textarea placeholder="Describe the group..." name="groupDescription" id="groupDescription" required></textarea>
                <div id="wordCountDisplay" style="margin-top: 5px;">Words: 0</div>
            </div>
            <div class="action-buttons">
                <a href="groups.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Group</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('groupDescription').addEventListener('input', function() {
            var text = this.value.split(/\s+/);
            var wordCount = text.filter(function(n) { return n !== '' }).length;
            document.getElementById('wordCountDisplay').textContent = 'Words: ' + wordCount;
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
