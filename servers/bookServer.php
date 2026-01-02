<?php


include '../db.php';
if (isset($_POST['save'])) {
    $book_title = $_POST['book_title'];
    $isbn = $_POST['isbn'];
    // $image = $_POST['book_cover'];
    $category = $_POST['category'];
    $publisher = $_POST['publisher'];
    $total_copies = $_POST['total_copies'];
    $author = $_POST['author'];
    $location = $_POST['locationb'];
    $publish_year = $_POST['publish_year'];

    // if (
    //     !ctype_digit($author) ||
    //     !ctype_digit($category) ||
    //     !ctype_digit($publisher) ||
    //     !ctype_digit($location)
    // ) {
    //     die("Invalid foreign key value");
    // }


    //image
    $imageName = '';
    if (!empty($_FILES['book_cover']['name'])) {
        $imageName = time() . '-' . $_FILES['book_cover']['name'];
        move_uploaded_file($_FILES['book_cover']['tmp_name'], "../assets/images/$imageName");
    }

    $query = "INSERT INTO books (category_id, author_id, publisher_id, location_id, title, isbn, quantity, cover_image, publish_year)
  VALUES ('$category', '$author', '$publisher', '$location', '$book_title', '$isbn', '$total_copies', '$imageName','$publish_year')";
    mysqli_query($conn, $query);
    header("Location: book.php");
    exit();
}


//edit
$updateDate = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $getSingleBook = "SELECT * FROM books WHERE id = $editId";
    $resBook = mysqli_query($conn, $getSingleBook);
    $updateDate = mysqli_fetch_assoc($resBook);
}

//update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $book_title = $_POST['book_title'];
    $isbn = $_POST['isbn'];
    // $image = $_POST['book_cover'];
    $category = $_POST['category'];
    $publisher = $_POST['publisher'];
    $total_copies = $_POST['total_copies'];
    $author = $_POST['author'];
    $location = $_POST['locationb'];
    $publish_year = $_POST['publish_year'];

    // if (
    //     !ctype_digit($author) ||
    //     !ctype_digit($category) ||
    //     !ctype_digit($publisher) ||
    //     !ctype_digit($location)
    // ) {
    //     die("Invalid foreign key value");
    // }


    //image
    // $imageName = '';
    // if (!empty($_FILES['book_cover']['name'])) {
    //     $imageName = time() . '-' . $_FILES['book_cover']['name'];
    //     move_uploaded_file($_FILES['book_cover']['tmp_name'], "../assets/images/$imageName");
    // }

    $query = "UPDATE books SET category_id = '$category', author_id = '$author', publisher_id = '$publisher', location_id = '$location', title = '$book_title', isbn = '$isbn', quantity = '$total_copies', publish_year = '$publish_year' WHERE id = '$id'";
    mysqli_query($conn, $query);
    header("Location: book.php");
    exit();
}

//delete
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $qry = "DELETE FROM books WHERE id = '$deleteId'";
    mysqli_query($conn, $qry);

    header("Location: book.php");
    exit();
}


// =========  Geting the data from db  ===============//

$getAuthor = "select id, name from authors";
$getCategory = "select id, name from categories";
$getPublishers = "select id, name from publishers";
$getLocations = "select id, location_code  from book_locations";

// running the query 
$resCategories = mysqli_query($conn, $getCategory);
$resLocations = mysqli_query($conn, $getLocations);
$resPublisher = mysqli_query($conn, $getPublishers);
$resAuthor = mysqli_query($conn, $getAuthor);

//fetching the query
$authors = mysqli_fetch_all($resAuthor, MYSQLI_ASSOC);
$categories = mysqli_fetch_all($resCategories, MYSQLI_ASSOC);
$locations = mysqli_fetch_all($resLocations, MYSQLI_ASSOC);
$publishers = mysqli_fetch_all($resPublisher, MYSQLI_ASSOC);



$getBooks = "SELECT books.id, books.title, books.isbn, books.quantity, books.publish_year, books.cover_image, publishers.name as publisher_name, authors.name as author_name, categories.name as category_name FROM books LEFT JOIN authors ON books.author_id = authors.id LEFT JOIN categories ON books.category_id = categories.id LEFT JOIN publishers ON books.publisher_id = publishers.id where 1=1 ";
$resBooks = mysqli_query($conn, $getBooks);
$books = mysqli_fetch_all($resBooks, MYSQLI_ASSOC);
