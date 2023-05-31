 <?php
    //Connection to base
        $con = mysqli_connect("localhost", "root", "", "image") or die();


        if(isset($_POST['upload'])){
            // Getting file name
            $filename = $_FILES['imagefile']['name'];
            // Valid extension
            $valid_ext = array('png','jpeg','jpg');
            // Location
            $location = "images/".$filename;
            // file extension
            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);
            // Check extension
            if(in_array($file_extension,$valid_ext)){  
                // Compress Image
                if(compressImage($_FILES['imagefile']['tmp_name'],$location,20)){
                    //   Do nothing;
                }else{
                    //Send data to base
                     $query = $con->query("INSERT INTO image(name) VALUES('$filename')");
                     if ($query) {
                         echo("Image Posted and Compressed");
                     }
                };

                }else{
                    echo "Invalid file type.";
                }
            }

        // Compress image
        function compressImage($source, $destination, $quality) {

            $info = getimagesize($source);

            if ($info['mime'] == 'image/jpeg') 
                $image = imagecreatefromjpeg($source);

            elseif ($info['mime'] == 'image/gif') 
                $image = imagecreatefromgif($source);

            elseif ($info['mime'] == 'image/png') 
                $image = imagecreatefrompng($source);

            imagejpeg($image, $destination, $quality);

        }

        function imagemb($url)
        {
            $image = get_headers($url, 1);
            $bytes = $image["Content-Length"];
            $mb = $bytes/(1024 * 1024);
            echo number_format($mb,2) . " MB";
        }


        //Compress on the go
        function compressImageonthego($source, $quality) {
            $info = getimagesize($source);
            $extension = explode(".",$source);

            $newname = "temp".rand(10,100);

            if ($info['mime'] == 'image/jpeg') 
                $image = imagecreatefromjpeg($source);

            elseif ($info['mime'] == 'image/gif') 
                $image = imagecreatefromgif($source);

            elseif ($info['mime'] == 'image/png') 
                $image = imagecreatefrompng($source);

            imagejpeg($image, "images/".$newname.".".$extension[1] ,$quality);

          echo "<b>".$newname.".".$extension[1]."</b>";

        }

    ?>

<!doctype html>
<html>
    <head>
        <style type="text/css">
            .image{
                margin-left: auto;
    margin-right: auto;
    width: 50%;
    text-align: center;
    background: lightgrey;
    padding: 20px;
    border: 5px solid gainsboro;
            }

            .image input[type="submit"]{
                width: 100%;
    margin: 9px;
    background: grey;
    padding: 12px;
    outline: none;
    border: none;
    color: white;
            }
            .image input[type="file"]{
                    width: 50%;
    margin: 10px;
    background: grey;
    color: white;
            }

            img {
    border: 5px solid white;
    box-sizing: border-box;
    box-shadow: 0px 3px 8px 2px grey;
    margin-bottom: 10px;
}
        </style>
    </head>
	<body>
        <h2 align="center">Image Compressor using PHP</h2>
        <div class="image">
		
        <!-- Upload form -->
        <form method='post' action='' enctype='multipart/form-data'>
            <input type='file' name='imagefile' >
            <input type='submit' value='Compress' name='upload'>    
        </form>
        </div>
        <script type="text/javascript">
           console.log("<?php 
           echo('Hello PHP')
       ?>") ;
        </script>
	</body>
</html>