<?php
		if (isset($_FILES['userfile'])) {
			for ($i=0; $i < count($_FILES['userfile']['name']); $i++) {
					$file_name = $_FILES['userfile']['name'][$i];
					$file_size = $_FILES['userfile']['size'][$i];
					$file_type = $_FILES['userfile']['type'][$i];
					$tmp_name = $_FILES['userfile']['tmp_name'][$i];

					$max_size = 1024 * 100;
					$accepted = array('png','jpg','jpeg');

					if ($file_size > $max_size) {
						echo $file_name.": This file is too large";
					}elseif(!in_array(pathinfo($file_name, PATHINFO_EXTENSION), $accepted))
					{
						echo $file_name." is of type [".$file_type."]. This is extension is not acceptable.<br>";
					}else{
						move_uploaded_file($tmp_name, "blog_media_uploads/".$file_name);
						echo $file_name. " has been uploaded successfully"
					}
			}
		}else{
			echo "Something went wrong".error_get_last();
		}
?>
