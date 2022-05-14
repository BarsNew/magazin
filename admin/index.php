<?php


header('content-Type: text/html; charset=utf-8');


error_reporting(E_ALL);

if (stream_resolve_include_path('config.php')) {
    include_once ('config.php');
	} else {
		die ("Not found file: config.php");
	}

if (stream_resolve_include_path('language/'.$config["language"].'.lng') )
{
	require_once 'language/'.$config["language"].'.lng';
}
else {
	require_once 'language/en.lng';
	echo 'Not found language/'.$config["language"].'.lng';

}
define ('ROOT', $config["rootdirectory"].'/' );

//............. tree .........................................
	function tree($path)
	{
    if( stream_resolve_include_path($path)) {
	
	$files = scandir($path);
	
	natcasesort($files);
	
    $files2 = array();
	
    echo '<ul>';
	
	if( count($files) > 2 ) {
		
		
		foreach( $files as $file ) {
			
			if(stream_resolve_include_path($path . $file) && $file != '.' && $file != '..') {
				
			 
			if  (filetype($path.$file)=='dir') {
			// if folder
			sub($file, $path);
			}else {
			//if files
					$files2[$file] = $file;
					
				}
		}
		}
//	}
					foreach ($files2 as $file) {
					
				if($file) {
				
        $ext = strtolower(preg_replace('/^.*\./', '', $file));			
		echo '<li class="ext-file ext-'.$ext.'">'.$file.'</li>';
		       }
		       } 
}
		echo "</ul>";	
	

}
}

	function sub($dir, $path)
	{
		echo '<li><div id="'.$dir.'" data-fo="'.$path.$dir.'/'.'" class="fo closed">'.$dir.'</div>';
		tree($path.$dir.'/');
		echo '</li>';
	}
//................. end tree ...................................
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Filemanager Abashy - simple web filemanager with php, codemirror, jquery. Abashy. Файловый менеджер, браузер файлов для сайта на Php и Jquery.</title>	
    <meta name="description" content="Простой файловый менеджер, файловый браузер с загрузкой файлов, редактор с подсветкой синтаксиса" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="font-awesome.min.css">
</head>

<body>

<button><a class="ab-btn asphalt mar" href='/admin/categories_list.php'>Редактировать категории</a></button>
<button><a class="ab-btn asphalt mar" href='/admin/pages_list.php'>Редактировать страницы</a></button>
<button><a class="ab-btn asphalt mar" href='/admin/posts_list.php'>Редактировать связи постов</a></button>
<button><a class="ab-btn asphalt mar" href='/admin/clients_list.php'>Обращения и заказы</a></button>

<div id="page-preloader"><span id="spinner">Loading ...</span></div>
<div class="ab-container ab-filemanager" id="ab-main">

<div id="ab-content" class="ab-row">

<!-- breadcrumb -->	        	
	<div class="ab-col12" id="ab-breadcrumb">
<div id="breadcrumb-links" class="ab-col7">
<span class="open"><?php echo ROOT ?> </span>

	</div>
	    <div id="ab-top-action-btn" class="ab-col5 ab-text-right">
	<a id="a-create-folder" class="ab-btn asphalt" title="<?php echo $lang['create_folder_here'] ?>" href="#"><i class="fa fa-folder-o" aria-hidden="true"></i> </a>

	  <button id="createfile" class="ab-btn asphalt" title="<?php echo $lang['create_file_here'] ?>"><i class="fa fa-file-text-o" aria-hidden="true"></i></button>

	<div id="div-uploadfile" class="ab-btn asphalt fa fa-upload" title="<?php echo $lang['upload_file_here'] ?>">
				<form id="frm-uploadfile" name="frm-uploadfile" enctype="multipart/form-data">	
					<input type="file" id="file" name="file[]" multiple="multiple">
					<input type="hidden" id="inputpath" name="inputpath">
				</form>
	</div>

<a id="zipsite" class="ab-btn asphalt" title="<?php echo $lang['zip_and_download_site'] ?>"  href="downloadfolder.php?file=<?php echo ROOT ?>"><i class=" fa fa-download" aria-hidden="true"></i></a>	
<a class="ab-btn asphalt" title="<?php echo $lang['general_settings'] ?>"  href="editor.php?editfile=config.php" target="_blank"><i class=" fa fa-cog" aria-hidden="true"></i></a>		  
	  
	</div>
	</div>

<!-- left panel ........................................... -->

<div id="leftpanel" class="ab-col4">
<div id="tree">

<div id="home" data-fo="<?php echo ROOT  ?>" class="closed selected">
<?php echo basename(ROOT)  ?>
</div>
<!-- tree  -->
<?php tree(ROOT); ?>

</div>
</div>	

<!-- table data ........................................... -->

<div class="ab-col8" id="ab-container-table">
    <!-- ajax data here.. -->
</div>

</div>

            <div class="ab-row">
                <div id="ab-copy" class="ab-col12 ab-text-center"> <small> Admin panel</small> </div>
            </div>

    </div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
	<script>
	if (typeof jQuery == 'undefined') {
	  document.write(unescape("%3Cscript src='jquery.js' type='text/javascript'%3E%3C/script%3E"));
	}</script>
	<script src="script.js"></script>

<script>
	$(document).ready(function($)
    {
	
//showtable
	function showtable(folder) {

	$.post('showtable.php', { dir: folder}, function(data) {
						
	$('#ab-container-table').html('').append(data);

	});
	}
	
	showtable('<?php echo ROOT  ?>');
	
	//.................. loader, start page ....................	
    var $preloader = document.getElementById("page-preloader"),
        $spinner   = document.getElementById("spinner");
        $spinner.className += " hidden";
        $preloader.className += " hidden";

	});
	</script>
	
</body>
</html>