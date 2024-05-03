<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Items</title>
    <style>
        body {
             font-family: "Open Sans", sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .form-cont {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .result-img img {
            max-width: 100px;
            height: auto;
        }

        

    .h1 {
        text-align: center;
        margin-bottom: 15px;
        font-size: 35px;
    }

    label {
        font-weight: bold;
    }

    input[type="text"] {
        padding: 20px;
        width: 400px;
        border: 1px solid #ccc;
        border-radius: 4px;
        transition: border-color 0.3s;
    }

    input[type="text"]:focus {
        border-color: #007bff;
        outline: none;
    }

    input[type="submit"] {
        padding: 20px 40px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }
    .svg-file svg {
        height: 50px;
        width: 50px;
    }
    .container {
            text-align: center;
        }
    @media (max-width: 800px) {
        .container {
            text-align: center;
        }
        .container h1 {
            text-align: center;
        }
        input[type="text"] {
        padding: 10px;
        width: 200px;
        border: 1px solid #ccc;
        border-radius: 4px;
        transition: border-color 0.3s;
    }
        input[type="submit"] {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
        .container label {
            display: none;
    }
}
    </style>
</head>
<body>
   <div class="container">
    <div class="form-cont">
        <form method="POST">
            <br>
            <div class="svg-file">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <span class="h1">Search Items</span>
        </div>
            <input type="text" id="search" name="search" placeholder="Enter keywords...">
            <input type="submit" name="submit" value="Find">
        </form>
    </div>
<?php
$con = new PDO("mysql:host=localhost;dbname=lfis_db", 'root', '');

if (isset($_POST["submit"])) {
    $search = $_POST["search"];
    

    $sql = "SELECT * FROM `item_list` WHERE 1"; // Select items with status 1 (published) and 3
$params = [];


    if (!empty($search)) {
        $sql .= " AND (title LIKE :search OR description LIKE :search OR fullname LIKE :search)";
        $params[':search'] = '%' . $search . '%';
    }

    $sth = $con->prepare($sql);
    $sth->setFetchMode(PDO::FETCH_OBJ);

    foreach ($params as $key => &$value) {
        $sth->bindParam($key, $value);
    }

    $sth->execute();

    if ($sth->rowCount() > 0) {
?>

        <h1 class="pageTitle text-center titleTxt">Search Results</h1>
        <hr class="mx-auto bg-primary border-primary opacity-100" style="width:50px">
        <div class="container">
            <div class="row">
                <?php while ($row = $sth->fetch()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <a href="<?= base_url.'?page=items/view&id='.$row->id ?>">
                                <img src="<?= $row->image_path ?>" class="card-img-top" alt="Item Image">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title"><?= $row->title ?></h5>
                                <p class="card-text"><?= $row->description ?></p>
                                <a href="<?= base_url.'?page=items/view&id='.$row->id ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
<?php
} else {
    // Define the path to your SVG icon
    $iconPath = "uploads/items/no-results.png";
    
    // Output the message with the SVG icon and adjust height and width
    echo "<p style='text-align: center;'>Results not found <img src='$iconPath' alt='Icon' style='height: 200px; width: 200px;' /></p>";
}
}
?>





   
 


<?php 
if(isset($_GET['cid'])){
    $category_qry = $conn->query("SELECT * FROM `category_list` where `id` = '{$_GET['cid']}'");
    if($category_qry->num_rows > 0){
        foreach($category_qry->fetch_assoc() as $k => $v){
            $cat[$k] = $v; 
        }
    }
}
?>
<h1 class="pageTitle text-center titleTxt">Missing Items</h1>
<div class="icon-1">
<svg   fill="#000000" height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <path d="M59.179,185.707c2.411,5.355,8.683,7.723,14.101,5.355c5.376-2.411,7.765-8.725,5.355-14.101l-24.363-54.165 c-2.411-5.355,0-11.691,5.333-14.101l97.301-43.755c2.624-1.173,5.525-1.259,8.149-0.256c2.667,1.003,4.779,3.008,5.931,5.589 l51.904,115.413c1.813,3.968,5.696,6.315,9.771,6.315c1.451,0,2.944-0.299,4.373-0.939c5.376-2.411,7.765-8.725,5.355-14.101 L190.485,61.547c-3.52-7.787-9.835-13.76-17.835-16.789c-8-3.029-16.683-2.752-24.469,0.747L50.88,89.259 c-16.085,7.232-23.275,26.219-16.043,42.304L59.179,185.707z"></path> <path d="M285.931,184.341c1.323,4.544,5.504,7.659,10.219,7.659h175.68c4.736,0,8.896-3.115,10.219-7.659l18.816-64 c1.536-5.248-1.131-10.816-6.187-12.885c-5.077-2.027-10.88,0.021-13.44,4.843C477.141,120.021,459.563,128,437.333,128 c-24.427,0-42.667-11.264-42.667-21.333v-64C394.667,19.136,375.531,0,352,0c-23.531,0-42.667,19.136-42.667,42.667v10.667 C309.333,59.221,314.112,64,320,64s10.667-4.779,10.667-10.667V42.667c0-11.755,9.579-21.333,21.333-21.333 s21.333,9.579,21.333,21.333v64c0,10.069-18.24,21.333-42.667,21.333c-22.229,0-39.808-7.979-43.925-15.701 c-2.56-4.821-8.427-6.827-13.44-4.843c-5.056,2.069-7.723,7.637-6.187,12.885L285.931,184.341z"></path> <path d="M490.667,213.333H21.333c-5.888,0-10.667,4.779-10.667,10.667v192c0,52.928,43.072,96,96,96h298.667 c52.928,0,96-43.072,96-96V224C501.333,218.112,496.555,213.333,490.667,213.333z M263.467,444.8 c-1.92,2.133-4.693,3.2-7.467,3.2c-2.773,0-5.547-1.067-7.467-3.2c-2.133-1.92-3.2-4.693-3.2-7.467 c0-2.773,1.067-5.547,3.2-7.467c4.053-4.053,10.88-4.053,14.933,0c2.133,1.92,3.2,4.693,3.2,7.467 C266.667,440.107,265.6,442.88,263.467,444.8z M266.709,376.299l-0.021,18.368c0,5.888-4.779,10.667-10.667,10.667 c-5.888,0-10.667-4.8-10.667-10.667L245.376,368c0-4.864,3.285-9.109,8-10.304l2.368-0.576 C271.701,353.451,288,347.115,288,328.021c0-16.171-14.357-29.333-32.021-29.333c-16.896,0-30.955,12.075-32,27.52 c-0.405,5.888-5.163,10.283-11.371,9.92c-5.867-0.405-10.325-5.483-9.92-11.371c1.813-26.603,25.237-47.424,53.312-47.424 c29.419,0,53.355,22.72,53.355,50.667C309.355,351.979,295.019,368.192,266.709,376.299z"></path> <path d="M78.528,113.109c-5.888,0-10.56,4.779-10.56,10.667s4.885,10.667,10.773,10.667s10.667-4.779,10.667-10.667 s-4.779-10.667-10.667-10.667H78.528z"></path> </g> </g> </g> </g></svg>
</div>
<hr class="mx-auto bg-primary border-primary opacity-100" style="width:50px">
<div class="container-sm">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-12 col-12">
            <h3>Item Category</h3>
            <div class="list-group">
                <?php 
                $qry = $conn->query("SELECT * FROM `category_list` where `status` = 1");
                while($row = $qry->fetch_assoc()):
                ?>
                <a href="<?= base_url.'?page=items&cid='.$row['id'] ?>" class="list-group-item list-group-item-action<?= (isset($_GET['cid']) && $_GET['cid'] == $row['id']) ? ' active': '' ?>"><?= $row['name'] ?></a>
                <?php endwhile; ?>
            </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12 col-12">
        <?php if(isset($cat['name'])): ?>
            <h3 class="titleTxt"><?= $cat['name'] ?></h3>
        <?php endif; ?>
        <?php if(isset($cat['description'])): ?>
            <div ><?= str_replace("\n", "<br>", htmlspecialchars_decode($cat['description'])) ?></div>
        <?php endif; ?>
            <?php 
            $where = "";
            if(isset($cat['id'])){
                $where = " and `category_id` = '{$cat['id']}'";
            }
            $items = $conn->query("SELECT * FROM `item_list` where `status` = 1 {$where} order by `title` asc")->fetch_all(MYSQLI_ASSOC);
            ?>
            <div id="item-list">
                <?php if(count($items) > 0): ?>
                <?php foreach($items as $row): ?>
                <a href="<?= base_url.'?page=items/view&id='.$row['id'] ?>" class="item-item text-decoration-none text-reset">
                    <div class="card">
                        <div class="item-card-img">
                            <img src="<?= validate_image($row['image_path']) ?>" alt="">
                        </div>
                        <div class="card-body pt-3">
                            <h4 class="card-title"><?= $row['title'] ?></h4>
                            <p class="truncate-3"><?= strip_tags(htmlspecialchars_decode($row['description'])) ?></p>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php if(count($items) <= 0): ?>
                <div class="text-muted text-center">No item Listed Yet</div>
            <?php endif; ?>
        </div>
    </div>
</div>