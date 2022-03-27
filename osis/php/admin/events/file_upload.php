<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="" method="POST" enctype="multipart/form-data">
	 <input type="file" name="userfile[]" value="" multiple>
	 <input type="submit" name="submit" value="upload">
	</form>

	<?php
		$phpFileUploadErrors = array(
			0=> 'There is no error, the file uploaded with success',
			1=> 'The uploaded exceeds the upload_max_filesize directive in php.ini',
			2=> 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
			3=> 'The uploaded file was only partially uploaded',
			4=> 'No file was uploaded',
			6=> 'Missing a temporary folder',
			7=> 'Failed to write file to disk',
			8=> 'A PHP extension stopped the file upload'
		);

		if(isset($_FILES['userfile'])){

			$file_array = reArrayFiles($_FILES['userfile']);
			pre_r($_FILES['userfile']);

			for ($i=0; $i < count($file_array); $i++) {
				if($file_array[$i]['error']) {
					echo $file_array[$i]['name'].': '.$phpFileUploadErrors[$file_array[$i]['error']];
				}else{
					$extensions = array('jpg', 'png', 'gif','jpeg');
					$file_ext = explode('.',$file_array[$i]['name']);
					$file_ext = end($file_ext);

					if (!in_array($file_ext, $extensions)) {
						echo "{$file_array[$i]['name']} - Invalid file extension<br>";
					}

					else{
						move_uploaded_file($file_array[$i]['tmp_name'], "blog_media_uploads/".$file_array[$i]['name']);
						echo $file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']].'<br>';
					}
				}
			}


		}

		function reArrayFiles($file_post){
			$file_ary = array();
			$file_count = count($file_post['name']);
			$file_keys = array_keys($file_post);

			for($i=0; $i<$file_count; $i++){
				foreach($file_keys as $key){
					$file_ary[$i][$key] = $file_post[$key][$i];
				}
			}

			return $file_ary;
		}

		function pre_r($array){
			echo '<pre>';
			print_r($array);
			echo '</pre>';
		}
	 ?>

</body>
</html>
