<?php
if(isset($_POST['submit']))
{
    include_once 'db.php';

    $names = $_POST['names'];
    $given_license = $_POST['license'];
    $license_category = $_POST['license_category'];
    $gender = $_POST['gender'];

    if(empty($names) || empty($given_license) || empty($license_category))
    {
        header("location: index.php?msg=empty_fields");
        exit();
    }

    $given_license_2 = str_replace(' ', '', $given_license);
    $license = str_replace('-', '', $given_license_2);

    if(strlen($license) != 16)
    {
        header("location: index.php?msg=invalid_license");
        exit();
    }

    $sql_check = "SELECT * FROM drivers WHERE license = '$license';";
    $result = mysqli_query($conn, $sql_check);
    if(mysqli_num_rows($result) > 0)
    {
        header("location: index.php?msg=already_exists");
        exit();
    }

    

    if(isset($_FILES['image'])){
        $img_name = $_FILES['image']['name'];
        $img_type = $_FILES['image']['type'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $img_explode = explode('.',$img_name);
        $img_ext = end($img_explode);
        $extensions = ["jpeg", "png", "jpg", "JPEG", "PNG", "JPG"];
        if(in_array($img_ext, $extensions) === true)
        {
            $types = ["image/jpeg", "image/jpg", "image/png"];
            if(in_array($img_type, $types) === true){
                $new_img_name = uniqid('driver_img_') .".". $img_ext;
                if(move_uploaded_file($tmp_name,"driver_images/".$new_img_name))
                {
                    ///


                    $sql = "INSERT INTO drivers (names, license, gender, license_category, driver_image) VALUES('$names', '$license', '$gender', '$license_category', '$new_img_name');";
                    mysqli_query($conn, $sql);
                    header("location: index.php?msg=added");
                    exit();

                    ///
                }
                header("location: index.php?msg=moving_img_failed");
                exit();
            }
            header("location: index.php?msg=invalid_img_type");
            exit();
        }
        header("location: index.php?msg=invalid_img_extension");
        exit();
    }
    else
    {
        header("location: index.php?msg=empty_image");
        exit();
    }






}
else
{
    header("location: index.php?msg=redirected");
    exit();
}