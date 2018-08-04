<div id="page404" class="content-block">
	<div class="container-fluid">
	    <div style="text-align: center;margin-top: 10%;">
		    <h1 style="margin-bottom:20px;font-size: 50px;">
		    	<a style="color:#333" href="<?=$homeUrl?>">404</a>
		    </h1>
		    <div style="text-transform: uppercase;margin-bottom: 30px;">
		        <i class="fa fa-warning"></i>
		        <?=$this->translation('404 not found')?>
		    </div>
		    <div>
		    	<div style="margin-bottom:10px;">
		    		<a href="<?=$homeUrl?>">
		    			<?=$this->translation('go home')?>
		    		</a>
		    		<span>
		    			<?=$this->translation('or')?>
		    			<?=$this->translation('use search')?>
		    		</span>
		    	</div>
		    	<form style="max-width:290px;margin:0 auto;" action="<?=$searchAction?>" method="post">
		    		<div class="input-group">
		    			<input class="form-control" type="text" name="search">
		    			<span class="input-group-btn">
		    				<button class="btn btn-default" type="submit">
		    					<i class="fa fa-search"></i>
		    				</button>
		    			</span>
		    		</div>
		    	</form>
		    </div>
	    </div>
	</div>
</div>