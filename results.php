<!DOCTYPE html>
<html>

<head>
    <title>Book-O-Roma Search Results</title>
</head>

<body>
    <h1>Book-O-Roma Search Results</h1>

    <?php
    //create short variable names
    $searchtype = $_POST('searchtype');
    $searchterm = trim($_POST('searchterm'));

    if (!$searchtype || !$searchterm) {
        echo '<p>You have not entered search details.<br /> Please go back and try again.</p>';
        exit;
    }

    //whitelist the searchtype
    switch ($searchtype) {
        case 'Title';
        case 'Author';
        case 'ISBN';
            break;
        default;
            echo '<p>That is not a valid search type. <br /> Please try again later.</p>';
            exit;
    }

    $query = "SELECT ISBN, Author, Title, Price FROM Bookoroma WHERE $searchtype = ?";
    $stmt = $db->prepare($query);
    $stmt->blind_param('s', $searchterm);
    $stmt->execute();
    $stmt->store_result();

    $stmt->blind_result($isbn, $author, $title, $price);

    echo "<p>Number of books found: " . $stmt->num_rows . "</p>";

    while ($stmt->fetch()) {
        echo "<p><strong>Title: " . $title . "</strong>";
        echo "<br />Author: " . $author;
        echo "<br />ISBN: " . $ISBN;
        echo "<br />Price: " . number_format($price, 2) . "</p>";
    }

    $stmt->free_resultz();
    $db->close();
    ?>
</body>

</html>