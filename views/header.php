<!DOCTYPE html>
<html lang="en">

	<head>
		<title>TEMPLATE</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta charset="utf-8">

		<!-- Some styles here: bootstrap, and custom -->
		<link href="<?php _e(URL); ?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php _e(URL); ?>public/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
      
      	<script type="text/javascript" src="<?php _e(URL); ?>public/common/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="<?php _e(URL); ?>public/bootstrap/js/bootstrap.min.js"></script>
		
		
		<?php if(session::get('logged') != TRUE): ?>
			<link href="<?php _e(URL); ?>public/custom/customcss.css" rel="stylesheet">
		<?php endif ?>
		
	</head>      
      
	<body>
	  
      <div class="container">
      	<div class="row-fluid">
			      	
      	<?php if(session::get('logged') == TRUE): ?>
         <div class="masthead">
           <h3 class="muted">SOMETHING SOMETHING</h3>
           <div class="navbar">
             <div class="navbar-inner">
               <div class="container">
                 <ul class="nav">
                   <li><a href="<?php _e(URL) ?>index">Home</a></li>
                   <li><a href="<?php _e(URL) ?>product">Product List</a></li>
                   <li class="dropdown">
                		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Inventory<b class="caret"></b></a>
                		<ul class="dropdown-menu">
                  			<li><a href="#">View</a></li>	
                  			<li class="divider"></li>
                  			<li><a href="#">Update</a></li>
                  			
                		</ul>
              		</li>					
                   <li class="dropdown">
                		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Invoice <b class="caret"></b></a>
                		<ul class="dropdown-menu">
                  			<li><a href="#">Create</a></li>
                  			<li class="divider"></li>
                  			<li><a href="#">Search</a></li>
                		</ul>
              		</li>              		
                   
                   <li><a href="<?php _e(URL) ?>index/logout">Logout</a></li>
                 </ul>
               </div>
             </div>
           </div><!-- /.navbar -->
         </div>
         
      <?php endif ?>
			<?php if (isset($this->_alert)): ?>
				<div class="alert alert-<?php _e($this->_alert); ?>">
					<button data-dismiss="alert" class="close" type="button">x</button>
					<?php _e($this->_alertMsg); ?>
				</div>
			<?php endif; ?>         
          