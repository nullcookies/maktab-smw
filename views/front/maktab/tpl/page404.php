<article class="content">
    <div class="error-card global">
        <div class="error-title-block">
            <h1 class="error-title">404</h1>
            <h2 class="error-sub-title">
            	<?=$this->translation('sorry, page not found')?>
            </h2>
        </div>
        <div class="error-container">
            <p>
	    		<span>
	    			<?=$this->translation('use search')?>
	    		</span>
            </p>
            <div class="row">
                <div class="col-12">
                	<form action="<?=$searchAction?>" method="post">
	                    <div class="input-group">
	                        <input type="text" class="form-control" name="search">
	                        <span class="input-group-append">
	                            <button class="btn btn-primary" type="button">Search</button>
	                        </span>
	                    </div>
                    </form>
                </div>
            </div>
            <br>
            <a class="btn btn-primary" href="<?=$homeUrl?>">
	    		<i class="fa fa-angle-left"></i>
	    		<?=$this->translation('go home')?>
	    	</a>
        </div>
    </div>
</article>