<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>
			<?=$this->t('lessons', 'back')?>
			<small>
				<?=$this->t('view lessons', 'back')?>
			</small>
		</h1>
      <?php 
          if(isset($breadcrumbs)){ 
            $this->renderBreadcrumbs($breadcrumbs);
          }
      ?>
    </section>

    <!-- Main content -->
    <section class="content">
      
      	<?=$this->renderNotifications($successText, $errorText)?>

      	<div class="row">
	        <div class="col-xs-12">
	          	<div class="box">
		            <div class="box-header">
		              	<h3 class="box-title"><?=$this->t('lesson list', 'back')?></h3>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
		              	<table class="data-table-ajax table table-bordered table-hover" data-ajax-url="<?=$controls['list_ajax']?>" data-order="[[ 4, &quot;desc&quot; ]]">
	                        <thead>
	                            <tr>
	                                <th>ID</th>
	                                <th><?=$this->t('teacher', 'back')?></th>
	                                <th><?=$this->t('student group', 'back')?></th>
	                                <th><?=$this->t('subject', 'back')?></th>
	                                <th><?=$this->t('lesson start time', 'back')?></th>
	                                <th></th>
	                            </tr>
	                        </thead>
	                        <tfoot>
	                            <tr>
	                                <th>ID</th>
	                                <th><?=$this->t('teacher', 'back')?></th>
	                                <th><?=$this->t('student group', 'back')?></th>
	                                <th><?=$this->t('subject', 'back')?></th>
	                                <th><?=$this->t('lesson start time', 'back')?></th>
	                                <th></th>
	                            </tr>
	                        </tfoot>
	                    </table>
		            </div>
		            <!-- /.box-body -->
	          	</div>
	          	<!-- /.box -->

	          
	          <!-- /.box -->
	        </div>
	        <!-- /.col -->
      	</div>
      	<!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->